<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTimeSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'time_sheet_id',
        'date',
        'remark',
        'from',
        'to',
        'keterangan',
    ];

    public function time_sheet()
    {
        return $this->belongsTo(TimeSheet::class);
    }
}
