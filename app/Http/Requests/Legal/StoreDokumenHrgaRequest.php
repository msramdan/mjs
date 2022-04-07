<?php

namespace App\Http\Requests\Legal;

use Illuminate\Foundation\Http\FormRequest;

class StoreDokumenHrgaRequest extends FormRequest
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
            'nama' => 'required|string|min:2|unique:dokumen_hrga,nama',
            'file' => 'required|mimes:png,jpg,jpeg,pdf,doc,docx|max:4048',
            'keterangan' => 'required|string|min:3'
        ];
    }
}
