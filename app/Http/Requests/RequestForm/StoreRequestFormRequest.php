<?php

namespace App\Http\Requests\RequestForm;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestFormRequest extends FormRequest
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
            'category_request' => 'required|integer',
            'kode' => 'required|unique:request_forms,kode',
            'tanggal' => 'required|date',
            'berita_acara' => 'required|string',
            'status' => 'required|in:Aktif,Non-aktif',
            'nama.*' => 'required|string|min:3',
            'file.*' => 'required|mimes:pdf,doc,docx,zip,rar,png,jpg,jpeg|max:2048',
        ];
    }
}
