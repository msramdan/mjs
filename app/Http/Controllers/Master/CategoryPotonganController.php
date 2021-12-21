<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreCategoryPotonganRequest;
use App\Http\Requests\Master\UpdateCategoryPotonganRequest;
use App\Models\Master\CategoryPotongan;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryPotonganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = CategoryPotongan::latest('updated_at');

            return Datatables::of($query)
                ->addColumn('action', 'master-data.category-potongan._action')
                ->toJson();
        }

        return view('master-data.category-potongan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.category-potongan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryPotonganRequest $request)
    {
        CategoryPotongan::create($request->validated());

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('category-potongan.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\CategoryPotongan  $categoryPotongan
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryPotongan $categoryPotongan)
    {
        return view('master-data.category-potongan.edit', compact('categoryPotongan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\CategoryPotongan  $categoryPotongan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryPotonganRequest $request, CategoryPotongan $categoryPotongan)
    {
        $categoryPotongan->update($request->validated());

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('category-potongan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\CategoryPotongan  $categoryPotongan
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryPotongan $categoryPotongan)
    {
        try {
            $categoryPotongan->delete();

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('category-potongan.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('category-potongan.index');
        }
    }
}
