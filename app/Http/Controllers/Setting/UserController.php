<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\StoreUserRequest;
use App\Http\Requests\Setting\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view user')->only('index');
        $this->middleware('permission:create user')->only('create');
        $this->middleware('permission:edit user')->only('edit', 'update');
        $this->middleware('permission:delete user')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = User::with('roles:id,name')->latest('updated_at');

            return Datatables::of($query)
                ->addColumn('foto', function ($row) {
                    if ($row->foto != null) {
                        return asset('storage/img/user/' . $row->foto);
                    } else {
                        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($row->email))) . "&s=100";
                    }
                })
                ->addColumn('role', function ($row) {
                    return ucfirst($row->roles[0]->name);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d m Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d m Y H:i');
                })
                ->addColumn('action', 'setting.user._action')
                ->toJson();
        }

        return view('setting.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setting.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if ($request->file('foto') && $request->file('foto')->isValid()) {
            $filename = time()  . '.' . $request->foto->extension();

            $request->foto->storeAs('public/img/user/', $filename);

            $attr['foto'] = $filename;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);
        $user->givePermissionTo($request->permissions);

        Alert::toast('Tambah data berhasil', 'success');

        return redirect()->route('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->load('roles:id,name', 'permissions:id,name');

        return view('setting.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // kalo ada request password berarti user pengen ganti password
        if ($request->password || $request->password_confirmation) {
            $request->validate([
                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
                ]
            ]);

            $user->update([
                'password' => bcrypt($request->password)
            ]);
        }

        if ($request->file('foto') && $request->file('foto')->isValid()) {
            $filename = time()  . '.' . $request->foto->extension();

            $request->foto->storeAs('public/img/user/', $filename);

            // delete old foto from storage
            if ($user->foto != null) {
                Storage::delete('public/img/user/' . $user->foto);
            }

            $user->update(['foto' => $filename]);
        }

        $user->update($request->only(['name', 'email']));

        // kalo user 1 gabisa edit role, harus admin
        if ($user->id != 1) {
            $user->syncRoles($request->role);
        }

        Alert::toast('Update data berhasil', 'success');

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->id == 1) {
            Alert::toast('Hapus data gagal', 'error');

            return redirect()->route('user.index');
        }

        try {
            // delete old foto from storage
            if ($user->foto != null) {
                Storage::delete('public/img/user/' . $user->foto);
            }

            $user->delete();

            Alert::toast('Hapus data berhasil', 'success');
        } catch (\Throwable $th) {
            Alert::toast('Hapus data gagal', 'error');
        }

        return redirect()->route('user.index');
    }
}
