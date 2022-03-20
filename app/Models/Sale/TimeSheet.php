<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'spal_id',
        'kode_time_sheet',
        'qty',
        'hari',
        'jam',
        'menit',
    ];

    protected $casts = [
        'qty' => 'float',
        'created_at' => 'datetime:d/m/Y H:i',
        'updeated_at' => 'datetime:d/m/Y H:i',
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
