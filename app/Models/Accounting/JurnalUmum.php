<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalUmum extends Model
{
    use HasFactory;

    protected $table = 'jurnal_umum';

    protected $fillable = [
        'tanggal',
        'no_bukti',
        'coa_id',
        'deskripsi',
        'debit',
        'kredit',
    ];

    protected $casts = ['tanggal' => 'date:d/m/Y'];

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'coa_id');
    }
}
