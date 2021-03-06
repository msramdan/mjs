<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreJabatanRequest;
use App\Http\Requests\Master\UpdateJabatanRequest;
use App\Models\Master\Jabatan;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view jabatan')->only('index');
        $this->middleware('permission:create jabatan')->only('create', 'store');
        $this->middleware('permission:edit jabatan')->only('edit', 'update');
        $this->middleware('permission:delete jabatan')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Jabatan::latest('updated_at');

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', 'master-data.jabatan._action')
                ->toJson();
        }

        return view('master-data.jabatan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJabatanRequest $request)
    {
        Jabatan::create($request->validated());

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('jabatan.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jabatan $jabatan)
    {
        return view('master-data.jabatan.edit', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJabatanRequest $request, Jabatan $jabatan)
    {
        $jabatan->update($request->validated());

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('jabatan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jabatan $jabatan)
    {
        try {
            $jabatan->delete();

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('jabatan.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('jabatan.index');
        }
    }
}
