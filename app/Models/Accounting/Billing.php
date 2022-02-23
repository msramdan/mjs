<?php

namespace App\Models\Accounting;

use App\Models\Purchase\Purchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'purchase_id',
        'user_id',
        'attn',
        'tanggal_dibayar',
        'tanggal_billing',
        'dibayar',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_dibayar' => 'date',
        'tanggal_billing' => 'date'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurnals()
    {
        return $this->morphMany(JurnalUmum::class, 'ref');
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
