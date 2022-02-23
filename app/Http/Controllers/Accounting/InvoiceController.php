<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\{StoreInvoiceRequest, UpdateInvoiceRequest};
use App\Models\Accounting\Invoice;
use App\Repositories\InvoiceRepository;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class InvoiceController extends Controller
{
    protected $invoiceRepository;

    public function __construct()
    {
        $this->invoiceRepository = new InvoiceRepository;

        $this->middleware('permission:view invoice')->only('index', 'show', 'print');
        $this->middleware('permission:create invoice')->only('create', 'store');
        $this->middleware('permission:edit invoice')->only('edit', 'update');
        $this->middleware('permission:delete invoice')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return $this->invoiceRepository->getAll();
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
        return view('accounting.invoice.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {
        $this->invoiceRepository->insert($request->validated());

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
        $show = true;
        $this->invoiceRepository->loadRelations($invoice);

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
        // $invoice->load('jurnals:id,coa_id,ref_type,ref_id', 'jurnals.coa:id,tipe');

        // return $invoice;

        $this->invoiceRepository->loadRelations($invoice);

        return view('accounting.invoice.edit', compact('invoice'));
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
        // return $request->validated();

        $this->invoiceRepository->update($request->validated(), $invoice);

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
        abort_if($invoice->status == 'Paid', 403);

        $this->invoiceRepository->delete($invoice);

        Alert::toast('Hapus data berhasil', 'success');

        return redirect()->route('invoice.index');
    }

    /**
     * Generate unique & auto increment code by date.
     *
     * @param string $tanggal
     * @return \Illuminate\Http\Response
     */
    public function generateKode(string $tanggal)
    {
        // kalo diakses lewat browser/url/bukan ajax
        abort_if(!request()->ajax(), 403);

        $kode = $this->invoiceRepository->generateCode($tanggal);

        return response()->json(['kode' => $kode], 200);
    }

    /**
     * Print the specified invoice.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function print(int $id)
    {
        $data = $this->invoiceRepository->print($id);

        $pdf = PDF::loadView('accounting.invoice.print', $data);

        return $pdf->stream('Invoice - ' . $data['invoice']->kode . '.pdf');
    }
}
