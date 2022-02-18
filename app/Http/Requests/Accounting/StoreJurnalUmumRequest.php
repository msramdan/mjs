<?php

namespace App\Http\Requests\Accounting;

use Illuminate\Foundation\Http\FormRequest;

class StoreJurnalUmumRequest extends FormRequest
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
            'tanggal' => 'required|date',
            'no_bukti' => 'required|string',
            'coa_id.*' => 'required|exists:account_coa,id',
            'deskripsi.*' => 'required|string',
            'debit.*' => 'required|numeric',
            'kredit.*' => 'required|numeric',
        ];
    }
}
