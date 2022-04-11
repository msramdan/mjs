<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentAccounting extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'file'];

    protected $casts = ['created_at' => 'datetime:d-m-Y H:i', 'updated_at' => 'datetime:d-m-Y H:i'];
}
