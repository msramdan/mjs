<?php

namespace App\Http\Requests\Legal;

use Illuminate\Foundation\Http\FormRequest;

class StoreKaryawanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'divisi' => 'required|integer',
            'jabatan' => 'required|integer',
            'status_karyawan' => 'required|integer',
            'lokasi' => 'required|integer',
            'nama' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:karyawan,email',
            'nik' => 'required|string|min:10|max:30|unique:karyawan,nik',
            'alamat' => 'required|string|min:5',
            'gaji_pokok' => 'required|integer',
            'tgl_masuk' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_kawin' => 'required|in:Menikah,Belum Menikah',
            'status_keaktifan' => 'required|in:Masih Bekerja,Habis Kontrak',
            'foto' => 'required|image|max:1024',
        ];
    }
}
