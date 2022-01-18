<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSpal extends Model
{
    use HasFactory;

    protected $table = 'file_spal';

    protected $fillable = [
        'spal_id',
        'nama',
        'file',
    ];

    public function spal()
    {
        return $this->belongsTo(Spal::class);
    }
}
