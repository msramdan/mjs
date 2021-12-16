<?php

namespace App\Models\Inventory;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBacTerima extends Model
{
    use HasFactory;

    protected $table = 'detail_bac_terima';

    protected $fillable = [
        'bac_terima_id',
        'item_id',
        'harga',
        'qty',
    ];

    protected $casts = ['tanggal' => 'date'];

    public function bac_terima()
    {
        return $this->belongsTo(BacTerima::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
