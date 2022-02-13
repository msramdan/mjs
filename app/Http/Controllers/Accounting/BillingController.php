<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\{StoreBillingRequest, UpdateBillingRequest};
use App\Models\Accounting\AkunCoa;
use App\Models\Accounting\Billing;
use App\Models\Accounting\JurnalUmum;
use App\Models\Purchase\Purchase;
use App\Models\Setting\SettingApp;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class BillingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view billing')->only('index', 'show', 'print');
        $this->middleware('permission:create billing')->only('create', 'store');
        $this->middleware('permission:edit billing')->only('edit', 'update');
        $this->middleware('permission:delete billing')->only('delete');
    }

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
            'purchase.request_form:id,kode',
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
            'purchase.request_form:id,kode',
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
        $purchase = Purchase::findOrFail($request->purchase);

        // remove coma
        $dibayar = intval(str_replace(',', '', $request->nominal_billing));

        // kalo ada tanggal_dibayar dan $billing belum paid maka ubah total_dibayar pada purchases dengan $request->nominal_billing + $purchase->total_dibayar
        if ($request->tanggal_dibayar && $billing->status != 'Paid') {

            // kalo jumlah yg dibayarkan lebih dari grand total
            if (($purchase->total_dibayar + $dibayar) > $purchase->grand_total) {
                // Nominal billing lebih besar daripada sisa
                Alert::toast('Update data gagal', 'error');

                return redirect()->route('billing.index');
            }

            if ($purchase->total_dibayar + $dibayar == $purchase->grand_total) {
                $purchase->update([
                    'lunas' => 1,
                ]);
            }

            $purchase->update([
                'total_dibayar' => $purchase->total_dibayar + $dibayar
            ]);
        } elseif (!$request->tanggal_dibayar && $billing->status == 'Paid') {
            // kalo dari paid diubah ke unpaid
            $purchase->update([
                'total_dibayar' => $purchase->total_dibayar - $dibayar,
                'lunas' => 0,
            ]);
        }

        $billing->update([
            'kode' => $request->kode,
            'attn' => $request->attn,
            'tanggal_billing' => $request->tanggal_billing,
            'tanggal_dibayar' => $request->tanggal_dibayar,
            'catatan' => $request->catatan,
            'status' => $request->status_billing,
        ]);

        if ($request->tanggal_dibayar && $request->status_billing == 'Paid') {
            // dd('paid');

            // sekarang masih static dulu
            $noBukti = 'BKK-001';
            $akunBeban = AkunCoa::select('id', 'kode')->where('id', $request->akun_beban)->first();

            DB::table('jurnal_umum')->insert([
                [
                    'tanggal' => now()->toDateString(),
                    'no_bukti' => $noBukti,
                    'account_coa_id' => $request->akun_beban,
                    'deskripsi' => 'Pembayaran akun beban ' . $akunBeban->kode . ' untuk no.ref ' . $billing->kode,
                    'debit' => $dibayar,
                    'kredit' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'tanggal' => now()->toDateString(),
                    'no_bukti' => $noBukti,
                    'account_coa_id' => $request->akun_sumber,
                    'deskripsi' => 'lorem',
                    'debit' => 0,
                    'kredit' => $dibayar,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }

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
        $purchase = Purchase::findOrFail($billing->purchase_id);

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
            // hapus "BILL-YYYY-MM-DD-" dan ambil angka buat ditambahin
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

    public function print($id)
    {
        $billing = Billing::select(
            'id',
            'purchase_id',
            'kode',
            'tanggal_billing',
            'status',
            'catatan'
        )->with(
            'purchase:id,request_form_id,supplier_id,kode,diskon,grand_total',
            'purchase.request_form:id,kode',
            'purchase.supplier:id,kode,nama,email,alamat,telp',
            'purchase.detail_purchase:id,purchase_id,item_id,harga,qty,sub_total',
            'purchase.detail_purchase.item:id,kode,nama',
            'user:id,name'
        )->findOrFail($id);

        $perusahaan = SettingApp::first();

        $data = [
            'billing' => $billing,
            'perusahaan' => $perusahaan
        ];

        // return $data;
        // die;

        $pdf = PDF::loadView('accounting.billing.print', $data);

        return $pdf->stream('Billing - ' . $billing->kode . '.pdf');
        // ->setPaper('a4', 'landscape')
    }
}
