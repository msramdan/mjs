<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewBacTerimaRequest extends FormRequest
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
            'kode' => 'required|unique:new_bac_terima,kode,' . $this->new_bac_terima,
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|min:2',
            'produk.*' => 'required|integer',
            'qty.*' => 'required|integer|min:1',
            'nama.*' => 'nullable|string|min:2',
            'file.*' => 'nullable|mimes:pdf,doc,docx,png,jpg,jpeg|max:1024',
        ];
    }
}
