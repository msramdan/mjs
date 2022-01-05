<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingCategoryRequest extends Model
{
    use HasFactory;

    protected $table = 'setting_category_request_forms';

    protected $fillable = [
        'category_request_id',
        'user_id',
        'step'
    ];

    public function category_request()
    {
        return $this->belongsTo(CategoryRequest::class, 'category_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
