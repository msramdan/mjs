<?php

namespace App\Http\Requests\Accounting;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'kode' => 'required|unique:invoices,kode',
            'sale' => 'required|integer',
            'attn' => 'required|string',
            'tanggal_invoice' => 'required|date',
            'dibayar' => 'required|integer|min:1|max:' . request()->sisa_hidden,
            'catatan' => 'nullable|string',
            'akun_piutang' => 'required',
            'akun_pendapatan' => 'required',
        ];
    }
}
