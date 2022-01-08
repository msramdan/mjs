<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\{StoreAkunCoaRequest, UpdateAkunCoaRequest};
use App\Models\Accounting\AkunCoa;
use RealRashid\SweetAlert\Facades\Alert;

class AkunCoaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view coa')->only('index');
        $this->middleware('permission:create coa')->only('create');
        $this->middleware('permission:edit coa')->only('edit', 'update');
        $this->middleware('permission:delete coa')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $akunCoa = AkunCoa::with('akun_header:id,kode,nama')->get();

        return view('accounting.coa.index', compact('akunCoa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.coa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAkunCoaRequest $request)
    {
        AkunCoa::create($request->validated());

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('akun-coa.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounting\AkunCoa  $akunCoa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $akunCoa = AkunCoa::findOrFail($id);

        return view('accounting.coa.edit', compact('akunCoa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounting\AkunCoa  $akunCoa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAkunCoaRequest $request, $id)
    {
        $akunCoa = AkunCoa::findOrFail($id);

        $akunCoa->update($request->validated());

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('akun-coa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounting\AkunCoa  $akunCoa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $akunCoa = AkunCoa::findOrFail($id);

        try {
            $akunCoa->delete();

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('akun-coa.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('akun-coa.index');
        }
    }
}
