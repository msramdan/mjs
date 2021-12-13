<?php

namespace App\Models\Legal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasKaryawan extends Model
{
    use HasFactory;

    protected $table = 'berkas_karyawan';

    protected $fillable = [
        'karyawan_id',
        'nama',
        'file',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d m Y H:i', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d m Y H:i', strtotime($value));
    }
}
