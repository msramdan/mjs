<?php

namespace App\Models\RequestForm;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusRequestForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'request_form_id',
        'step',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function request_form()
    {
        return $this->belongsTo(RequestForm::class);
    }
}
