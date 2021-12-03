<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'kode' => 'required|max:20|min:3',
            'nama' => 'required|string|max:100|min:3',
            'email' => 'required|email|unique:customers,email',
            'alamat' => 'required|min:3',
            'kota' => 'required|max:30|min:3',
            'provinsi' => 'required|max:30|min:3',
            'telp' => 'required|max:20',
            'personal_kontak' => 'nullable|max:20',
            'website' => 'nullable|max:100',
            'kode_pos' => 'nullable|max:20',
            'catatan' => 'nullable',
        ];
    }
}
