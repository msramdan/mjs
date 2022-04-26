<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Inventory\{DetailBacTerima, DetailItem};
use App\Models\Purchase\{Purchase, DetailPurchase};
use App\Models\RequestForm\RequestForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:gm|direktur')->only('approve');
        $this->middleware('permission:view purchase')->only('index', 'show');
        $this->middleware('permission:create purchase')->only('create', 'store');
        $this->middleware('permission:edit purchase')->only('edit', 'update');
        $this->middleware('permission:delete purchase')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Purchase::with(
                'request_form:id,kode',
                'supplier:id,nama',
                'approved_by_gm:id,name',
                'approved_by_direktur:id,name'
            );

            return DataTables::of($query)
                ->addColumn('request_form', function ($row) {
                    return $row->request_form->kode;
                })
                ->addColumn('status_approve', function ($row) {
                    if ($row->approved_by_gm && $row->approved_by_direktur) {
                        return '<ul class="m-0 p-0">
                        <li>Approve by Direktur: <b>' . $row->approved_by_direktur->name . '</b></li>
                        <li>Approve by GM: <b>' .  $row->approved_by_gm->name . '</b></li>
                    </ul>';
                    } else if ($row->approved_by_gm) {
                        return '<ul class="m-0 p-0">
                        <li>Approve by GM: <b>' .  $row->approved_by_gm->name . '</b></li>
                        <li>Approve by Direktur: - </li>
                    </ul>';
                    } else if ($row->approved_by_direktur) {
                        return '<ul class="m-0 p-0">
                        <li>Approve by Direktur: <b>' .  $row->approved_by_direktur->name . '</b></li>
                        <li>Approve by GM: - </li>
                    </ul>';
                    } else {
                        return '<ul class="m-0 p-0">
                        <li>Approve by GM: - </li>
                        <li>Approve by Direktur: - </li>
                    </ul>';
                    }
                })
                ->addColumn('supplier', function ($row) {
                    return $row->supplier->nama;
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d M Y');
                })
                ->addColumn('action', 'purchase._action')
                ->rawColumns(['status_approve', 'action'])
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
            $tax = $request->tax ? round(($request->total - $request->diskon) * 0.11) : null;

            $purchase = Purchase::create([
                'request_form_id' => $request->request_form,
                'supplier_id' => $request->supplier,
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'attn' => $request->attn,
                'total' => $request->total,
                'diskon' => $request->diskon,
                'tax' => $tax,
                'grand_total' => $tax ? ($request->total - $request->diskon) + $tax : $request->total - $request->diskon,
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

            // set request form status jadi '1' =  udah ada purchase
            $purchase->request_form->update(['status' => 1]);
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
            'request_form:id,user_id,category_request_id,kode,tanggal',
            'request_form.user:id,name',
            'request_form.category_request:id,nama',
            'detail_purchase.item:id,unit_id,kode,nama,stok',
            'detail_purchase.item.unit:id,nama',
            'supplier:id,nama'
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
            'request_form:id,user_id,category_request_id,kode,tanggal',
            'request_form.user:id,name',
            'request_form.category_request:id,nama',

            'detail_purchase.item:id,unit_id,kode,nama,stok',
            'detail_purchase.item.unit:id,nama',

            'supplier:id,nama',
        );

        $listProduk = DetailItem::select('id', 'item_id', 'supplier_id')
            ->with('item:id,kode,nama')
            ->where('supplier_id', $purchase->supplier_id)
            ->get();

        $show = false;
        return view('purchase.edit', compact('purchase', 'show', 'listProduk'));
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
        $purchase->load('detail_purchase', 'bac_terima', 'request_form');

        // set request form lama status jadi '0' =  belom ada purchase
        $purchase->request_form->update(['status' => 0]);

        // kembalikan stok
        // foreach ($purchase->detail_purchase as $detail) {
        //     $produkQuery = Item::whereId($detail->item_id);
        //     $getProduk = $produkQuery->first();
        //     $produkQuery->update(['stok' => ($getProduk->stok - $detail->qty)]);
        // }

        DB::transaction(function () use ($request, $purchase) {
            // hapus detail purchase & bac terima lama
            $purchase->detail_purchase()->delete();

            if ($purchase->bac_terima) {
                DetailBacTerima::where('bac_terima_id', $purchase->bac_terima->id)->delete();
            }

            $tax = $request->tax ? round(($request->total - $request->diskon) * 0.11) : null;

            $purchase->update([
                'request_form_id' => $request->request_form,
                'supplier_id' => $request->supplier,
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'attn' => $request->attn,
                'tax' => $tax,
                'total' => $request->total,
                'diskon' => $request->diskon,
                'grand_total' => $tax ? ($request->total - $request->diskon) + $tax : $request->total - $request->diskon,
                'catatan' => $request->catatan,
            ]);

            foreach ($request->produk as $i => $prd) {
                $detailPurch[] = new DetailPurchase([
                    'item_id' => $prd,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'sub_total' => $request->subtotal[$i],
                ]);

                // insert data baru detail bac terima
                $detailBac[] = new DetailBacTerima([
                    'item_id' => $prd,
                    'qty' => $request->qty[$i],
                    'harga' => $request->harga[$i],
                    'sub_total' => $request->qty[$i] * $request->harga[$i],
                    // 'qty_terima' => $request->qty_terima[$i],
                ]);

                // Update stok barang
                // $produkQuery = Item::whereId($prd);
                // $getProduk = $produkQuery->first();
                // $produkQuery->update(['stok' => ($getProduk->stok + $request->qty[$i])]);
            }

            $purchase->detail_purchase()->saveMany($detailPurch);

            if ($purchase->bac_terima) {
                $purchase->bac_terima->detail_bac_terima()->saveMany($detailBac);
            }

            // set request form lama status jadi '1' =  udah ada purchase
            $purchase->request_form->update(['status' => 1]);
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
        $purchase->load('request_form');

        try {
            $purchase->delete();

            // set request form status jadi '0' = ga ada purchase
            $purchase->request_form->update(['status' => 0]);

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('purchase.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('purchase.index');
        }
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
     * Get a specific purchase by id for billing.
     *
     * @param  String $id
     * @return \Illuminate\Http\Response
     */
    public function getPurchaseById($id)
    {
        abort_if(!request()->ajax(), 403);

        $purchase = Purchase::with(
            'supplier:id,nama',
            'request_form:id,kode',
            'detail_purchase:id,purchase_id,item_id,harga,qty,sub_total',
            'detail_purchase.item:id,kode,nama,unit_id',
            'detail_purchase.item.unit:id,nama',
            'billings:purchase_id,id,kode,tanggal_dibayar,tanggal_billing,dibayar,status',
        )->findOrFail($id);

        return response()->json($purchase, 200);
    }

    public function approve($id)
    {
        /**
         * approve purchase agar bisa tampil di billing
         * kurang dari 10jt hanya butuh approval dari GM, kalo lebih butuh approval dari direktur terlebih dahulu baru GM
         */
        $purchase = Purchase::with('approved_by_gm:id,name', 'approved_by_direktur:id,name')->findOrFail($id);

        // if ($purchase->grand_total <= 10000000) {
        //     $this->approvedBy($purchase);
        // } else

        if (
            auth()->user()->hasRole('gm') &&
            $purchase->grand_total > 10000000 &&
            $purchase->approve_by_direktur == null
        ) {
            Alert::toast('Approve gagal, butuh approve direktur', 'error');

            return redirect()->route('purchase.index');
        } else {
            if (auth()->user()->hasRole('gm')) {
                $purchase->update(['approve_by_gm' => auth()->id()]);
            } else {
                $purchase->update(['approve_by_direktur' => auth()->id()]);
            }

            Alert::toast('Approve berhasil', 'success');

            return redirect()->route('purchase.index');
        }
    }

    // private function approvedBy($purchase)
    // {
    //     if (auth()->user()->getRoleNames() == 'gm') {
    //         $purchase->update(['approve_by_gm' => auth()->id()]);
    //     } else {
    //         $purchase->update(['approve_by_direktur' => auth()->id()]);
    //     }
    // }
}
