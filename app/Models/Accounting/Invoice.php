<?php

namespace App\Models\Accounting;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Sale\Sale;
use App\Models\Accounting\JurnalUmum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'sale_id',
        'user_id',
        'attn',
        'tanggal_dibayar',
        'tanggal_invoice',
        'dibayar',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_dibayar' => 'date',
        'tanggal_invoice' => 'date',
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurnals()
    {
        return $this->morphMany(JurnalUmum::class, 'ref');
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return Carbon::createFromTimeString($value)->format('d m Y H:i');
    // }

    // public function getUpdatedAtAttribute($value)
    // {
    //     return Carbon::createFromTimeString($value)->format('d m Y H:i');
    // }


    /**
     * Scope a query to get some fields data for print page.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopePrint($qeury)
    {
        $qeury->select(
            'id',
            'sale_id',
            'attn',
            'kode',
            'tanggal_invoice',
            // 'status',
            'dibayar',
            'catatan'
        )
            ->with(
                'sale:id,spal_id,kode,diskon,grand_total',
                'sale.spal:id,kode,customer_id,jml_muatan,harga_unit',
                'sale.spal.customer:id,kode,nama,email,alamat,telp',
                // 'sale.detail_sale:id,sale_id,item_id,harga,qty,sub_total',
                // 'sale.detail_sale.item:id,kode,nama',
            );
    }
}
