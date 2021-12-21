<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\{UpdateItemRequest, StoreItemRequest};
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
                'akun_beban:id,nama',
                'akun_retur_pembelian:id,nama',
                'akun_retur_penjualan:id,nama',
                'akun_penjualan:id,nama',
            );

            return DataTables::of($query)
                ->addColumn('foto', function ($row) {
                    return asset("storage/img/item/$row->foto");
                })
                ->addColumn('category', function ($row) {
                    return $row->category->nama;
                })
                ->addColumn('akun_beban', function ($row) {
                    return $row->akun_beban->nama;
                })
                ->addColumn('akun_retur_pembelian', function ($row) {
                    return $row->akun_retur_pembelian->nama;
                })
                ->addColumn('akun_penjualan', function ($row) {
                    return $row->akun_penjualan->nama;
                })
                ->addColumn('akun_retur_penjualan', function ($row) {
                    return $row->akun_retur_penjualan->nama;
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
        $attr['akun_beban_id'] = $request->akun_beban;
        $attr['akun_retur_pembelian_id'] = $request->akun_retur_pembelian;
        $attr['akun_penjualan_id'] = $request->akun_penjualan;
        $attr['akun_retur_penjualan_id'] = $request->akun_retur_penjualan;

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
        $attr['akun_beban_id'] = $request->akun_beban;
        $attr['akun_retur_pembelian_id'] = $request->akun_retur_pembelian;
        $attr['akun_penjualan_id'] = $request->akun_penjualan;
        $attr['akun_retur_penjualan_id'] = $request->akun_retur_penjualan;
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
        $item->delete();

        Alert::toast('Hapus data berhasil', 'success');

        return redirect()->route('item.index');
    }

    public function getItemById($id)
    {
        abort_if(!request()->ajax(), 403);

        return Item::with('unit:id,nama')
            ->select('id', 'unit_id', 'kode', 'nama', 'stok')
            ->findOrFail($id);
    }
}
