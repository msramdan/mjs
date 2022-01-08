<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\StoreRoleRequest;
use App\Http\Requests\Setting\UpdateRoleRequest;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view role')->only('index');
        $this->middleware('permission:create role')->only('create');
        $this->middleware('permission:edit role')->only('edit', 'update');
        $this->middleware('permission:delete role')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Role::query();

            return DataTables::of($query)
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d m Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d m Y H:i');
                })
                ->addColumn('action', 'setting.role._action')
                ->toJson();
        }

        return view('setting.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setting.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);

        $role->givePermissionTo($request->permissions);

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('role.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return view('setting.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        if ($id == 1) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('role.index');
        }

        $role = Role::findOrFail($id);

        $role->update(['name' => $request->name]);

        $role->syncPermissions($request->permissions);

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == 1) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('role.index');
        }

        $role = Role::withCount('users')->findOrFail($id);

        // kalo lebih dari dari berarti ada user dengan role = $id
        // make try and catch gabisa, tetep kehapus
        if ($role->users_count < 1) {
            $role->delete();

            Alert::toast('Hapus data berhasil', 'success');
        } else {
            Alert::toast('Hapus data gagal', 'error');
        }

        return redirect()->route('role.index');
    }
}
