<?php

namespace App\Models\Inventory;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aso extends Model
{
    use HasFactory;

    protected $table = 'aso';

    protected $fillable = [
        'bac_pakai_id',
        'tanggal_validasi',
        'validasi_by'
    ];

    protected $casts = ['tanggal_validasi' => 'date'];

    public function bac_pakai()
    {
        return $this->belongsTo(BacPakai::class);
    }

    public function divalidasi_oleh()
    {
        return $this->belongsTo(User::class, 'validasi_by', 'id');
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
