<?php

namespace App\Models\Sale;

use App\Models\Accounting\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'spal_id',
        'tanggal',
        'attn',
        'total',
        'diskon',
        'catatan',
        'grand_total',
        'status_pembayaran',
        'sisa',
        'total_dibayar'
    ];

    protected $casts = ['tanggal' => 'date'];

    public function spal()
    {
        return $this->belongsTo(Spal::class);
    }

    public function detail_sale()
    {
        return $this->hasMany(DetailSale::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimeString($value)->format('d m Y H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::createFromTimeString($value)->format('d m Y H:i');
    }
}
