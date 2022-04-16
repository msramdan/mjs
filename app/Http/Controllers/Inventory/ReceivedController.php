<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\{StoreReceivedRequest, UpdateReceivedRequest};
use App\Models\Inventory\{Item, BacTerima, NewBacTerima, Received};
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ReceivedController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view received')->only('index', 'show');
        $this->middleware('permission:create received')->only('create', 'store');
        $this->middleware('permission:edit received')->only('edit', 'update');
        $this->middleware('permission:delete received')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Received::with('new_bac_terima:id,kode', 'divalidasi_oleh:id,name');

            return DataTables::of($query)
                ->addColumn('new_bac_terima', function ($row) {
                    return $row->new_bac_terima->kode;
                })
                ->addColumn('divalidasi_oleh', function ($row) {
                    return $row->divalidasi_oleh->name;
                })
                ->addColumn('tanggal_validasi', function ($row) {
                    return $row->tanggal_validasi->format('d M Y');
                })
                ->addColumn('action', 'inventory.received._action')
                ->toJson();
        }

        return view('inventory.received.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $received = false;
        $show = false;
        return view('inventory.received.create', compact('received', 'show'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReceivedRequest $request)
    {
        DB::transaction(function () use ($request) {
            Received::create([
                'new_bac_terima_id' => $request->bac_terima,
                'tanggal_validasi' =>  $request->tanggal,
                'validasi_by' => auth()->id(),
            ]);

            $bac = NewBacTerima::with(
                'new_detail_bac_terima:new_bac_terima_id,id,item_id,qty_validasi',
                'new_detail_bac_terima.item:unit_id,id,nama,kode',
            )->findOrFail($request->bac_terima);

            foreach ($bac->new_detail_bac_terima as $i => $detail) {
                $detail->update(['qty_validasi' => $request->qty_validasi[$i]]);

                // Update stok barang
                $produkQuery = Item::whereId($detail->item_id);
                $getProduk = $produkQuery->first();
                $produkQuery->update(['stok' => ($getProduk->stok + $request->qty_validasi[$i])]);
            }

            $bac->update(['status' => 'Tervalidasi']);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory\Received  $received
     * @return \Illuminate\Http\Response
     */
    public function show(Received $received)
    {
        $received->load(
            'new_bac_terima',
            'new_bac_terima.user:id,name',
            'new_bac_terima.new_file_bac_terima:id,new_bac_terima_id,nama,file',
            'new_bac_terima.new_detail_bac_terima.item:id,unit_id,kode,nama,stok',
            'new_bac_terima.new_detail_bac_terima.item.unit:id,nama'
        );
        $show = true;

        return view('inventory.received.show', compact('received', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory\Received  $received
     * @return \Illuminate\Http\Response
     */
    public function edit(Received $received)
    {
        $received->load(
            'new_bac_terima',
            'new_bac_terima.user:id,name',
            'new_bac_terima.new_file_bac_terima:id,new_bac_terima_id,nama,file',
            'new_bac_terima.new_detail_bac_terima.item:id,unit_id,kode,nama,stok',
            'new_bac_terima.new_detail_bac_terima.item.unit:id,nama'
        );

        $show = false;

        return view('inventory.received.edit', compact('received', 'show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory\Received  $received
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceivedRequest $request, Received $received)
    {
        $received->load(
            'new_bac_terima',
            'new_bac_terima.user:id,name',
            'new_bac_terima.new_file_bac_terima:id,new_bac_terima_id,nama,file',
            'new_bac_terima.new_detail_bac_terima.item:id,unit_id,kode,nama,stok',
            'new_bac_terima.new_detail_bac_terima.item.unit:id,nama'
        );

        // kembalikan stok
        foreach ($received->new_bac_terima->new_detail_bac_terima as $detail) {
            $produkQuery = Item::whereId($detail->item_id);
            $getProduk = $produkQuery->first();
            $produkQuery->update(['stok' => ($getProduk->stok + $detail->qty)]);
        }

        $received->new_bac_terima()->update(['status' => 'Belum Tervalidasi']);

        DB::transaction(function () use ($request, $received) {
            $received->update([
                'new_bac_terima_id' => $request->bac_terima,
                'tanggal_validasi' =>  $request->tanggal,
                'validasi_by' => auth()->id(),
            ]);

            $bac = NewBacTerima::with(
                'new_detail_bac_terima:new_bac_terima_id,id,item_id,qty_validasi',
                'new_detail_bac_terima.item:unit_id,id,nama,kode',
            )->findOrFail($request->bac_terima);

            foreach ($bac->new_detail_bac_terima as $i => $detail) {
                $detail->update(['qty_validasi' => $request->qty_validasi[$i]]);

                // Update stok barang
                $produkQuery = Item::whereId($detail->item_id);
                $getProduk = $produkQuery->first();
                $produkQuery->update(['stok' => ($getProduk->stok + $request->qty_validasi[$i])]);
            }

            $bac->update(['status' => 'Tervalidasi']);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory\Received  $received
     * @return \Illuminate\Http\Response
     */
    public function destroy(Received $received)
    {
        $received->load(
            'new_bac_terima',
            'new_bac_terima.new_detail_bac_terima.item:id,unit_id,kode,nama,stok',
            'new_bac_terima.new_detail_bac_terima.item.unit:id,nama'
        );

        // kembalikan stok
        foreach ($received->new_bac_terima->new_detail_bac_terima as $detail) {
            $produkQuery = Item::whereId($detail->item_id);
            $getProduk = $produkQuery->first();
            $produkQuery->update(['stok' => ($getProduk->stok + $detail->qty)]);
        }

        $received->new_bac_terima()->update(['status' => 'Belum Tervalidasi']);

        $received->delete();

        Alert::toast('Hapus data berhasil', 'success');

        return redirect()->route('received.index');
    }
}
