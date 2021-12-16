<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBacPakai extends Model
{
    use HasFactory;

    protected $table = 'detail_bac_pakai';

    protected $fillable = [
        'bac_pakai_id',
        'item_id',
        'harga',
        'qty',
    ];

    protected $casts = ['tanggal' => 'date'];

    public function bac_pakai()
    {
        return $this->belongsTo(BacPakai::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
