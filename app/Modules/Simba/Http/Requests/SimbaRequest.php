<?php

namespace Modules\Simba\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SimbaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('simba'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label' => 'required',
            'uri' => 'required',
            'sequence' => 'required|unique:mst_module,sequence',
            'visible' => 'required',
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
            'label.required' => __('validation.required', ['attribute' => 'Label']),
            'uri.required' => __('validation.required', ['attribute' => 'Url']),
            'sequence.required' => __('validation.required', ['attribute' => 'Sequence']),
            'sequence.unique' => __('validation.unique', ['attribute' => 'Sequence']),
            'visible.required' => __('validation.required', ['attribute' => 'Visibility']),
        ];
    }
}
