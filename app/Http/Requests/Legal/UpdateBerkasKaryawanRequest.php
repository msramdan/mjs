<?php

namespace App\Http\Requests\Legal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBerkasKaryawanRequest extends FormRequest
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
            'nama.*' => 'required|string|min:3',
            'file.*' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:4048',
        ];
    }
}
