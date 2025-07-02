<?php

namespace Modules\Pemindahbukuan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Account\Entities\TipeRekening;

class ITAValidasiRequest extends FormRequest
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
            // 'tipeSrc' => 'required',
            // 'tipeDst' => 'required',
            // 'nominal'  => 'required',
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
            if($input->tipeSrc != null){
                $tipe = TipeRekening::where('type', $input->tipeSrc)->first();

                return $tipe->is_block == 1;
            }
        });

        $validator->sometimes('username', 'required', function($input) {
            if($input->tipeDst != null){
                $tipe = TipeRekening::where('type', $input->tipeDst)->first();

                return $tipe->is_block == 1;
            }
        });

        $validator->sometimes('password', 'required', function($input) {
            if($input->tipeSrc != null){
                $tipe = TipeRekening::where('type', $input->tipeSrc)->first();

                return $tipe->is_block == 1;
            }
        });

        $validator->sometimes('password', 'required', function($input) {
            if($input->tipeDst != null){
                $tipe = TipeRekening::where('type', $input->tipeDst)->first();

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
            // 'tipeSrc.required' => __('validation.required', ['attribute' => 'Silahkan klik tombol Detail terlebih dahulu']),
            // 'tipeDst.required' => __('validation.required', ['attribute' => 'Silahkan klik tombol Detail terlebih dahulu']),
            // 'nominal.required'  => __('validation.required', ['attribute' => 'Nominal']),
            'username.required'  => __('validation.required', ['attribute' => 'Username Otorisasi']),
            'password.required'  => __('validation.required', ['attribute' => 'Password Otorisasi']),
        ];
    }
}
