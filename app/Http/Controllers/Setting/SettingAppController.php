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
    public function index()
    {
        $data = SettingApp::findOrFail(1);
        return view('setting.setting_app.index')->with([
            'data' => $data
        ]);
    }

    public function update(UpdateSettingAppRequest $request, $id)
    {
    $settingApp = SettingApp::findOrFail($id);
    if($request->file('logo_perusahaan') == "") {
        $settingApp->update([
            'nama_aplikasi' => $request->nama_aplikasi,
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat_perusahaan' => $request->alamat_perusahaan,
            'nama_direktur' => $request->nama_direktur
        ]);

    } else {
        //hapus old image
        Storage::delete('public/logo/' .$settingApp->logo_perusahaan);

        //upload new image
        $logo_perusahaan = $request->file('logo_perusahaan');
        $logo_perusahaan->storeAs('public/logo', $logo_perusahaan->hashName());

        $settingApp->update([
            'logo_perusahaan'=> $logo_perusahaan->hashName(),
            'nama_aplikasi' => $request->nama_aplikasi,
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat_perusahaan' => $request->alamat_perusahaan,
            'nama_direktur' => $request->nama_direktur
        ]);

    }

        if($settingApp){
            //redirect dengan pesan sukses
            Alert::success('Update Data', 'Berhasil');
            return redirect()->route('setting_app.index');
        }else{
            //redirect dengan pesan error
            Alert::error('Update Data', 'Gagal');
            return redirect()->route('setting_app.index');
        }

        }
}
