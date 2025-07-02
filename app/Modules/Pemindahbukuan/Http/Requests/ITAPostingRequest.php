<?php

namespace Modules\Pemindahbukuan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ITAPostingRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('pemindahbukuan-ita'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required',
        ];
    }

    // protected function getValidatorInstance() {
    //     $validator = parent::getValidatorInstance();
        
    //     $validator->sometimes('username', 'required', function($input) {
    //         return $input->nominal >= auth()->user()->profile->limit_kredit;
    //     });
    //     $validator->sometimes('password', 'required', function($input) {
    //         return $input->nominal >= auth()->user()->profile->limit_kredit;
    //     });

    //     return $validator;
    // }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required'  => __('validation.required', ['attribute' => 'Username Otorisasi']),
            'password.required'  => __('validation.required', ['attribute' => 'Password Otorisasi']),
            

        ];
    }
}
