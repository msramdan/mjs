<?php

namespace App\Models\RequestForm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRequestForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_form_id',
        'nama',
        'file',
    ];

    public function request_form()
    {
        return $this->belongsTo(RequestForm::class);
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
