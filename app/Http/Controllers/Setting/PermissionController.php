<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\StorePermissionRequest;
use App\Http\Requests\Setting\UpdatePermissionRequest;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Permission::latest('updated_at');

            return DataTables::of($query)
                // ->addColumn('name', function ($row) {
                //     return ucwords($row->name);
                // })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d m Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d m Y H:i');
                })
                ->addColumn('action', 'setting.permission._action')
                ->toJson();
        }

        return view('setting.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setting.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        Permission::create($request->validated());

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('permission.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('setting.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $permission->update($request->validated());

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('permission.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::withCount('users', 'roles')->findOrFail($id);

        // kalo lebih dari dari berarti ada user dengan permission = $id
        // make try and catch gabisa, tetep kehapus
        if ($permission->users_count < 1 && $permission->roles_count < 1) {
            $permission->delete();

            Alert::toast('Hapus data berhasil', 'success');
        } else {
            Alert::toast('Hapus data gagal', 'error');
        }

        return redirect()->route('permission.index');
    }
}
