<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\StoreInvoiceRequest;
use App\Http\Requests\Accounting\UpdateInvoiceRequest;
use App\Models\Accounting\Invoice;
use App\Models\Sale\Sale;
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
                ->addColumn('tanggal_invoice', function ($row) {
                    return $row->tanggal_invoice->format('d M Y');
                })
                ->addColumn('tanggal_dibayar', function ($row) {
                    return $row->tanggal_dibayar ? $row->tanggal_dibayar->format('d M Y') : '-';
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
        // return $request;
        // die;

        $attr = $request->validated();
        $attr['sale_id'] = $request->sale;
        $attr['user_id'] = auth()->id();

        Invoice::create($attr);

        Alert::toast('Simpan Data Berhasil', 'success');

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
            'sale.detail_sale:id,sale_id,item_id,harga,qty,sub_total',
            'sale.detail_sale.item:id,kode,nama,unit_id',
            'sale.detail_sale.item.unit:id,nama',
            'sale.invoices:sale_id,id,kode,tanggal_dibayar,tanggal_invoice,dibayar,status'
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
            'sale.detail_sale:id,sale_id,item_id,harga,qty,sub_total',
            'sale.detail_sale.item:id,kode,nama,unit_id',
            'sale.detail_sale.item.unit:id,nama',
            'sale.invoices:sale_id,id,kode,tanggal_dibayar,tanggal_invoice,dibayar,status'
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
        $sale = Sale::findOrFail($request->sale);

        // remove coma
        $dibayar = intval(str_replace(',', '', $request->nominal_invoice));

        // kalo ada tanggal_dibayar  dan $invoice belum paid maka ubah total_dibayar pada sales dengan $request->nominal_invoice + $sale->total_dibayar
        if ($request->tanggal_dibayar && $invoice->status != 'Paid') {

            // kalo jumlah yg dibayarkan lebih dari grand total
            if (($sale->total_dibayar + $dibayar) > $sale->grand_total) {
                // Nominal invoice lebih besar daripada sisa
                Alert::toast('Update data gagal', 'error');

                return redirect()->route('invoice.index');
            }

            if ($sale->total_dibayar + $dibayar == $sale->grand_total) {
                $sale->update([
                    'lunas' => 1,
                ]);
            }

            $sale->update([
                'total_dibayar' => $sale->total_dibayar + $dibayar
            ]);
        } elseif (!$request->tanggal_dibayar && $invoice->status == 'Paid') {
            // kalo dari paid diubah ke unpaid
            $sale->update([
                'total_dibayar' => $sale->total_dibayar - $dibayar,
                'lunas' => 0,
            ]);
        }

        $invoice->update([
            'kode' => $request->kode,
            'attn' => $request->attn,
            'tanggal_invoice' => $request->tanggal_invoice,
            'tanggal_dibayar' => $request->tanggal_dibayar,
            'catatan' => $request->catatan,
            'status' => $request->status_invoice,
        ]);

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
        $sale = Sale::findOrFail($invoice->sale_id);

        if ($invoice->status == 'Paid') {
            $sale->update([
                'total_dibayar' => $sale->total_dibayar - $invoice->dibayar,
                'lunas' => 0,
            ]);
        }

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

        $checkLatestKode = Invoice::select('id', 'tanggal_invoice', 'kode')
            ->whereYear('tanggal_invoice', $tahun)
            ->whereMonth('tanggal_invoice', $bulan)
            ->whereDay('tanggal_invoice', $hari)
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
