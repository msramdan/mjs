<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreDivisiRequest;
use App\Http\Requests\Master\UpdateDivisiRequest;
use App\Models\Master\Divisi;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class DivisiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view divisi')->only('index');
        $this->middleware('permission:create divisi')->only('create', 'store');
        $this->middleware('permission:edit divisi')->only('edit', 'update');
        $this->middleware('permission:delete divisi')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Divisi::latest('updated_at');

            return Datatables::of($query)
                ->addColumn('action', 'master-data.divisi._action')
                ->toJson();
        }

        return view('master-data.divisi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.divisi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDivisiRequest $request)
    {
        Divisi::create($request->validated());

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('divisi.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function edit(Divisi $divisi)
    {
        return view('master-data.divisi.edit', compact('divisi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDivisiRequest $request, Divisi $divisi)
    {
        $divisi->update($request->validated());

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('divisi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Divisi $divisi)
    {
        try {
            $divisi->delete();

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('divisi.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('divisi.index');
        }
    }
}
