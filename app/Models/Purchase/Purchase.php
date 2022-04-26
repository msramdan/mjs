<?php

namespace App\Models\Purchase;

use App\Models\Accounting\Billing;
use Carbon\Carbon;
use App\Models\Contact\Supplier;
use App\Models\Inventory\BacTerima;
use App\Models\RequestForm\RequestForm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_form_id',
        'supplier_id',
        'kode',
        'tanggal',
        'attn',
        'total',
        'diskon',
        'catatan',
        'tax',
        'grand_total',
        'total_dibayar',
        'lunas',
        'approve_by_gm',
        'approve_by_direktur'
    ];

    protected $casts = ['tanggal' => 'date'];

    public function request_form()
    {
        return $this->belongsTo(RequestForm::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detail_purchase()
    {
        return $this->hasMany(DetailPurchase::class);
    }

    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    public function bac_terima()
    {
        return $this->hasOne(BacTerima::class);
    }

    public function approved_by_gm()
    {
        return $this->belongsTo(User::class, 'approve_by_gm');
    }

    public function approved_by_direktur()
    {
        return $this->belongsTo(User::class, 'approve_by_direktur');
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
