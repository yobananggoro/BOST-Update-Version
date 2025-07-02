<?php

namespace Modules\Pemindahbukuan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Account\Entities\TipeRekening;

class ITARequest extends FormRequest
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
            'tipeSrc' => 'required',
            'tipeDst' => 'required',
            'nominal'  => 'required',
        ];
    }

    protected function getValidatorInstance() {
        $validator = parent::getValidatorInstance();
        
        // $validator->sometimes('username', 'required', function($input) {
        //     return $input->nominal >= auth()->user()->profile->limit_kredit;
        // });
        // $validator->sometimes('password', 'required', function($input) {
        //     return $input->nominal >= auth()->user()->profile->limit_kredit;
        // });

        $validator->sometimes('username', 'required', function($input) {
            if($input->tipe_src != null){
                $tipe = TipeRekening::where('type', $input->tipe_src)->first();

                return $tipe->is_block == 1;
            }
        });

        $validator->sometimes('username', 'required', function($input) {
            if($input->tipe_dst != null){
                $tipe = TipeRekening::where('type', $input->tipe_dst)->first();

                return $tipe->is_block == 1;
            }
        });

        $validator->sometimes('password', 'required', function($input) {
            if($input->tipe_src != null){
                $tipe = TipeRekening::where('type', $input->tipe_src)->first();

                return $tipe->is_block == 1;
            }
        });

        $validator->sometimes('password', 'required', function($input) {
            if($input->tipe_dst != null){
                $tipe = TipeRekening::where('type', $input->tipe_dst)->first();

                return $tipe->is_block == 1;
            }
        });

        return $validator;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'tipe_src.required'  => __('validation.required', ['attribute' => 'Rekening Sumber']),
            'tipe_dst.required'  => __('validation.required', ['attribute' => 'Rekening Tujuan']),
            'nominal.required'   => __('validation.required', ['attribute' => 'Nominal']),
            'username.required'  => __('validation.required', ['attribute' => 'Username Otorisasi']),
            'password.required'  => __('validation.required', ['attribute' => 'Password Otorisasi']),
            

        ];
    }
}
