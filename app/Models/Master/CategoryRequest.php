<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryRequest extends Model
{
    use HasFactory;

    protected $table = 'category_request';

    protected $fillable = ['kode', 'nama'];

    public function getCreatedAtAttribute($value)
    {
        return date('d m Y H:i', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d m Y H:i', strtotime($value));
    }
}
