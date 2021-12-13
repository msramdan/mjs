<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Potongan extends Model
{
    use HasFactory;
    protected $table = 'data_potongan';
    protected $fillable = ['category_potongan_id', 'besar_potongan','karyawan_id'];
}
