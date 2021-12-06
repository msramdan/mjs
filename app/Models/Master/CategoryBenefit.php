<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBenefit extends Model
{
    use HasFactory;

    protected $table = 'category_benefit';

    protected $fillable = ['nama'];

    public function getCreatedAtAttribute($value)
    {
        return date('d m Y H:i', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d m Y H:i', strtotime($value));
    }
}
