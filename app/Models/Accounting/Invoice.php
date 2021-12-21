<?php

namespace App\Models\Accounting;

use App\Models\Sale\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'tanggal_invoice' => 'date'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
