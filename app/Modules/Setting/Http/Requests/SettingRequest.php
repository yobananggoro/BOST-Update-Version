<?php

namespace Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('setting'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'method' => ['sometimes', 'required', 'string', Rule::in(option_values('auth_method')->pluck('key')->toArray())],
            'api_host' => 'sometimes|required|string',
            //'hash_key' => 'sometimes|required|string',
            //'hash_key' => 'sometimes|string',
            //'domain_hash_key' => 'sometimes|required|string',
            //'domain_hash_key' => 'sometimes|string',
            'force_local' => ['sometimes', 'required', 'string', Rule::in(['true', 'false'])],
            
            'from_address' => 'nullable|string',
            'from_name' => 'nullable|string',
            
            'name' => 'required|string',
            'display_name' => 'required|string',
            'logo' => 'max:500|image|mimes:jpeg,jpg,png',
            'copyright' => 'required|string',
            'display_per_page' => ['required', 'integer', Rule::in(option_values('display_per_page')->pluck('key')->toArray())],
            'auto_logout' => 'required|integer',
            
            'notif_via_email' => ['required', 'string', Rule::in(['true', 'false'])],
            'push_notif' => ['required', 'string', Rule::in(['true', 'false'])],
            'bypass_cutoff' => ['sometimes', 'required', 'string', Rule::in(['true', 'false'])],
            'allowed_notify' => 'sometimes|required|string',
            
            'kode_bank' => 'required|integer',
            'disclaimer' => 'nullable|string',
            'motd' => 'nullable|string',
            'backend_rdn' => 'sometimes|string',
            //'backend_rdn' => 'sometimes|required|string',
            //'ftp_rdn' => 'sometimes|required|ip',
            //'ftp_rdn' => 'sometimes|ip',
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
            'method.required' => __('validation.required', ['attribute' => 'Metode Login yang digunakan']),
            'method.string' => __('validation.string', ['attribute' => 'Metode Login yang digunakan']),
            'method.in' => __('validation.in', ['attribute' => 'Metode Login yang digunakan']),
            'api_host.required' => __('validation.required', ['attribute' => 'Alamat IP untuk login UIM']),
            'api_host.string' => __('validation.string', ['attribute' => 'Alamat IP untuk login UIM']),
            'hash_key.required' => __('validation.required', ['attribute' => 'Hash Key untuk enkripsi otentikasi melalui UIM']),
            //'hash_key.string' => __('validation.string', ['attribute' => 'Hash Key untuk enkripsi otentikasi melalui UIM']),
            //'hash_key.string' => __(['attribute' => 'Hash Key untuk enkripsi otentikasi melalui UIM']),
            'domain_hash_key.required' => __('validation.required', ['attribute' => 'Hash Key untuk enkripsi otentikasi melalui UIM dari Domain Bank BJB']),
            //'domain_hash_key.string' => __('validation.string', ['attribute' => 'Hash Key untuk enkripsi otentikasi melalui UIM dari Domain Bank BJB']),
            //'domain_hash_key.string' => __(['attribute' => 'Hash Key untuk enkripsi otentikasi melalui UIM dari Domain Bank BJB']),
            'force_local.required' => __('validation.required', ['attribute' => 'Login menggunakan local environment']),
            'force_local.string' => __('validation.string', ['attribute' => 'Login menggunakan local environment']),
            'force_local.in' => __('validation.in', ['attribute' => 'Login menggunakan local environment']),
            
            'from_address.required' => __('validation.required', ['attribute' => 'Alamat email pengirim']),
            'from_address.string' => __('validation.string', ['attribute' => 'Alamat email pengirim']),
            'from_name.required' => __('validation.required', ['attribute' => 'Nama email pengirim']),
            'from_name.string' => __('validation.string', ['attribute' => 'Nama email pengirim']),

            'name.required' => __('validation.required', ['attribute' => 'Nama aplikasi']),
            'name.string' => __('validation.string', ['attribute' => 'Nama aplikasi.']),
            'display_name.required' => __('validation.required', ['attribute' => 'Nama aplikasi yang ditampilkan di setiap halaman']),
            'display_name.string' => __('validation.string', ['attribute' => 'Nama aplikasi yang ditampilkan di setiap halaman']),
            'logo.max' => __('validation.max', ['attribute' => 'Logo aplikasi', 'max' => '500kb']),
            'logo.image' => __('validation.image', ['attribute' => 'Logo aplikasi']),
            'logo.mimes' => __('validation.mimes', ['attribute' => 'Logo aplikasi', 'values' => '.jpg, .jpeg atau .png']),
            'copyright.required' => __('validation.required', ['attribute' => 'Hak Cipta aplikasi yang ditampilkan di footer']),
            'copyright.string' => __('validation.string', ['attribute' => 'Hak Cipta aplikasi yang ditampilkan di footer']),
            'display_per_page.required' => __('validation.required', ['attribute' => 'Default data yang ditampilkan dalam tabel']),
            'display_per_page.string' => __('validation.string', ['attribute' => 'Default data yang ditampilkan dalam tabel']),
            'auto_logout.required' => __('validation.required', ['attribute' => 'Auto logout user jika idle (dalam menit)']),
            'auto_logout.integer' => __('validation.string', ['attribute' => 'Auto logout user jika idle (dalam menit)']),
            
            'notif_via_email.required' => __('validation.required', ['attribute' => 'Kirim notifikasi melalui email']),
            'notif_via_email.string' => __('validation.string', ['attribute' => 'Kirim notifikasi melalui email']),
            'notif_via_email.in' => __('validation.in', ['attribute' => 'Kirim notifikasi melalui email']),
            'push_notif.required' => __('validation.required', ['attribute' => 'Aktifkan push notifikasi di aplikasi']),
            'push_notif.string' => __('validation.string', ['attribute' => 'Aktifkan push notifikasi di aplikasi']),
            'push_notif.in' => __('validation.in', ['attribute' => 'Aktifkan push notifikasi di aplikasi']),
            'bypass_cutoff.required' => __('validation.required', ['attribute' => 'By Pass Cut Off']),
            'bypass_cutoff.string' => __('validation.string', ['attribute' => 'By Pass Cut Off']),
            'bypass_cutoff.in' => __('validation.in', ['attribute' => 'By Pass Cut Off']),
            'allowed_notify.required' => __('validation.required', ['attribute' => 'Whitelist IP untuk trigger notifikasi']),
            'allowed_notify.string' => __('validation.string', ['attribute' => 'Whitelist IP untuk trigger notifikasi']),
            
            'kode_bank.required' => __('validation.required', ['attribute' => 'Kode bank bjb yang terdaftar di KSEI/C-BEST']),
            'kode_bank.integer' => __('validation.integer', ['attribute' => 'Kode bank bjb yang terdaftar di KSEI/C-BEST']),
            'disclaimer.string' => __('validation.string', ['attribute' => 'Konten Disclaimer']),
            'motd.string' => __('validation.string', ['attribute' => 'Message of The Day untuk ditampilkan di Halaman Home']),
            'backend_rdn.required' => __('validation.required', ['attribute' => 'IP Backend RDN']),
            'backend_rdn.string' => __('validation.string', ['attribute' => 'IP Backend RDN']),
            'ftp_rdn.required' => __('validation.required', ['attribute' => 'IP FTP RDN']),
            'ftp_rdn.ip' => __('validation.ip', ['attribute' => 'IP FTP RDN']),
        ];
    }
}
