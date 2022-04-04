<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
            'category' => 'required|integer',
            'unit' => 'required|integer',
            'kode' => 'required|string|min:3|max:20|unique:items,kode,' . $this->item->id,
            'nama' => 'required|string|min:3|max:50',
            'type' => 'required|in:Consumable,Services,Storageable',
            'deskripsi' => 'nullable|string|min:3',
            'foto' => 'nullable|image|max:1024',
            'stok' => 'nullable|integer',
            'supplier' => 'nullable|exists:suppliers,id',
            'harga_beli' => 'nullable',
            'supplier.*' => 'nullable|exists:suppliers,id',
            'harga_beli.*' => 'nullable',
            'is_demorage' => 'nullable'
        ];
    }
}
