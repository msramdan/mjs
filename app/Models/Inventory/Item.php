<?php

namespace App\Models\Inventory;

use App\Models\Master\Category;
use App\Models\Master\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'unit_id',
        'kode',
        'nama',
        'type',
        'deskripsi',
        'stok',
        'foto',
        'akun_beban',
        'akun_retur_pembelian',
        'akun_penjualan',
        'akun_retur_penjualan',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
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
