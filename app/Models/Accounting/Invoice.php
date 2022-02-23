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
}
