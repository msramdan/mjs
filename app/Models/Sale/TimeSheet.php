<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'spal_id',
        'qty',
        'hari',
        'jam',
        'menit',
    ];

    public function spal()
    {
        return $this->belongsTo(Spal::class);
    }

    public function detail_time_sheets()
    {
        return $this->hasMany(DetailTimeSheet::class);
    }
}
