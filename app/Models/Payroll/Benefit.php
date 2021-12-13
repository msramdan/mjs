<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;
    protected $table = 'data_benefit';
    protected $fillable = ['category_benefit_id', 'besar_benefit','karyawan_id'];
}
