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
            'tanggal_dibayar' => 'nullable|date|required_if:status_billing,Paid|after_or_equal:tanggal_billing',
            'catatan' => 'nullable|string',
            'status_billing' => 'required|in:Unpaid,Paid',
            'nominal_billing' => 'required',
            'TextFeeBank' => 'nullable',
            'akun_beban' => 'nullable|required_if:status_billing,Paid',
            'akun_sumber' => 'nullable|required_if:status_billing,Paid',
            'nota' => 'nullable|mimes:png,jpg,pdf,doc,docx|max:2048',
            'bukti_bayar' => 'required|mimes:png,jpg,pdf,doc,docx|max:2048'
        ];
    }
}
