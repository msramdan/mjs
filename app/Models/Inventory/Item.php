<?php

namespace App\Models\Inventory;

use App\Models\Accounting\AkunCoa;
use App\Models\Master\Category;
use App\Models\Master\Unit;
use App\Models\Purchase\DetailPurchase;
use App\Models\Sale\DetailSale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'unit_id',
        'akun_coa_id',
        'kode',
        'nama',
        'type',
        'deskripsi',
        'stok',
        'foto',
        'harga_estimasi'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function akun_coa()
    {
        return $this->belongsTo(AkunCoa::class, 'akun_coa_id');
    }

    public function detail_items()
    {
        return $this->hasMany(DetailItem::class);
    }

    public function detail_purchase()
    {
        return $this->hasMany(DetailPurchase::class);
    }

    public function detail_sale()
    {
        return $this->hasMany(DetailSale::class);
    }

    public function detail_bac_pakai()
    {
        return $this->hasMany(DetailBacPakai::class);
    }

    public function detail_bac_terima()
    {
        return $this->hasMany(DetailBacTerima::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d m Y H:i', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d m Y H:i', strtotime($value));
    }
}
