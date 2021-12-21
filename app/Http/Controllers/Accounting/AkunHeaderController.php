<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\AkunHeaderRequest;
use App\Http\Requests\Accounting\UpdateAkunHeaderRequest;
use App\Models\Accounting\AkunGrup;
use Illuminate\Support\Facades\DB;
use App\Models\Accounting\AkunHeader;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class AkunHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $akunHeader = AkunHeader::with('akun_group:id,nama,report')->get();

        return view('accounting.akun-header.index', compact('akunHeader'));
    }

    public function create()
    {
        return view('accounting.akun-header.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AkunHeaderRequest $request)
    {
        $data = $request->validated();

        AkunHeader::create($data);

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('akun-header.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounting\AkunHeader  $akunHeader
     * @return \Illuminate\Http\Response
     */
    public function edit(AkunHeader $akunHeader)
    {
        return view('accounting.akun-header.edit', compact('akunHeader'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounting\AkunHeader  $akunHeader
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAkunHeaderRequest $request, AkunHeader $akunHeader)
    {
        $data = $request->validated();

        $akunHeader->update($data);

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('akun-header.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounting\AkunHeader  $akunHeader
     * @return \Illuminate\Http\Response
     */
    public function destroy(AkunHeader $akunHeader)
    {
        try {
            $akunHeader->delete();

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('akun-header.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('akun-header.index');
        }
    }
}
