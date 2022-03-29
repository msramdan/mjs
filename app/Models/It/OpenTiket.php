<?php

namespace App\Models\It;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class OpenTiket extends Model
{
    use HasFactory;
    protected $table = 'open_tiket';

    protected $fillable = [
        'judul',
        'user_id',
    ];

    function delete_photo()
    {
        if ($this->photo && Storage::exists('public/it/open_tiket/' . $this->photo))
            // Storage::disk('local')->delete('public/artikel/thumbnail/'.$this->thumbnail);
            Storage::delete('public/it/open_tiket/' . $this->photo);
    }
}
