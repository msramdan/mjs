<?php

namespace App\Models\Sale;

use App\Models\Accounting\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'spal_id',
        'tanggal',
        'attn',
        'total',
        'diskon',
        'catatan',
        'grand_total',
        'total_dibayar',
        'lunas'
    ];

    protected $casts = ['tanggal' => 'date'];

    public function spal()
    {
        return $this->belongsTo(Spal::class);
    }

    public function detail_sale()
    {
        return $this->hasMany(DetailSale::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimeString($value)->format('d m Y H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::createFromTimeString($value)->format('d m Y H:i');
    }

    /**
     * Scope a query to to get related invoice with same sale.id.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeRelatedInvoice($query, $invoiceId)
    {
        // $query->select('id', 'kode')->with('invoices:id,sale_id,status,tanggal_dibayar,dibayar')
        //     ->whereHas('invoices', function ($query) use ($invoiceId) {
        //         // $query->where('tanggal_dibayar', '!=', null);
        //         $query->where('status', 'Paid')->where('id', '!=', $invoiceId);
        //     });

        $query->select('sales.id', 'invoices.id', 'invoices.tanggal_dibayar', 'invoices.dibayar')
            ->join('invoices', 'invoices.sale_id', '=', 'sales.id')
            ->where('invoices.id', '!=', $invoiceId)
            ->where('invoices.status', 'Paid');
        // ->where('sales.id', '=', $invoiceId)
        // ->get();
    }
}
