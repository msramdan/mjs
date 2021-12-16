<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreItemRequest;
use App\Http\Requests\Inventory\UpdateItemRequest;
use App\Models\Inventory\Item;
use PDO;
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
            $query = Item::with('category:id,nama', 'unit:id,nama')->latest('updated_at');

            return DataTables::of($query)
                ->addColumn('category', function ($row) {
                    return $row->category->nama;
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

        Item::create($attr);

        Alert::success('Tambah Data', 'Berhasil');

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
        $item->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

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

        Alert::success('Hapus Data', 'Berhasil');

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
