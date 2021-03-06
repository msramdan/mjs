<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\UpdateSettingAppRequest;
use App\Models\Setting\SettingApp;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SettingAppController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:setting aplikasi');
    }

    public function index()
    {
        $data = SettingApp::first();

        return view('setting.setting_app.index')->with([
            'data' => $data
        ]);
    }

    public function update(UpdateSettingAppRequest $request, $id)
    {
        $settingApp = SettingApp::findOrFail($id);

        if ($request->file('logo_perusahaan') == "") {
            $settingApp->update([
                'nama_aplikasi' => $request->nama_aplikasi,
                'nama_perusahaan' => $request->nama_perusahaan,
                'alamat_perusahaan' => $request->alamat_perusahaan,
                'nama_direktur' => $request->nama_direktur,
                'email' => $request->email,
                'telp' => $request->telp,
                'website' => $request->website,
            ]);
        } else {
            //hapus old image
            Storage::delete('public/logo/' . $settingApp->logo_perusahaan);

            //upload new image
            $logo_perusahaan = $request->file('logo_perusahaan');
            $logo_perusahaan->storeAs('public/logo', $logo_perusahaan->hashName());

            $settingApp->update([
                'logo_perusahaan' => $logo_perusahaan->hashName(),
                'nama_aplikasi' => $request->nama_aplikasi,
                'nama_perusahaan' => $request->nama_perusahaan,
                'alamat_perusahaan' => $request->alamat_perusahaan,
                'nama_direktur' => $request->nama_direktur,
                'email' => $request->email,
                'telp' => $request->telp,
                'website' => $request->website,
            ]);
        }

        if ($settingApp) {
            //redirect dengan pesan sukses
            toast('' . trans('notif.pesan_berhasil.diupdate') . '', 'success');
            return redirect()->route('setting_app.index');
        } else {
            //redirect dengan pesan error
            toast('' . trans('notif.pesan_gagal.diupdate') . '', 'error');
            return redirect()->route('setting_app.index');
        }
    }
}
