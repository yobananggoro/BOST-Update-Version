<?php

namespace Modules\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ABRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('account-balance'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'extAcctNumber' => 'required_without:branch,cif,suffix',
            // 'branch' => 'required_without:extAcctNumber',
            // 'cif' => 'required_without:extAcctNumber',
            // 'suffix' => 'required_without:extAcctNumber',
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
            // 'extAcctNumber.required' => __('validation.required', ['attribute' => 'Account External']),
            // 'branch.required' => __('validation.required', ['attribute' => 'Branch']),
            // 'cif.required' => __('validation.required', ['attribute' => 'Cif']),
            // 'suffix.unique' => __('validation.unique', ['attribute' => 'Suffix']),
            // 'visible.required' => __('validation.required', ['attribute' => 'Visibility']),
        ];
    }
}
