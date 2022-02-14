<?php

namespace App\Http\Requests\Accounting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kode' => 'required|unique:invoices,kode,' . $this->invoice->id,
            'sale' => 'required|integer',
            'attn' => 'required|string',
            'tanggal_invoice' => 'required|date',
            'tanggal_dibayar' => 'nullable|required_if:status_invoice,Paid|date|after_or_equal:tanggal_invoice',
            'catatan' => 'nullable|string',
            'status_invoice' => 'required|in:Unpaid,Paid',
            'nominal_invoice' => 'required',
        ];
    }
}
