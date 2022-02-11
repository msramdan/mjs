<?php

namespace App\Http\Requests\Accounting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBillingRequest extends FormRequest
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
            'kode' => 'required|unique:billings,kode,' . $this->billing->id,
            'purchase' => 'required|integer',
            'attn' => 'required|string',
            'tanggal_billing' => 'required|date',
            'tanggal_dibayar' => 'nullable|required_if:status_billing,Paid|date|after_or_equal:tanggal_billing',
            'catatan' => 'nullable|string',
            'status_billing' => 'required|in:Unpaid,Paid',
            'nominal_billing' => 'required',
        ];
    }
}
