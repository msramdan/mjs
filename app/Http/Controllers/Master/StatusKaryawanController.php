<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreStatusKaryawanRequest;
use App\Http\Requests\Master\UpdateStatusKaryawanRequest;
use App\Models\Master\StatusKaryawan;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class StatusKaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view status karyawan')->only('index');
        $this->middleware('permission:create status karyawan')->only('create', 'store');
        $this->middleware('permission:edit status karyawan')->only('edit', 'update');
        $this->middleware('permission:delete status karyawan')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(StatusKaryawan::latest('updated_at'))
                ->addColumn('action', 'master-data.status-karyawan._action')
                ->toJson();
        }

        return view('master-data.status-karyawan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.status-karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStatusKaryawanRequest $request)
    {
        StatusKaryawan::create($request->validated());

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('status-karyawan.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\StatusKaryawan  $statusKaryawan
     * @return \Illuminate\Http\Response
     */
    public function edit(StatusKaryawan $statusKaryawan)
    {
        return view('master-data.status-karyawan.edit', compact('statusKaryawan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\StatusKaryawan  $statusKaryawan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatusKaryawanRequest $request, StatusKaryawan $statusKaryawan)
    {
        $statusKaryawan->update($request->validated());

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('status-karyawan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\StatusKaryawan  $statusKaryawan
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatusKaryawan $statusKaryawan)
    {
        try {
            $statusKaryawan->delete();

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('status-karyawan.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('status-karyawan.index');
        }
    }
}
