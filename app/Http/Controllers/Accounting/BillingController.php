<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\{StoreBillingRequest, UpdateBillingRequest};
use App\Models\Accounting\Billing;
use App\Repositories\BillingRepository;
use RealRashid\SweetAlert\Facades\Alert;
use PDF;

class BillingController extends Controller
{
    protected $billingRepository;

    public function __construct()
    {
        $this->billingRepository = new BillingRepository;

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
            return $this->billingRepository->getAll();
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
        return view('accounting.billing.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBillingRequest $request)
    {
        $this->billingRepository->insert($request->validated());

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
        $show = true;
        $this->billingRepository->loadRelations($billing);

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
        $this->billingRepository->loadRelations($billing);

        return view('accounting.billing.edit', compact('billing'));
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
        $this->billingRepository->update($request->validated(), $billing);

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
        $this->billingRepository->delete($billing);

        Alert::toast('Hapus data berhasil', 'success');

        return redirect()->route('billing.index');
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

        $kode = $this->billingRepository->generateCode($tanggal);

        return response()->json(['kode' => $kode], 200);
    }

    /**
     * Print the specified billing.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function print(int $id)
    {
        $billing  = Billing::select('id', 'kode')->findOrFail($id);
        $data = $this->billingRepository->print($id);

        $pdf = PDF::loadView('accounting.billing.print', $data);

        return $pdf->stream('Billing - ' . $billing->kode . '.pdf');
    }
}
