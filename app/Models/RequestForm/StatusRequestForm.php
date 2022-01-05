<?php

namespace App\Models\RequestForm;

use App\Models\Master\SettingCategoryRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusRequestForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_form_id',
        'setting_category_request_form_id',
        'status',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function request_form()
    {
        return $this->belongsTo(RequestForm::class);
    }

    public function setting_category_request()
    {
        return $this->belongsTo(SettingCategoryRequest::class, 'setting_category_request_form_id');
    }
}
