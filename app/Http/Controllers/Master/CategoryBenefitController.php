<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreCategoryBenefitRequest;
use App\Http\Requests\Master\UpdateCategoryBenefitRequest;
use App\Models\Master\CategoryBenefit;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryBenefitController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view category benefit')->only('index');
        $this->middleware('permission:create category benefit')->only('create');
        $this->middleware('permission:edit category benefit')->only('edit', 'update');
        $this->middleware('permission:delete category benefit')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = CategoryBenefit::query();

            return Datatables::of($query)
                ->addColumn('action', 'master-data.category-benefit._action')
                ->toJson();
        }

        return view('master-data.category-benefit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.category-benefit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryBenefitRequest $request)
    {
        CategoryBenefit::create($request->validated());

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('category-benefit.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\CategoryBenefit  $categoryBenefit
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryBenefit $categoryBenefit)
    {
        return view('master-data.category-benefit.edit', compact('categoryBenefit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\CategoryBenefit  $categoryBenefit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryBenefitRequest $request, CategoryBenefit $categoryBenefit)
    {
        $categoryBenefit->update($request->validated());

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('category-benefit.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\CategoryBenefit  $categoryBenefit
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryBenefit $categoryBenefit)
    {
        try {
            $categoryBenefit->delete();

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('category-benefit.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('category-benefit.index');
        }
    }
}
