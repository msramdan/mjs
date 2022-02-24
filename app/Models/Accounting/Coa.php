<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'tipe',
        'kategori',
        'parent'
    ];

    public function jurnals()
    {
        return $this->hasMany(JurnalUmum::class);
    }
}
