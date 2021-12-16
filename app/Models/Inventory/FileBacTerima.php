<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileBacTerima extends Model
{
    use HasFactory;

    protected $table = 'file_bac_terima';

    protected $fillable = [
        'bac_terima_id',
        'nama',
        'file',
    ];

    public function bac_terima()
    {
        return $this->belongsTo(BacTerima::class);
    }
}
