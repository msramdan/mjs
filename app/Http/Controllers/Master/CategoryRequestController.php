<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\{StoreCategoryRequestRequest, UpdateCategoryRequestRequest};
use App\Models\Master\{SettingCategoryRequest, CategoryRequest};
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view category request')->only('index');
        $this->middleware('permission:create category request')->only('create', 'store');
        $this->middleware('permission:edit category request')->only('edit', 'update');
        $this->middleware('permission:delete category request')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = CategoryRequest::query();

            return Datatables::of($query)
                ->addColumn('action', 'master-data.category-request._action')
                ->toJson();
        }

        return view('master-data.category-request.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.category-request.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequestRequest $request)
    {
        CategoryRequest::create($request->validated());

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('category-request.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Master\CategoryRequest  $categoryRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryRequest $categoryRequest)
    {
        $categoryRequest->load(
            'setting_category_requests',
            'setting_category_requests.user:id,name,foto'
        );

        return view('master-data.category-request.edit', compact('categoryRequest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Master\CategoryRequest  $categoryRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequestRequest $request, CategoryRequest $categoryRequest)
    {

        // return $request;

        $categoryRequest->load('setting_category_requests');

        if (isset($request->user)) {
            $categoryRequest->setting_category_requests()->delete();

            foreach ($request->user as $i => $usr) {
                $settingCategory[] = new SettingCategoryRequest([
                    'category_request_id' => $categoryRequest->id,
                    'user_id' => $usr,
                    'step' => $i + 1
                ]);
            }

            $categoryRequest->setting_category_requests()->saveMany($settingCategory);
        }

        $categoryRequest->update($request->validated());

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('category-request.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Master\CategoryRequest  $categoryRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryRequest $categoryRequest)
    {
        try {
            $categoryRequest->delete();

            Alert::toast('Hapus data berhasil', 'success');

            return redirect()->route('category-request.index');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('category-request.index');
        }
    }
}
