<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile');
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
        $request->validate([
            'name' => 'required|string|min:5|max:50',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'foto' => 'nullable|image|max:1024'
        ]);

        $changePassword = false;

        // kalo ada request password berarti user pengen ganti password
        if ($request->current_password || $request->password || $request->password_confirmation) {
            $request->validate([
                'current_password' => 'required',
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

            if (Hash::check($request->current_password, auth()->user()->password)) {

                auth()->user()->update([
                    'password' => bcrypt($request->password)
                ]);

                $changePassword = true;
            } else {
                Alert::error('Password Salah', 'Gagal');

                return back();
            }
        }

        if ($request->file('foto') && $request->file('foto')->isValid()) {
            $filename = time()  . '.' . $request->foto->extension();

            $request->foto->storeAs('public/img/user/', $filename);

            // delete old foto from storage
            if (auth()->user()->foto != null) {
                Storage::delete('public/img/user/' . auth()->user()->foto);
            }

            auth()->user()->update(['foto' => $filename]);
        }

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        Alert::success('Update Data', 'Berhasil');

        // kalo ganti password berhasil langsung logout
        // if ($changePassword) {
        //     Auth::logout();
        // }

        return back();
    }
}
