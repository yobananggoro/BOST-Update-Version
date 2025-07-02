<?php

namespace Modules\Pemindahbukuan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
// use Modules\Account\Entities\TipeRekening;

class ASIValidasiRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('pemindahbukuan-asi'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'typeSrc' => 'required',
            'amountSrc'  => 'required|same:total',
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
            'typeSrc.required' => __('validation.required', ['attribute' => 'Rekening Sumber']),
            // 'tipe_dst.exists'   => __('validation.exists', ['attribute' => 'Rekening Tujuan']),
            'amountSrc.required'  => __('validation.required', ['attribute' => 'Nominal Sumber']),
            'amountSrc.same'  => __('validation.same', ['attribute' => 'Nominal Sumber', 'other' => 'Total Nominal Tujuan']),
        ];
    }
}
