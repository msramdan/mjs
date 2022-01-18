<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpalRequest extends FormRequest
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
            'customer' => 'required|integer',
            'kode' => 'required|min:3|max:30|unique:spal,kode',
            'nama_kapal' => 'required|string|min:3|max:50',
            'nama_muatan' => 'required|string|min:3|max:50',
            'jml_muatan' => 'required|integer|min:1',
            'pelabuhan_muat' => 'required|string|min:3|max:50',
            'pelabuhan_bongkar' => 'required|string|min:3|max:50',
            'harga_unit' => 'required|integer|min:1',
            'nama_file.*' => 'required|string|min:2',
            'file.*' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:1024',
        ];
    }
}
