<?php

namespace App\Models\Inventory;

use App\Models\Contact\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'supplier_id',
        'harga_beli'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
