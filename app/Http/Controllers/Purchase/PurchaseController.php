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
                'kode' => $request->kode,
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
            // hapus detail purchase lama
            $purchase->detail_purchase()->delete();

            $purchase->update([
                'request_form_id' => $request->request_form,
                'supplier_id' => $request->supplier,
                'kode' => $request->kode,
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

        Alert::toast('Hapus data berhasil', 'success');

        return redirect()->route('purchase.index');
    }

    /**
     * Generate unique & auto increment code by date.
     *
     * @param  String $tanggal
     * @return \Illuminate\Http\Response
     */
    public function generateKode($tanggal)
    {
        // kalo diakses lewat browser/url/bukan ajax
        abort_if(!request()->ajax(), 403);

        $tahun = date('Y', strtotime($tanggal));
        $bulan = date('m', strtotime($tanggal));
        $hari = date('d', strtotime($tanggal));

        $kode = 'PO-' . $tahun . '-' . $bulan . '-' . $hari  . '-';

        $checkLatestKode = Purchase::select('id', 'tanggal', 'kode')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->whereDay('tanggal', $hari)
            ->latest()
            ->first();

        if ($checkLatestKode == null) {
            $kode = $kode . '0001';
        } else {
            // hapus "PO-XXXX-XX-XX-" dan ambil angka buat ditambahin
            // $onlyNumberKode = intval(Str::after($checkLatestKode->kode, $kode));
            $onlyNumberKode = intval(substr($checkLatestKode->kode, -4));

            if ($onlyNumberKode < 100) {
                $kode = $kode . '000' . ($onlyNumberKode + 1);
            } elseif ($onlyNumberKode >= 100 && $onlyNumberKode < 1000) {
                $kode =  $kode . '0' . ($onlyNumberKode + 1);
            } else {
                $kode = $kode . ($onlyNumberKode + 1);
            }
        }

        return response()->json(['kode' => $kode], 200);
    }


    /**
     * Generate a specific purchase by id for billing.
     *
     * @param  String $id
     * @return \Illuminate\Http\Response
     */
    public function getPurchaseById($id)
    {
        abort_if(!request()->ajax(), 403);

        $purchase = Purchase::with(
            'request_form:id,kode',
            'detail_purchase:id,purchase_id,item_id,harga,qty,sub_total',
            'detail_purchase.item:id,kode,nama,unit_id',
            'detail_purchase.item.unit:id,nama',
            'billings:purchase_id,id,kode,tanggal_dibayar,tanggal_billing,dibayar,status'
        )->findOrFail($id);

        return response()->json($purchase, 200);
    }
}
