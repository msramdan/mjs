<?php

namespace App\Http\Requests\Accounting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAkunHeaderRequest extends FormRequest
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
            'kode' => 'required|string|min:3|max:20|unique:account_header,kode,' . $this->akun_header->id,
            'nama' => 'required|string|min:3|max:50|unique:account_header,nama,' . $this->akun_header->id,
            'account_group_id' => 'required|integer'
        ];
    }
}
