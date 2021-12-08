<?php

namespace App\Models\ElectronicDocument;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'category_document_id',
        'tanggal_buat',
        'tanggal_expired',
        'tempat_buat',
        'file',
    ];

    protected $casts = [
        'tanggal_buat' => 'date',
        'tanggal_expired' => 'date',
    ];

    public function category_document()
    {
        return $this->belongsTo(CategoryDocument::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d m Y H:i', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d m Y H:i', strtotime($value));
    }

    // public function getTanggalBuatAttribute($value)
    // {
    //     return date('d M Y', strtotime($value));
    // }

    // public function getTanggalExpiredAttribute($value)
    // {
    //     return date('d M Y', strtotime($value));
    // }
}
