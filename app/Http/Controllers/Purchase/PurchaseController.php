<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Item;
use App\Models\Purchase\DetailPurchase;
use App\Models\Purchase\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Purchase::with('request_form:id,kode', 'supplier:id,nama');

            return DataTables::of($query)
                ->addColumn('request_form', function ($row) {
                    return $row->request_form->kode;
                })
                ->addColumn('supplier', function ($row) {
                    return $row->supplier->nama;
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d M Y');
                })
                ->addColumn('action', 'purchase._action')
                ->toJson();
        }

        return view('purchase.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purchase = false;
        $show = false;

        return view('purchase.create', compact('purchase', 'show'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $purchase = Purchase::create([
                'request_form_id' => $request->request_form,
                'supplier_id' => $request->supplier,
                'tanggal' => $request->tanggal,
                'attn' => $request->attn,
                'grand_total' => $request->grand_total,
                'total' => $request->total,
                'diskon' => $request->diskon,
                'catatan' => $request->catatan,
            ]);

            foreach ($request->produk as $i => $prd) {
                $detailPurch[] = new DetailPurchase([
                    'item_id' => $prd,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'sub_total' => $request->subtotal[$i],
                ]);

                // Update stok barang
                // $produkQuery = Item::whereId($prd);
                // $getProduk = $produkQuery->first();
                // $produkQuery->update(['stok' => ($getProduk->stok + $request->qty[$i])]);
            }

            $purchase->detail_purchase()->saveMany($detailPurch);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(
            'request_form',
            'request_form.user:id,name',
            'request_form.category_request:id,nama',
            'detail_purchase.item:id,unit_id,kode,nama,stok',
            'detail_purchase.item.unit:id,nama'
        );

        // sebagai penanda view dipanggil pada method show
        $show = true;

        return view('purchase.show', compact('purchase', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        $purchase->load(
            'request_form',
            'request_form.user:id,name',
            'request_form.category_request:id,nama',
            'detail_purchase.item:id,unit_id,kode,nama,stok',
            'detail_purchase.item.unit:id,nama',
            'supplier:id,nama'
        );
        $show = false;

        return view('purchase.edit', compact('purchase', 'show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        $purchase->load('detail_purchase');

        // kembalikan stok
        // foreach ($purchase->detail_purchase as $detail) {
        //     $produkQuery = Item::whereId($detail->item_id);
        //     $getProduk = $produkQuery->first();
        //     $produkQuery->update(['stok' => ($getProduk->stok - $detail->qty)]);
        // }

        DB::transaction(function () use ($request, $purchase) {
            // hapus detail sale lama
            $purchase->detail_purchase()->delete();

            $purchase->update([
                'request_form_id' => $request->request_form,
                'supplier_id' => $request->supplier,
                'tanggal' => $request->tanggal,
                'attn' => $request->attn,
                'grand_total' => $request->grand_total,
                'total' => $request->total,
                'diskon' => $request->diskon,
                'catatan' => $request->catatan,
            ]);

            foreach ($request->produk as $i => $prd) {
                $detailPurch[] = new DetailPurchase([
                    'item_id' => $prd,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'sub_total' => $request->subtotal[$i],
                ]);

                // Update stok barang
                // $produkQuery = Item::whereId($prd);
                // $getProduk = $produkQuery->first();
                // $produkQuery->update(['stok' => ($getProduk->stok + $request->qty[$i])]);
            }

            $purchase->detail_purchase()->saveMany($detailPurch);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('purchase.index');
    }
}
