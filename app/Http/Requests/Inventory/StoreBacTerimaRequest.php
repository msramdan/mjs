<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class StoreBacTerimaRequest extends FormRequest
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
            'kode' => 'required|unique:bac_terima,kode',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|min:2',
            'produk_id.*' => 'required|integer',
            'qty.*' => 'required|integer|min:1',
            'nama.*' => 'required|string|min:2|max:30',
            'file.*' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:1024',
        ];
    }
}
