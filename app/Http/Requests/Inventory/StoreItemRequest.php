<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'kode' => 'required|string|min:3|max:20|unique:items,kode',
            'nama' => 'required|string|min:3|max:50',
            'type' => 'required|in:Consumable,Services',
            'deskripsi' => 'required|string|min:3',
            'akun_beban' => 'required|integer',
            'akun_retur_pembelian' => 'required|integer',
            'akun_penjualan' => 'required|integer',
            'akun_retur_penjualan' => 'required|integer',
            'foto' => 'required|image|max:1024',
            'stok' => 'required'
        ];
    }
}
