<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\StoreCoaRequest;
use App\Http\Requests\Accounting\UpdateCoaRequest;
use App\Models\Accounting\Coa;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Coa::latest('updated_at');

            return DataTables::of($query)
                ->addColumn('action', 'accounting.coa._action')
                ->toJson();
        }

        return view('accounting.coa.index');
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
    public function store(StoreCoaRequest $request)
    {
        Coa::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('coa.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounting\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    public function edit(Coa $coa)
    {
        return view('accounting.coa.edit', compact('coa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounting\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoaRequest $request, Coa $coa)
    {
        $coa->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('coa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounting\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coa $coa)
    {
        // cek punya anak apa kga, kalo punya gabisa dihapus
        $check = Coa::select('id', 'nama')->where('parent', $coa->id)->count();

        if ($check == 0) {
            $coa->delete();

            Alert::success('Hapus Data', 'Berhasil');

            return redirect()->route('coa.index');
        } else {
            Alert::error('Hapus Data', 'Gagal');

            return redirect()->route('coa.index');
        }
    }
}
