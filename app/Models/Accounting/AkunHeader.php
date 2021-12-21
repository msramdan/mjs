<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunHeader extends Model
{
    use HasFactory;
    protected $table = 'account_header';
    protected $fillable = [
        'code_account_header',
        'account_header',
        'account_group_id'
    ];
}
