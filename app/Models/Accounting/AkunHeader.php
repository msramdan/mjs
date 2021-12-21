<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunHeader extends Model
{
    use HasFactory;

    protected $table = 'account_header';

    protected $fillable = [
        'kode',
        'nama',
        'account_group_id'
    ];

    public function akun_group()
    {
        return $this->belongsTo(AkunGrup::class, 'account_group_id');
    }

    public function akun_coa()
    {
        return $this->hasMany(AkunCoa::class, 'account_header_id');
    }
}
