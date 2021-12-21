<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreAsoRequest;
use App\Http\Requests\Inventory\UpdateAsoRequest;
use App\Models\Inventory\Aso;
use App\Models\Inventory\BacPakai;
use App\Models\Inventory\Item;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class AsoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Aso::with('bac_pakai:id,kode', 'divalidasi_oleh:id,name');

            return DataTables::of($query)
                ->addColumn('bac_pakai', function ($row) {
                    return $row->bac_pakai->kode;
                })
                ->addColumn('divalidasi_oleh', function ($row) {
                    return $row->divalidasi_oleh->name;
                })
                ->addColumn('tanggal_validasi', function ($row) {
                    return $row->tanggal_validasi->format('d M Y');
                })
                ->addColumn('action', 'inventory.aso._action')
                ->toJson();
        }

        return view('inventory.aso.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aso = false;
        $show = false;
        return view('inventory.aso.create', compact('aso', 'show'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAsoRequest $request)
    {
        DB::transaction(function () use ($request) {
            Aso::create([
                'bac_pakai_id' => $request->bac_pakai,
                'tanggal_validasi' =>  $request->tanggal,
                'validasi_by' => auth()->id(),
            ]);

            $bacPakai = BacPakai::with(
                'detail_bac_pakai:bac_pakai_id,id,item_id,qty,qty_validasi',
                'detail_bac_pakai.item:unit_id,id,nama,kode',
            )->findOrFail($request->bac_pakai);

            foreach ($bacPakai->detail_bac_pakai as $i => $detail) {
                $detail->update(['qty_validasi' => $request->qty_validasi[$i]]);

                // Update stok barang
                $produkQuery = Item::whereId($detail->item_id);
                $getProduk = $produkQuery->first();
                $produkQuery->update(['stok' => ($getProduk->stok - $request->qty_validasi[$i])]);
            }

            $bacPakai->update(['status' => 'Tervalidasi']);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory\Aso  $aso
     * @return \Illuminate\Http\Response
     */
    public function show(Aso $aso)
    {
        $aso->load(
            'bac_pakai',
            'bac_pakai.user:id,name',
            'bac_pakai.file_bac_pakai:id,bac_pakai_id,nama,file',
            'bac_pakai.detail_bac_pakai.item:id,unit_id,kode,nama,stok',
            'bac_pakai.detail_bac_pakai.item.unit:id,nama'
        );
        $show = true;

        return view('inventory.aso.show', compact('aso', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory\Aso  $aso
     * @return \Illuminate\Http\Response
     */
    public function edit(Aso $aso)
    {
        $aso->load(
            'bac_pakai',
            'bac_pakai.user:id,name',
            'bac_pakai.file_bac_pakai:id,bac_pakai_id,nama,file',
            'bac_pakai.detail_bac_pakai.item:id,unit_id,kode,nama,stok',
            'bac_pakai.detail_bac_pakai.item.unit:id,nama'
        );

        $show = false;

        return view('inventory.aso.edit', compact('aso', 'show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory\Aso  $aso
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAsoRequest $request, Aso $aso)
    {
        $aso->load(
            'bac_pakai',
            'bac_pakai.user:id,name',
            'bac_pakai.file_bac_pakai:id,bac_pakai_id,nama,file',
            'bac_pakai.detail_bac_pakai.item:id,unit_id,kode,nama,stok',
            'bac_pakai.detail_bac_pakai.item.unit:id,nama'
        );

        // kembalikan stok
        foreach ($aso->bac_pakai->detail_bac_pakai as $detail) {
            $produkQuery = Item::whereId($detail->item_id);
            $getProduk = $produkQuery->first();
            $produkQuery->update(['stok' => ($getProduk->stok + $detail->qty)]);
        }

        $aso->bac_pakai()->update(['status' => 'Belum Tervalidasi']);

        DB::transaction(function () use ($request, $aso) {
            $aso->update([
                'bac_pakai_id' => $request->bac_pakai,
                'tanggal_validasi' =>  $request->tanggal,
                'validasi_by' => auth()->id(),
            ]);

            $bacPakai = BacPakai::with(
                'detail_bac_pakai:bac_pakai_id,id,item_id,qty,qty_validasi',
                'detail_bac_pakai.item:unit_id,id,nama,kode',
            )->findOrFail($request->bac_pakai);

            foreach ($bacPakai->detail_bac_pakai as $i => $detail) {
                $detail->update(['qty_validasi' => $request->qty_validasi[$i]]);

                // Update stok barang
                $produkQuery = Item::whereId($detail->item_id);
                $getProduk = $produkQuery->first();
                $produkQuery->update(['stok' => ($getProduk->stok - $request->qty_validasi[$i])]);
            }

            $bacPakai->update(['status' => 'Tervalidasi']);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory\Aso  $aso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aso $aso)
    {
        $aso->load(
            'bac_pakai',
            'bac_pakai.detail_bac_pakai.item:id,unit_id,kode,nama,stok',
            'bac_pakai.detail_bac_pakai.item.unit:id,nama'
        );

        // kembalikan stok
        foreach ($aso->bac_pakai->detail_bac_pakai as $detail) {
            $produkQuery = Item::whereId($detail->item_id);
            $getProduk = $produkQuery->first();
            $produkQuery->update(['stok' => ($getProduk->stok + $detail->qty)]);
        }

        $aso->bac_pakai()->update(['status' => 'Belum Tervalidasi']);

        $aso->delete();

        Alert::toast('Hapus data berhasil', 'success');

        return redirect()->route('aso.index');
    }
}
