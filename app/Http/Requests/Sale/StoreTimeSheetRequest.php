<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimeSheetRequest extends FormRequest
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
            'spal_id' => 'required|exists:spal,id',
            'qty' => 'nullable',
            'hari' => 'nullable',
            'jam' => 'nullable',
            'menit' => 'nullable',
            'date.*' => 'required|date',
            'remark.*' => 'required|string',
            'from.*' => 'required|date_format:H:i',
            'to.*' => 'required|date_format:H:i|after:from.*',
            'keterangan.*' => 'required|string',
        ];
    }
}
