<?php

namespace App\Http\Controllers\Accountring;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\StoreInvoiceRequest;
use App\Http\Requests\Accounting\UpdateInvoiceRequest;
use App\Models\Accounting\Invoice;
use App\Models\Sale\Sale;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Invoice::with('sale:id,kode', 'user:id,name');

            return DataTables::of($query)
                ->addColumn('sale', function ($row) {
                    return $row->sale->kode;
                })
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('tanggal_dibayar', function ($row) {
                    return $row->tanggal_dibayar->format('d M Y');
                })
                ->addColumn('action', 'accounting.invoice._action')
                ->toJson();
        }

        return view('accounting.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoice = false;
        $show = false;

        return view('accounting.invoice.create', compact('invoice', 'show'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {
        $attr = $request->validated();
        $attr['sale_id'] = $request->sale;
        $attr['user_id'] = auth()->id();

        $sale = Sale::findOrFail($request->sale);
        $status = '';
        $totalDibayar = 0;
        $sisa = 0;

        if (($sale->total_dibayar + $request->dibayar) ==  $sale->grand_total) {
            $status = 'Paid';
            $sisa = 0;
        } else {
            $status = 'Pending';
            $sisa = $sale->grand_total - $request->dibayar;
        }

        $totalDibayar = $sale->total_dibayar + $request->dibayar;

        $sale->update([
            'status_pembayaran' => $status,
            'total_dibayar' => $totalDibayar,
            'sisa' => $sisa,
        ]);

        $attr['sisa'] = $sisa;

        Invoice::create($attr);

        Alert::success('Simpan Data', 'Berhasil');

        return redirect()->route('invoice.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accounting\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(
            'sale.spal:id,kode',
            'sale.detail_sale:id,sale_id,item_id,harga',
            'sale.detail_sale.item:id,kode,nama,unit_id',
            'sale.detail_sale.item.unit:id,nama',
            'sale.invoices:sale_id,id,kode,tanggal_dibayar,dibayar,sisa'
        );

        $show = true;

        return view('accounting.invoice.show', compact('invoice', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounting\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load(
            'sale.spal:id,kode',
            'sale.detail_sale:id,sale_id,item_id,harga',
            'sale.detail_sale.item:id,kode,nama,unit_id',
            'sale.detail_sale.item.unit:id,nama',
            'sale.invoices:sale_id,id,kode,tanggal_dibayar,dibayar,sisa'
        );

        $show = false;

        return view('accounting.invoice.edit', compact('invoice', 'show'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounting\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $attr = $request->validated();
        $attr['sale_id'] = $request->sale;
        $attr['user_id'] = auth()->id();

        $sale = Sale::findOrFail($request->sale);
        $status = '';
        $totalDibayar = 0;
        $sisa = 0;

        if (($sale->total_dibayar + $request->dibayar) ==  $sale->grand_total) {
            $status = 'Paid';
            $sisa = 0;
        } else {
            $status = 'Pending';
            $sisa = $sale->grand_total - $request->dibayar;
        }

        $totalDibayar = $sale->total_dibayar + $request->dibayar;

        $sale->update([
            'status_pembayaran' => $status,
            'total_dibayar' => $totalDibayar,
            'sisa' => $sisa,
        ]);

        $attr['sisa'] = $sisa;

        $invoice->update($attr);

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('invoice.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounting\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $sale = Sale::withCount('invoices')->findOrFail($invoice->sale_id);

        /**
         * kalo 1 berarti cuma invoice = $invoice
         * dan jika dihapus maka sale ga akan punya invoice lagi
         * otomatis jadi unpaid
         */
        if ($sale->invoices_count == 1) {
            $status = 'Unpaid';
        } else {
            $status = 'Pending';
        }

        $sale->update([
            'sisa' => $sale->grand_total - ($sale->total_dibayar - $invoice->dibayar),
            'total_dibayar' => $sale->total_dibayar - $invoice->dibayar,
            'status_pembayaran' => $status
        ]);

        $invoice->delete();

        Alert::toast('Hapus data berhasil', 'success');

        return redirect()->route('invoice.index');
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

        $kode = 'INV-' . $tahun . '-' . $bulan . '-' . $hari  . '-';

        $checkLatestKode = Invoice::select('id', 'tanggal_dibayar', 'kode')
            ->whereYear('tanggal_dibayar', $tahun)
            ->whereMonth('tanggal_dibayar', $bulan)
            ->whereDay('tanggal_dibayar', $hari)
            ->latest()
            ->first();

        if ($checkLatestKode == null) {
            $kode = $kode . '0001';
        } else {
            // hapus "INV-XXXX-XX-XX-" dan ambil angka buat ditambahin
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
