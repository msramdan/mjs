<?php

namespace App\Http\Requests\ElectronicDocument;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
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
            'category_document' => 'required|integer',
            'nama' => 'required|string|min:3|unique:documents,nama,' . $this->document->id,
            'tanggal_buat' => 'nullable|date|before_or_equal:' . now()->format('Y-m-d'),
            'tanggal_expired' => 'nullable|date|after:tanggal_buat',
            'tempat_buat' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,doc,docx,zip,rar,png,jpg,jpeg|max:2048',
        ];
    }
}
