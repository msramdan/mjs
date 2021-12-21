<?php

namespace App\Http\Controllers\ElectronicDocument;

use App\Http\Controllers\Controller;
use App\Http\Requests\ElectronicDocument\{StoreCategoryDocumentRequest, UpdateCategoryDocumentRequest};
use App\Models\ElectronicDocument\CategoryDocument;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CategoryDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = CategoryDocument::latest('updated_at');

            return DataTables::of($query)
                ->addColumn('action', 'electronic-document.category._action')
                ->toJson();
        }

        return view('electronic-document.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('electronic-document.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryDocumentRequest $request)
    {
        CategoryDocument::create($request->validated());

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('category-document.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ElectronicDocument\CategoryDocument  $categoryDocument
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryDocument $categoryDocument)
    {
        return view('electronic-document.category.edit', compact('categoryDocument'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ElectronicDocument\CategoryDocument  $categoryDocument
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryDocumentRequest $request, CategoryDocument $categoryDocument)
    {
        $categoryDocument->update($request->validated());

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('category-document.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ElectronicDocument\CategoryDocument  $categoryDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryDocument $categoryDocument)
    {
        try {
            $categoryDocument->delete();

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('category-document.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('category-document.index');
        }
    }
}
