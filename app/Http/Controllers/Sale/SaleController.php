<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Item;
use App\Models\Sale\DetailSale;
use App\Models\Sale\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Sale::with(
                'spal:id,customer_id,kode',
                'spal.customer:id,nama',
            )
                ->latest('updated_at');

            return DataTables::of($query)
                ->addColumn('spal', function ($row) {
                    return $row->spal->kode;
                })
                ->addColumn('customer', function ($row) {
                    return $row->spal->customer->nama;
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d M Y');
                })
                ->addColumn('action', 'sale.sale._action')
                ->toJson();
        }

        return view('sale.sale.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sale = false;
        $show = false;

        return view('sale.sale.create', compact('sale', 'show'));
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
            $sale = Sale::create([
                'kode' => $request->kode,
                'spal_id' => $request->spal,
                'tanggal' => $request->tanggal,
                'attn' => $request->attn,
                'grand_total' => $request->grand_total,
                'total' => $request->total,
                'diskon' => $request->diskon,
                'catatan' => $request->catatan,
                'sisa' => $request->grand_total,
                'status_pembayaran' => 'Unpaid'
            ]);

            foreach ($request->produk as $i => $prd) {
                $detailSale[] = new DetailSale([
                    'item_id' => $prd,
                    'harga' => $request->harga[$i],
                    // 'qty' => $request->qty[$i],
                    // 'sub_total' => $request->subtotal[$i],
                ]);

                // Update stok barang
                // $produkQuery = Item::whereId($prd);
                // $getProduk = $produkQuery->first();
                // $produkQuery->update(['stok' => ($getProduk->stok + $request->qty[$i])]);
            }

            $sale->detail_sale()->saveMany($detailSale);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        $sale->load(
            'spal',
            'spal.customer:id,nama',
            'detail_sale',
            'detail_sale.item:id,unit_id,kode,nama,stok',
            'detail_sale.item.unit:id,nama'
        );

        // sebagai penanda view dipanggil pada method show
        $show = true;

        return view('sale.sale.show', compact('sale', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $sale->load(
            'spal',
            'spal.customer:id,nama',
            'detail_sale',
            'detail_sale.item:id,unit_id,kode,nama,stok',
            'detail_sale.item.unit:id,nama'
        );

        $show = false;

        return view('sale.sale.edit', compact('sale', 'show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        $sale->load('detail_sale');

        // kembalikan stok
        // foreach ($sale->detail_sale as $detail) {

        //     $produkQuery = Item::whereId($detail->item_id);

        //     $getProduk = $produkQuery->first();

        //     $produkQuery->update(['stok' => ($getProduk->stok + $detail->qty)]);
        // }

        DB::transaction(function () use ($request, $sale) {
            // hapus detail sale lama
            $sale->detail_sale()->delete();

            $sale->update([
                'spal_id' => $request->spal,
                'tanggal' => $request->tanggal,
                'attn' => $request->attn,
                'grand_total' => $request->grand_total,
                'total' => $request->total,
                'diskon' => $request->diskon,
                'catatan' => $request->catatan,
            ]);

            // insert detail sale baru
            foreach ($request->produk as $i => $prd) {
                $detailSale[] = new DetailSale([
                    'item_id' => $prd,
                    'harga' => $request->harga[$i],
                    // 'qty' => $request->qty[$i],
                    // 'sub_total' => $request->subtotal[$i],
                ]);

                // Update stok barang
                // $produkQuery = Item::whereId($prd);
                // $getProduk = $produkQuery->first();
                // $produkQuery->update(['stok' => ($getProduk->stok - $request->qty[$i])]);
            }

            $sale->detail_sale()->saveMany($detailSale);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('sale.index');
    }

    public function getSaleById($id)
    {
        abort_if(!request()->ajax(), 403);

        return Sale::with(
            'spal:id,kode',
            'detail_sale:id,sale_id,item_id,harga',
            'detail_sale.item:id,kode,nama,unit_id',
            'detail_sale.item.unit:id,nama',
            'invoices:sale_id,id,kode,tanggal_dibayar,dibayar,sisa'
        )->findOrFail($id);
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

        $kode = 'SO-' . $tahun . '-' . $bulan . '-' . $hari  . '-';

        $checkLatestKode = Sale::select('id', 'tanggal', 'kode')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->whereDay('tanggal', $hari)
            ->latest()
            ->first();

        if ($checkLatestKode == null) {
            $kode = $kode . '0001';
        } else {
            // hapus "SO-XXXX-XX-XX-" dan ambil angka buat ditambahin
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
}
