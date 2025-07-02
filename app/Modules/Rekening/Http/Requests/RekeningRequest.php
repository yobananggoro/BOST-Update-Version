<?php

namespace Modules\Rekening\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RekeningRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('rekening'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama' => 'required|unique:mst_rekening,nama',
            // 'tipe_rek' => 'required|exists:mst_acctype,type,is_block,0',
            'tipe_ccy' => 'required',
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
            'nama.required' => __('validation.required', ['attribute' => 'Nama Rekening']),
            'nama.unique' => __('validation.unique', ['attribute' => 'Nama Rekening']),
            'tipe_rek.required' => __('validation.required', ['attribute' => 'Tipe Rekening']),
            'tipe_rek.exists' => __('validation.exists', ['attribute' => 'Tipe Rekening']),
            'tipe_ccy.required' => __('validation.required', ['attribute' => 'Tipe Currency']),
        ];
    }
}
