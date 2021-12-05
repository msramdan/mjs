<?php

namespace App\Models\Legal;

use App\Models\Master\{Divisi, StatusKaryawan, Jabatan, Lokasi};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'divisi_id',
        'jabatan_id',
        'status_karyawan_id',
        'lokasi_id',
        'nama',
        'email',
        'nik',
        'alamat',
        'gaji_pokok',
        'tgl_masuk',
        'jenis_kelamin',
        'status_kawin',
        'status_keaktifan',
        'foto',
    ];

    protected $casts = ['tgl_masuk' => 'date'];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function status_karyawan()
    {
        return $this->belongsTo(StatusKaryawan::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimeString($value)->format('d m Y H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::createFromTimeString($value)->format('d m Y H:i');
    }

    // biarin default aja susah buat ditampilin di input:date
    // public function getTglMasukAttribute($value)
    // {
    //     return Carbon::createFromDate($value)->format('d m Y');
    // }
}
