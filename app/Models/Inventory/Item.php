<?php

namespace App\Models\Inventory;

use App\Models\Accounting\Coa;
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
        'akun_beban_id',
        'akun_retur_pembelian_id',
        'akun_penjualan_id',
        'akun_retur_penjualan_id',
        'kode',
        'nama',
        'type',
        'deskripsi',
        'stok',
        'foto',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function akun_beban()
    {
        return $this->belongsTo(Coa::class, 'akun_beban_id');
    }

    public function akun_retur_pembelian()
    {
        return $this->belongsTo(Coa::class, 'akun_retur_pembelian_id');
    }

    public function akun_penjualan()
    {
        return $this->belongsTo(Coa::class, 'akun_penjualan_id');
    }

    public function akun_retur_penjualan()
    {
        return $this->belongsTo(Coa::class, 'akun_retur_penjualan_id');
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
