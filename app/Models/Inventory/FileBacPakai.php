<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileBacPakai extends Model
{
    use HasFactory;

    protected $table = 'file_bac_pakai';

    protected $fillable = [
        'bac_pakai_id',
        'nama',
        'file',
    ];

    public function bac_pakai()
    {
        return $this->belongsTo(BacPakai::class);
    }
}
