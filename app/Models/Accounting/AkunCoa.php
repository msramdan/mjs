<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunCoa extends Model
{
    use HasFactory;
    protected $table = 'account_coa';
    protected $fillable = [
        'code_account_coa',
        'account_coa',
        'account_header_id',
        'normal',
        'remark'
    ];
}
