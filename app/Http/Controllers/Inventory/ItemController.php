<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\{UpdateItemRequest, StoreItemRequest};
use App\Models\Inventory\{Item, DetailItem};
use Illuminate\Support\Facades\{DB, Storage};
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view item')->only('index', 'tracking', 'getItemAndSupplier', 'generateKode', 'getItemById', 'getAll');
        $this->middleware('permission:create item')->only('create', 'store');
        $this->middleware('permission:edit item')->only('edit', 'update');
        $this->middleware('permission:delete item')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Item::with('category:id,nama', 'unit:id,nama');

            return DataTables::of($query)
                ->addColumn('foto', function ($row) {
                    if ($row->foto == null) {
                        return 'https://via.placeholder.com/250?text=No+Image+Available';
                    }

                    return asset("storage/img/item/$row->foto");
                })
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
        DB::transaction(function () use ($request) {
            $attr = $request->validated();
            $attr['category_id'] = $request->category;
            $attr['unit_id'] = $request->unit;
            $attr['stok'] = $request->soh;
            $attr['harga_estimasi'] = $request->harga_estimasi;
            $attr['foto'] = null;
            $attr['is_demorage'] = isset($request->is_demorage) ? 1 : 0;

            if ($request->file('foto') && $request->file('foto')->isValid()) {
                $filename = $request->foto->hashName();

                $request->foto->storeAs('public/img/item/', $filename);

                $attr['foto'] = $filename;
            }

            $item = Item::create($attr);

            if (is_array($request->supplier)) {
                foreach ($request->supplier as $i => $value) {
                    $detailItem[] = new DetailItem([
                        'supplier_id' => $value,
                        'harga_beli' => $request->harga_beli[$i]
                    ]);
                }

                $item->detail_items()->saveMany($detailItem);
            }
        });

        return response()->json(['success'], Response::HTTP_OK);

        // Alert::success('Simpan Data', 'Berhasil');

        // return redirect()->route('item.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $item->load('detail_items', 'detail_items.supplier:id,nama');

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
        DB::transaction(function () use ($request, $item) {
            $item->load('detail_items');

            $attr = $request->validated();
            $attr['category_id'] = $request->category;
            $attr['unit_id'] = $request->unit;
            $attr['stok'] = $request->soh;
            $attr['harga_estimasi'] = $request->harga_estimasi;
            $attr['is_demorage'] = isset($request->is_demorage) ? 1 : 0;

            if ($request->file('foto') && $request->file('foto')->isValid()) {
                // delete old foto from storage
                Storage::delete('public/img/item/' . $item->foto);

                $filename = $request->foto->hashName();

                $request->foto->storeAs('public/img/item/', $filename);

                $attr['foto'] = $filename;
            }

            $item->detail_items()->delete();
            $item->update($attr);

            if (is_array($request->supplier)) {
                foreach ($request->supplier as $i => $value) {
                    $detailItem[] = new DetailItem([
                        'supplier_id' => $value,
                        'harga_beli' => $request->harga_beli[$i]
                    ]);
                }

                $item->detail_items()->saveMany($detailItem);
            }
        });

        return response()->json(['success'], Response::HTTP_OK);

        // Alert::toast('Update data berhasil', 'success');

        // return redirect()->route('item.index');
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

    /**
     * Get item and supplier by item id & supplier id
     *
     * @param int $itemId
     * @param int $supplierId
     * @return \Illuminate\Http\Response
     */
    public function getItemAndSupplier(int $itemId, int $supplierId)
    {
        abort_if(!request()->ajax(), 403);

        $item = DetailItem::with(
            'item:id,unit_id,kode,nama,stok',
            'item.unit:id,nama'
        )
            ->select('id', 'item_id', 'harga_beli', 'supplier_id')
            ->where(['item_id' => $itemId, 'supplier_id' => $supplierId])
            ->first();

        if (empty($item)) {
            $item = Item::with('unit:id,nama')
                ->select('id', 'unit_id', 'kode', 'nama', 'stok', 'harga_estimasi')
                ->first($itemId);

            return response()->json(['data' => $item, 'type' => 'without supplier'], 200);
        } else {
            return response()->json(['data' => $item, 'type' => 'with supplier'], 200);
        }
    }

    /**
     * Tracking stok item by id
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function tracking(int $id)
    {
        // 'akun_coa_id',
        $item = Item::select('id', 'category_id', 'unit_id', 'kode', 'nama', 'type', 'stok', 'deskripsi', 'foto')
            ->with(
                'unit:id,nama',
                'category:id,nama',
                // 'akun_coa:id,nama',
                'detail_items',
                'detail_items.supplier:id,nama',

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

        return view('inventory.item.tracking', compact('item'));
    }

    /**
     * Generate unique & auto increment code by total items.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateKode()
    {
        // kalo diakses lewat browser/url/bukan ajax
        abort_if(!request()->ajax(), 403);

        $latestItem = Item::orderByDesc('id')->first();
        $kode = 'IT-MJS-' . str_pad((int) $latestItem->id + 1, 4, "0", STR_PAD_LEFT);

        return response()->json(['kode' => $kode], 200);
    }

    /**
     * Get item by supplier id
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getItemBySupplier(int $id)
    {
        abort_if(!request()->ajax(), 403);

        // $item = DetailItem::select('id', 'item_id', 'supplier_id')
        //     ->with('item:id,kode,nama')
        //     ->whereHas('item', function($q){
        //         $q->orderBy('nama');
        //     })
        //     ->where('supplier_id', $id)
        //     ->get();

        $item = DB::table('items')
            ->select('items.id', 'items.kode', 'items.nama', 'detail_items.id', 'detail_items.item_id', 'detail_items.supplier_id',)
            ->join('detail_items', 'detail_items.item_id', '=', 'items.id')
            ->join('suppliers', 'suppliers.id', '=', 'detail_items.supplier_id')
            ->where('detail_items.supplier_id', $id)
            ->orderBy('items.nama')
            ->get();

        return response()->json($item, 200);
    }

    /**
     * Get item by id
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getItemById($id)
    {
        abort_if(!request()->ajax(), 403);

        $item = Item::with('unit:id,nama')
            ->select('id', 'unit_id', 'kode', 'nama', 'stok', 'is_demorage')
            ->findOrFail($id);

        return response()->json($item, 200);
    }

    /**
     * Get all items
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        abort_if(!request()->ajax(), 403);

        $item = Item::select('id', 'kode', 'nama')
            ->get();

        return response()->json($item, 200);
    }
}
