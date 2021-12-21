<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunCoa extends Model
{
    use HasFactory;

    protected $table = 'account_coa';

    protected $fillable = [
        'kode',
        'nama',
        'account_header_id',
        'normal',
        'remark'
    ];

    public function akun_header()
    {
        return $this->belongsTo(AkunHeader::class, 'account_header_id');
    }
}
