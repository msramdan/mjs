<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewDetailBacTerima extends Model
{
    use HasFactory;

    protected $table = 'new_detail_bac_terima';

    protected $fillable = [
        'new_bac_terima_id',
        'item_id',
        'harga',
        'qty_terima',
        'qty_validasi',
    ];

    public function new_bac_terima()
    {
        return $this->belongsTo(NewBacTerima::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
