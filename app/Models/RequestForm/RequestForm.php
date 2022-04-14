<?php

namespace App\Models\RequestForm;

use App\Models\Master\CategoryRequest;
use App\Models\Master\Lokasi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_request_id',
        'user_id',
        'lokasi_id',
        'kode',
        'tanggal',
        'berita_acara',
        'status'
    ];

    protected $casts = ['tanggal' => 'date'];

    public function category_request()
    {
        return $this->belongsTo(CategoryRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function detail_request_form()
    {
        return $this->hasMany(DetailRequestForm::class);
    }

    public function status_request_forms()
    {
        return $this->hasMany(StatusRequestForm::class)->orderBy('updated_at');
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
