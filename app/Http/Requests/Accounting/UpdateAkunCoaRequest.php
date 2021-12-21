<?php

namespace App\Http\Requests\Accounting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAkunCoaRequest extends FormRequest
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
            'kode' => 'required|string|min:3|max:20|unique:account_coa,kode,' . request()->segment(3),
            'nama' => 'required|string|min:3|max:50|unique:account_coa,nama,' . request()->segment(3),
            'account_header_id' => 'required|integer',
            'normal' => 'required|string',
            'remark' => 'required|string'
        ];
    }
}
