<?php

namespace App\Models\BarangJasa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'email',
        'alamat',
        'kota',
        'provinsi',
        'telp',
        'personal_kontak',
        'website',
        'kode_pos',
        'catatan',
    ];
}
