<?php

namespace App\Models\Sale;

use App\Models\Contact\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spal extends Model
{
    use HasFactory;

    protected $table = 'spal';

    protected $fillable = [
        'customer_id',
        'kode',
        'nama_kapal',
        'nama_muatan',
        'jml_muatan',
        'pelabuhan_muat',
        'pelabuhan_bongkar',
        'harga_unit',
        'harga_demorage',
        'nama_tongkang'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function file_spal()
    {
        return $this->hasMany(FileSpal::class);
    }

    public function time_sheets()
    {
        return $this->hasMany(TimeSheet::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d m Y H:i', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d m Y H:i', strtotime($value));
    }
}
