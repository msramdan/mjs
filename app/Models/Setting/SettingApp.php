<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingApp extends Model
{
    use HasFactory;
    protected $table = 'setting_app';

    protected $fillable = [
        'nama_aplikasi',
        'nama_perusahaan',
        'alamat_perusahaan',
        'logo_perusahaan',
        'nama_direktur',
        'email',
        'telp',
        'website',
        'password_un_lock_absensi',
        'is_aktive_absensi'
    ];
}
