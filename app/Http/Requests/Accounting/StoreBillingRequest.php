<?php

namespace App\Http\Requests\Accounting;

use Illuminate\Foundation\Http\FormRequest;

class StoreBillingRequest extends FormRequest
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
            'kode' => 'required|unique:billings,kode',
            'purchase' => 'required|integer',
            'attn' => 'required|string',
            'tanggal_billing' => 'required|date',
            'dibayar' => 'required|integer|min:1|max:' . request()->sisa_hidden,
            'catatan' => 'required|string'
        ];
    }
}
