<?php

namespace App\Models\Legal;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenHrga extends Model
{
    use HasFactory;

    protected $table = 'dokumen_hrga';

    protected $fillable = [
        'nama',
        'file',
        'keterangan'
    ];

    public function history_downloads()
    {
        return $this->hasMany(HistoryDownloadHrga::class);
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
