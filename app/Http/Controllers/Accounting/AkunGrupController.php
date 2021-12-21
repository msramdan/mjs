<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\{StoreAkunGrupRequest, UpdateAkunGrupRequest};
use App\Models\Accounting\AkunGrup;
use RealRashid\SweetAlert\Facades\Alert;

class AkunGrupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $akunGroup = AkunGrup::all();

        return view('accounting.akun-grup.index', compact('akunGroup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.akun-grup.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAkunGrupRequest $request)
    {
        AkunGrup::create($request->validated());

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('akun-grup.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounting\AkunGrup  $akunGrup
     * @return \Illuminate\Http\Response
     */
    public function edit(AkunGrup $akunGrup)
    {
        return view('accounting.akun-grup.edit', compact('akunGrup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounting\AkunGrup  $akunGrup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAkunGrupRequest $request, AkunGrup $akunGrup)
    {
        $akunGrup->update($request->validated());

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('akun-grup.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounting\AkunGrup  $akunGrup
     * @return \Illuminate\Http\Response
     */
    public function destroy(AkunGrup $akunGrup)
    {
        try {
            $akunGrup->delete();

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('akun-grup.index');
        } catch (\Throwable $th) {

            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('akun-grup.index');
        }
    }
}
