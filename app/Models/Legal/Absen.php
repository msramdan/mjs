<?php

namespace App\Models\Legal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'absen';
    protected $fillable = [
        'id',
        'user_id',
        'tanggal',
        'keterangan',
        'status_absen',
        'jam_masuk',
        'jam_pulang'
    ];
}
