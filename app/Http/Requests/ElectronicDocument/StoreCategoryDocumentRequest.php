<?php

namespace App\Http\Requests\ElectronicDocument;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryDocumentRequest extends FormRequest
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
            'nama' => 'required|min:3|max:30|unique:category_documents,nama'
        ];
    }
}
