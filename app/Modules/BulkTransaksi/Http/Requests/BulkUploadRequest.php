<?php

namespace Modules\BulkTransaksi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkUploadRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|max:2000|mimes:xlsx,xls'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'file.required' => __('validation.required', ['attribute' => 'File yang anda lampirkan tidak sesuai ketentuan!']),
        ];
    }
}
