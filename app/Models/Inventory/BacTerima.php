<?php

namespace App\Models\Inventory;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BacTerima extends Model
{
    use HasFactory;

    protected $table = 'bac_terima';

    protected $fillable = [
        'kode',
        'user_id',
        'tanggal',
        'keterangan',
        'status',
    ];

    protected $casts = ['tanggal' => 'date'];

    public function detail_bac_terima()
    {
        return $this->hasMany(DetailBacTerima::class);
    }

    public function file_bac_terima()
    {
        return $this->hasMany(FileBacTerima::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function received()
    {
        return $this->hasOne(Received::class);
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
