<?php

namespace App\Models\Purchase;

use App\Models\Inventory\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'item_id',
        'harga',
        'qty',
        'sub_total'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
