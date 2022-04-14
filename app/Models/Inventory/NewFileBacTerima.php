<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewFileBacTerima extends Model
{
    use HasFactory;

    protected $table = 'new_file_bac_terima';

    protected $fillable = [
        'new_bac_terima_id',
        'nama',
        'file',
    ];

    public function new_bac_terima()
    {
        return $this->belongsTo(NewBacTerima::class);
    }
}
