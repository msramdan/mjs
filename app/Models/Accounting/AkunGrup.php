<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunGrup extends Model
{
    use HasFactory;

    protected $table = 'account_group';

    protected $fillable = [
        'nama',
        'report'
    ];

    public function akun_header()
    {
        return $this->hasMany(AkunHeader::class, 'account_group_id');
    }
}
