<?php

namespace App\Models\Inventory;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BacPakai extends Model
{
    use HasFactory;

    protected $table = 'bac_pakai';

    protected $fillable = [
        'kode',
        'user_id',
        'tanggal',
        'keterangan',
        'status',
    ];

    protected $casts = ['tanggal' => 'date'];

    public function detail_bac_pakai()
    {
        return $this->hasMany(DetailBacPakai::class);
    }

    public function file_bac_pakai()
    {
        return $this->hasMany(FileBacPakai::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aso()
    {
        return $this->hasOne(Aso::class);
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
