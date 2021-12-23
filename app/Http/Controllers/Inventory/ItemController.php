<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\{UpdateItemRequest, StoreItemRequest};
use App\Models\Inventory\BacTerima;
use App\Models\Inventory\Item;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Item::with(
                'category:id,nama',
                'unit:id,nama',
                'akun_coa:id,nama'
            );

            return DataTables::of($query)
                ->addColumn('foto', function ($row) {
                    return asset("storage/img/item/$row->foto");
                })
                ->addColumn('category', function ($row) {
                    return $row->category->nama;
                })
                ->addColumn('akun_coa', function ($row) {
                    return $row->akun_coa->nama;
                })
                ->addColumn('unit', function ($row) {
                    return $row->unit->nama;
                })
                ->addColumn('action', 'inventory.item._action')
                ->toJson();
        }

        return view('inventory.item.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request)
    {
        $attr = $request->validated();
        $attr['category_id'] = $request->category;
        $attr['unit_id'] = $request->unit;
        $attr['akun_coa_id'] = $request->akun_coa;

        if ($request->file('foto') && $request->file('foto')->isValid()) {
            $filename = time()  . '.' . $request->foto->extension();

            $request->foto->storeAs('public/img/item/', $filename);

            $attr['foto'] = $filename;
        }

        Item::create($attr);

        Alert::success('Simpan Data', 'Berhasil');

        return redirect()->route('item.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('inventory.item.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $attr = $request->validated();
        $attr['category_id'] = $request->category;
        $attr['unit_id'] = $request->unit;
        $attr['akun_coa_id'] = $request->akun_coa;
        $attr['foto'] = $item->foto;

        if ($request->file('foto') && $request->file('foto')->isValid()) {
            // delete old foto from storage
            Storage::delete('public/img/item/' . $item->foto);

            $filename = time()  . '.' . $request->foto->extension();

            $request->foto->storeAs('public/img/item/', $filename);

            $attr['foto'] = $filename;
        }

        $item->update($attr);

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('item.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        // delete old foto from storage
        Storage::delete('public/img/item/' . $item->foto);

        $item->delete();

        Alert::toast('Hapus data berhasil', 'success');

        return redirect()->route('item.index');
    }

    public function getItemById($id)
    {
        abort_if(!request()->ajax(), 403);

        $item = Item::with('unit:id,nama')
            ->select('id', 'unit_id', 'kode', 'nama', 'stok')
            ->findOrFail($id);

        return response()->json($item, 200);
    }

    public function tracking($id)
    {
        $item = Item::select('id', 'category_id', 'akun_coa_id', 'unit_id', 'kode', 'nama', 'type', 'stok', 'deskripsi', 'foto')
            ->with(
                'unit:id,nama',
                'category:id,nama',
                'akun_coa:id,nama',

                'detail_bac_pakai:id,bac_pakai_id,item_id,qty,qty_validasi',
                'detail_bac_pakai.bac_pakai:id,user_id,kode,tanggal,status',
                'detail_bac_pakai.bac_pakai.aso:id,bac_pakai_id,validasi_by,tanggal_validasi',
                'detail_bac_pakai.bac_pakai.aso.divalidasi_oleh:id,name',

                'detail_bac_terima:id,bac_terima_id,item_id,qty,qty_validasi',
                'detail_bac_terima.bac_terima:id,user_id,kode,tanggal,status',
                'detail_bac_terima.bac_terima.received:id,bac_terima_id,validasi_by,tanggal_validasi',
                'detail_bac_terima.bac_terima.received.divalidasi_oleh:id,name'
            )
            ->findOrFail($id);

        // return $item;
        // die;

        return view('inventory.item.tracking', compact('item'));
    }
}
