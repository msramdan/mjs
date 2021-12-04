<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreLokasiRequest;
use App\Http\Requests\Master\UpdateLokasiRequest;
use App\Models\Master\Lokasi;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Lokasi::latest('updated_at');

            return Datatables::of($query)
                ->addColumn('action', 'master-data.lokasi._action')
                ->toJson();
        }

        return view('master-data.lokasi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.lokasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLokasiRequest $request)
    {
        Lokasi::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('lokasi.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Lokasi $lokasi)
    {
        return view('master-data.lokasi.edit', compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLokasiRequest $request, Lokasi $lokasi)
    {
        $lokasi->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('lokasi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Lokasi  $lokasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lokasi $lokasi)
    {
        $lokasi->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('lokasi.index');
    }
}
