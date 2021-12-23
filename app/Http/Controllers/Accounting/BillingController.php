<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\StoreBillingRequest;
use App\Http\Requests\Accounting\UpdateBillingRequest;
use App\Models\Accounting\Billing;
use App\Models\Purchase\Purchase;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Billing::with('purchase:id,kode', 'user:id,name');

            return DataTables::of($query)
                ->addColumn('purchase', function ($row) {
                    return $row->purchase->kode;
                })
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('tanggal_billing', function ($row) {
                    return $row->tanggal_billing->format('d M Y');
                })
                ->addColumn('tanggal_dibayar', function ($row) {
                    return $row->tanggal_dibayar ? $row->tanggal_dibayar->format('d M Y') : '-';
                })
                ->addColumn('action', 'accounting.billing._action')
                ->toJson();
        }

        return view('accounting.billing.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $billing = false;
        $show = false;

        return view('accounting.billing.create', compact('billing', 'show'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBillingRequest $request)
    {
        $attr = $request->validated();
        $attr['purchase_id'] = $request->purchase;
        $attr['user_id'] = auth()->id();

        Billing::create($attr);

        Alert::toast('Simpan Data Berhasil', 'success');

        return redirect()->route('billing.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accounting\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function show(Billing $billing)
    {
        $billing->load(
            'purchase.spal:id,kode',
            'purchase.detail_purchase:id,purchase_id,item_id,harga,qty,sub_total',
            'purchase.detail_purchase.item:id,kode,nama,unit_id',
            'purchase.detail_purchase.item.unit:id,nama',
            'purchase.billings:purchase_id,id,kode,tanggal_dibayar,tanggal_billing,dibayar,status'
        );

        $show = true;

        return view('accounting.billing.show', compact('billing', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounting\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function edit(Billing $billing)
    {
        $billing->load(
            'purchase.spal:id,kode',
            'purchase.detail_purchase:id,purchase_id,item_id,harga,qty,sub_total',
            'purchase.detail_purchase.item:id,kode,nama,unit_id',
            'purchase.detail_purchase.item.unit:id,nama',
            'purchase.billings:purchase_id,id,kode,tanggal_dibayar,tanggal_billing,dibayar,status'
        );

        $show = false;

        return view('accounting.billing.edit', compact('billing', 'show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounting\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBillingRequest $request, Billing $billing)
    {
        // remove coma
        $dibayar = intval(str_replace(',', '', $request->nominal_billing));

        // kalo ada tanggal_dibayar dan $billing belum paid maka ubah total_dibayar pada purchases dengan $request->nominal_billing + $purchase->total_dibayar
        if ($request->tanggal_dibayar && $billing->status != 'Paid') {

            $purchase = Purchase::findOrFail($request->purchase);

            // kalo jumlah yg dibayarkan lebih dari grand total
            if (($purchase->total_dibayar + $dibayar) > $purchase->grand_total) {
                Alert::toast('Update data gagal', 'error');

                return redirect()->route('billing.index');
            }

            $purchase->update([
                'total_dibayar' => $purchase->total_dibayar + $dibayar
            ]);

            if ($purchase->total_dibayar + $dibayar == $purchase->grand_total) {
                $purchase->update([
                    'lunas' => 1,
                ]);
            }
        }

        $billing->update([
            'kode' => $request->kode,
            'attn' => $request->attn,
            'tanggal_billing' => $request->tanggal_billing,
            'tanggal_dibayar' => $request->tanggal_dibayar,
            'catatan' => $request->catatan,
            'status' => $request->status_billing,
        ]);

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('billing.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounting\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Billing $billing)
    {
        $purchase = Purchase::withCount('billings')->findOrFail($billing->purchase_id);

        if ($billing->status == 'Paid') {
            $purchase->update([
                'total_dibayar' => $purchase->total_dibayar - $billing->dibayar,
                'lunas' => 0,
            ]);
        }

        $billing->delete();

        Alert::toast('Hapus data berhasil', 'success');

        return redirect()->route('billing.index');
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

        $kode = 'BILL-' . $tahun . '-' . $bulan . '-' . $hari  . '-';

        $checkLatestKode = Billing::select('id', 'tanggal_billing', 'kode')
            ->whereYear('tanggal_billing', $tahun)
            ->whereMonth('tanggal_billing', $bulan)
            ->whereDay('tanggal_billing', $hari)
            ->latest()
            ->first();

        if ($checkLatestKode == null) {
            $kode = $kode . '0001';
        } else {
            // hapus "BILL-XXXX-XX-XX-" dan ambil angka buat ditambahin
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
