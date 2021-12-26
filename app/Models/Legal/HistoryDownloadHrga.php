<?php

namespace App\Models\Legal;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryDownloadHrga extends Model
{
    use HasFactory;

    protected $table = 'history_download_hrga';

    protected $fillable = [
        'dokumen_hrga_id',
        'user_id',
        'language',
        'device',
        'os',
        'browser',
        'robot',
        'ip',
        'header',
    ];

    // protected $casts = ['agent' => 'json'];

    public function dokumen_hrga()
    {
        return $this->belongsTo(DokumenHrga::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
