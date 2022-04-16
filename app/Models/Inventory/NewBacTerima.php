<?php

namespace App\Models\Inventory;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewBacTerima extends Model
{
    use HasFactory;

    protected $table = 'new_bac_terima';

    protected $fillable = [
        'kode',
        'user_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date:d/m/Y',
        'created_at' => 'datetime:d-m-Y H:i',
        'updated_at' => 'datetime:d-m-Y H:i'
    ];

    public function new_detail_bac_terima()
    {
        return $this->hasMany(NewDetailBacTerima::class);
    }

    public function new_file_bac_terima()
    {
        return $this->hasMany(NewFileBacTerima::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
