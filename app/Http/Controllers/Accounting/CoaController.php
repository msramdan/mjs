<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\{StoreCoaRequest, UpdateCoaRequest};
use App\Models\Accounting\Coa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CoaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view coa')->only('index');
        $this->middleware('permission:create coa')->only('create', 'store');
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
        $coas = Coa::get();

        // $coaHeaderIds = [];
        $coaHeaders = Coa::select('id', 'kode', 'nama')->where('parent', null)->get();
        // foreach ($coaHeaders as $header) {
        //     $coaHeaderIds[] = $header->id;
        // }

        // $coaSubHeaderIds = [];
        // $coaSubHeaders = Coa::whereIn('parent_id', $coaHeaderIds)->get();
        // foreach ($coaSubHeaders as $coaSubHeader) {
        //     $coaSubHeaderIds[] = $coaSubHeader->id;
        // }

        // $coaAkuns = Coa::whereIn('parent_id', $coaSubHeaderIds)->get();

        return view('accounting.coa.index', compact('coas', 'coaHeaders'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCoaRequest $request)
    {
        $attr = $request->validated();

        if ($request->parent) {
            $attr['kategori'] = 'Detail';
        } else {
            $attr['kategori'] = 'Header';
        }

        Coa::create($attr);

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('coa.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounting\Coa $coa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coa = Coa::findOrFail($id);

        return view('accounting.coa.edit', compact('coa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Accounting\Coa $coa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoaRequest $request, $id)
    {
        $coa = Coa::findOrFail($id);

        $attr = $request->validated();

        if ($request->parent) {
            $attr['kategori'] = 'Detail';
        } else {
            $attr['kategori'] = 'Header';
        }

        $coa->update($attr);

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('coa.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounting\Coa $coa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coa = Coa::findOrFail($id);

        try {
            $coa->delete();

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('coa.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('coa.index');
        }
    }
}
