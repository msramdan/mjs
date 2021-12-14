<?php

namespace App\Models\Purchase;

use App\Models\RequestForm\RequestForm;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_form_id',
        'tanggal',
        'attn',
        'total',
        'diskon',
        'catatan',
        'grand_total'
    ];

    protected $casts = ['tanggal' => 'date'];

    public function request_form()
    {
        return $this->belongsTo(RequestForm::class);
    }

    public function detail_purchase()
    {
        return $this->hasMany(DetailPurchase::class);
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
