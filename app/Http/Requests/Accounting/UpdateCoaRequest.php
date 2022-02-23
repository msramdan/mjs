<?php

namespace App\Http\Requests\Accounting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoaRequest extends FormRequest
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
            'kode' => 'required|min:3|max:30|unique:coas,kode,' . $this->coa,
            'nama' => 'required|min:3|max:30',
            'tipe' => 'required',
            'kategori' => 'required',
            'parent' => 'nullable'
        ];
    }
}
