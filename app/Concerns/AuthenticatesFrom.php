<?php

namespace App\Concerns;

use Modules\User\Entities\User;
use Modules\User\Entities\Role;
use GuzzleHttp\Exception\ClientException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

trait AuthenticatesFrom
{
    /**
     * @var int
     */
    protected $level;

    /** 
     * @var string
     */
    protected $role;

    /** 
     * @param array $credentials
     * @return bool
     */
    public function local(array $credentials): bool
    {
        if ($is_authenticated = $this->guard()->attempt($credentials)) {
            $r = User::findByUsername($credentials[$this->username()])->roles->first();

            $this->level = $r->id; //id role
            $this->role = $r->name; //nama role
        }
        // dd($is_authenticated);
        return $is_authenticated;
    }

    /**
     * @param array $credentials
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uim(array $credentials, $request)
    {
        // dd($credentials);exit;
        $secretKey = config('app.https') ? config('auth.domain_hash_key') : config('auth.hash_key');
        $username = $this->username();
        $client = new \GuzzleHttp\Client();
        $encrypter = new \Illuminate\Encryption\Encrypter($secretKey, config('app.cipher'));

        try {
            $response = $client->request('POST', config('auth.api_host'), [
                'form_params' => [
                    'userId' => $credentials[$username],
                    'password' => $encrypter->encrypt($credentials['password']),
                    'appId' => config('app.id'),
                ],
            ]);

            // dd($response->getBody()->getContents());
            if ($response->getStatusCode() == 200) {
                $res = json_decode($response->getBody()->getContents())->response;
                // dd($res, $res->idFungsi, trim($res->namaFungsi));

                $user = User::findByUsername($credentials[$username]);
                if (!is_null($user->first())) {
                    $now = now();
                    $idle = $now->diffInMinutes($user->last_activity);

                    // dd($idle, config('session.lifetime'));
                    if ($user->isLogin == true) {
                        if ($idle <= config('session.lifetime')) {
                            $this->sendMultipleLoggedInNotAllowedResponse($request);

                            return false;
                        }
                    }
                }

                $this->level = $res->idFungsi;
                $this->role = trim($res->namaFungsi);
                if (!is_null($user->first())) {
                    $user->update(['password' => $credentials['password']]);
                    $user->profile()->update([
                        'nama' => to_upper($res->nama),
                        'nip' => $res->nip,
                        'hp' => trim($res->hp),
                        'unit_kerja_kode' => trim($res->kodeCabang),
                        'rolename' => to_upper($res->namaFungsi),
                        'idrole' => trim($res->idFungsi),
                        'limit_debet' => trim($res->limitDebet),
                        'limit_kredit' => trim($res->limitKredit)
                    ]);
                } else {
                    if ($res->idFungsi == "1302" || $res->idFungsi == "1316") {
                        User::create([
                            $username => $credentials[$username],
                            'password' => $credentials['password'],
                            'email' => trim($res->email),
                            'status' => 1
                        ]);
                    } else {
                        User::create([
                            $username => $credentials[$username],
                            'password' => $credentials['password'],
                            'email' => trim($res->email),
                            'status' => 0
                        ]);
                    }

                    $user = User::findByUsername($credentials[$username]);
                    $user->profile()->create([
                        'nama' => to_upper($res->nama),
                        'nip' => $res->nip,
                        'hp' => trim($res->hp),
                        'unit_kerja_kode' => trim($res->kodeCabang),
                        'rolename' => to_upper($res->namaFungsi),
                        'idrole' => trim($res->idFungsi),
                        'limit_debet' => trim($res->limitDebet),
                        'limit_kredit' => trim($res->limitKredit)

                    ]);
                }

                $user->syncRoles($res->namaFungsi);
                // $user->syncRoles($res->menu);
                $user->syncPermissions((\Modules\HakAkses\Entities\Role::where('id', $this->level)->first())
                    ->permissions()->pluck('name')->toArray());

                return true;
            }

            return false;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() == '404') {
                    return false;
                }
            }
        }
    }

    /**
     * @param array $credentials
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uimNG_old(array $credentials, $request)
    {
        // dd(env('UIM_URL_CONVERTER'));exit;
        $secretKey = config('app.https') ? config('auth.domain_hash_key') : config('auth.hash_key');
        $username = $this->username();
        // $client = new \GuzzleHttp\Client();
        $encrypter = new \Illuminate\Encryption\Encrypter($secretKey, config('app.cipher'));
        // $url = config('auth.api_host');
        $url = env('UIM_URL_CONVERTER');
        $role = Role::pluck('name')->all();
        $message = [
            'userId'        => $credentials[$username],
            'password'      => $credentials['password']
            // 'password'      => $encrypter->encrypt($credentials['password']),
            // 'appId'         => config('app.id'),
            // 'isEncrypted'   => true
        ];
        // dd($role);

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($url, $message);
            unset($message['password']);
            Log::info("Auth UIM Request: " . json_encode($message));
            Log::info("Auth UIM Response: " . json_encode(json_decode($response, true)));
            // dd($response, $response->getBody()->getContents(), json_decode($response, true), json_encode(json_decode($response, true)), $response->getStatusCode());

            if ($response->getStatusCode() == 200) {
                if (json_decode($response['statusCode'], true) == 200) {
                    // $res = json_decode($response->getBody()->getContents())->data; //Tidak bisa menampilkan log
                    $res = json_decode($response, true)['data']; //dapat menggunakan log
                    // dd($res, $res->idFungsi, trim($res->namaFungsi));
                    // dd($res, $res['idFungsi']);

                    $user = User::findByUsername($credentials[$username]);
                    if (!is_null($user->first())) {
                        $now = now();
                        $idle = $now->diffInMinutes($user->last_activity);

                        // dd($idle, config('session.lifetime'));
                        if ($user->isLogin == true && $user->profile->rolename != 'SUPER ADMIN') {
                            if ($idle <= config('session.lifetime')) {
                                $this->sendMultipleLoggedInNotAllowedResponse($request);

                                return false;
                            }
                        }
                    }

                    $this->level = $res['idFungsi'];
                    $this->role = trim($res['namaFungsi']);


                    if (!is_null($user->first())) {
                        $user->update(['password' => $credentials['password']]);
                        $user->profile()->update([
                            'nama' => to_upper($res['nama']),
                            'nip' => $res['nip'],
                            'hp' => null,
                            'unit_kerja_kode' => trim($res['kodeCabang']),
                            // 'rolename' => to_upper($res['namaFungsi']),
                            'rolename' => $res['namaFungsi'],
                            'idrole' => trim($res['idFungsi']),
                            'jabatan' => $res['jabatan']
                        ]);
                    } else {
                        if (in_array(trim($res['namaFungsi']), $role) == true) {
                            if (!in_array($res['namaFungsi'], ['Operator'])) {
                                User::create([
                                    $username => $credentials[$username],
                                    'password' => $credentials['password'],
                                    'email' => trim($res['email']),
                                    'status' => 1,
                                    'isLogin' => false
                                ]);

                                $user = User::findByUsername($credentials[$username]);
                                $user->profile()->create([
                                    'nama' => to_upper($res['nama']),
                                    'nip' => $res['nip'],
                                    'hp' => null,
                                    'unit_kerja_kode' => trim($res['kodeCabang']),
                                    // 'rolename' => to_upper($res['namaFungsi']),
                                    'rolename' => $res['namaFungsi'],
                                    'idrole' => trim($res['idFungsi']),
                                    'jabatan' => $res['jabatan'],
                                    'limit_debet' => 5000000000,
                                    'limit_kredit' => 5000000000,
                                    'isFinger' => true
                                ]);
                            } else {
                                User::create([
                                    $username => $credentials[$username],
                                    'password' => $credentials['password'],
                                    'email' => trim($res['email']),
                                    'status' => 0,
                                    'isLogin' => false
                                ]);

                                $user = User::findByUsername($credentials[$username]);
                                $user->profile()->create([
                                    'nama' => to_upper($res['nama']),
                                    'nip' => $res['nip'],
                                    'hp' => null,
                                    'unit_kerja_kode' => trim($res['kodeCabang']),
                                    // 'rolename' => to_upper($res['namaFungsi']),
                                    'rolename' => $res['namaFungsi'],
                                    'idrole' => trim($res['idFungsi']),
                                    'jabatan' => $res['jabatan'],
                                    'isFinger' => true
                                ]);
                            }
                        } else {
                            return false;
                        }
                    }

                    $user->syncRoles(trim($res['namaFungsi']));
                    $user->syncPermissions((\Modules\HakAkses\Entities\Role::where('id', $this->level)->first())->permissions()->pluck('name')->toArray());
                    // dd($user);

                    return true;
                    $r = User::findByUsername($credentials[$this->username()])->roles->first();

                    $this->level = $r->id; //id role
                    $this->role = $r->name; //nama role
                }

                return false;
            }

            return false;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() == '404') {
                    return false;
                }
            }
        }
    }

    public function uimNG(array $credentials, $request)
    {
        // dd(env('UIM_URL_CONVERTER'));exit;
        $secretKey = config('app.https') ? config('auth.domain_hash_key') : config('auth.hash_key');
        $username = $this->username();
        // $client = new \GuzzleHttp\Client();
        $encrypter = new \Illuminate\Encryption\Encrypter($secretKey, config('app.cipher'));
        // $url = config('auth.api_host');
        $url = env('UIM_URL_CONVERTER');
        $role = Role::pluck('name')->all();
        $message = [
            'userId'        => $credentials[$username],
            'password'      => $credentials['password']
            // 'password'      => $encrypter->encrypt($credentials['password']),
            // 'appId'         => config('app.id'),
            // 'isEncrypted'   => true
        ];
        // dd($role);

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($url, $message);
            unset($message['password']);
            Log::info("Auth UIM Request: " . json_encode($message));
            Log::info("Auth UIM Response: " . json_encode(json_decode($response, true)));
            // dd($response, $response->getBody()->getContents(), json_decode($response, true), json_encode(json_decode($response, true)), $response->getStatusCode());

            if ($response->getStatusCode() == 200) {
                if (json_decode($response['statusCode'], true) == 200) {
                    // $res = json_decode($response->getBody()->getContents())->data; //Tidak bisa menampilkan log
                    $res = json_decode($response, true)['data']; //dapat menggunakan log
                    // dd($res, $res->idFungsi, trim($res->namaFungsi));
                    // dd($res, $res['idFungsi']);

                    $user = User::findByUsername($credentials[$username]);
                    if (!is_null($user->first())) {
                        $now = now();
                        $idle = $now->diffInMinutes($user->last_activity);

                        // dd($request);
                        // dd($idle, config('app.auto_logout'), Session::getId(), $user->session_id, 'authform');
                        if ($user->isLogin == true && $user->profile->rolename != 'SUPER ADMIN') {
                            // dd('0', 'authform');
                            if ($idle <= config('app.auto_logout')) {
                                // dd('a', 'authform');
                                $this->sendMultipleLoggedInNotAllowedResponse($request);

                                return false;
                            } else {
                                // dd('b', 'authform');
                                $user->isLogin = false;
                                $user->update();
                            }
                        }
                    }

                    $this->level = $res['idFungsi'];
                    $this->role = trim($res['namaFungsi']);

                    if (!is_null($user->first())) {
                        $user->update(['password' => $credentials['password']]);
                        $user->profile()->update([
                            'nama' => to_upper($res['nama']),
                            'nip' => $res['nip'],
                            'hp' => null,
                            // 'unit_kerja_kode' => trim($res['kodeCabang']),
                            'unit_kerja_kode' => trim($res['kodePenempatan']),
                            'unit_kerja_induk' => trim($res['kodeCabang']),
                            // 'rolename' => to_upper($res['namaFungsi']),
                            'rolename' => $res['namaFungsi'],
                            'idrole' => trim($res['idFungsi']),
                            'jabatan' => $res['jabatan']
                        ]);
                    } else {
                        if (in_array(trim($res['namaFungsi']), $role) == true) {
                            if (!in_array($res['namaFungsi'], ['Operator'])) {
                                User::create([
                                    $username => $credentials[$username],
                                    'password' => $credentials['password'],
                                    'email' => trim($res['email']),
                                    'status' => 1,
                                    'isLogin' => false
                                ]);

                                $user = User::findByUsername($credentials[$username]);
                                $user->profile()->create([
                                    'nama' => to_upper($res['nama']),
                                    'nip' => $res['nip'],
                                    'hp' => null,
                                    // 'unit_kerja_kode' => trim($res['kodeCabang']),
                                    'unit_kerja_kode' => trim($res['kodePenempatan']),
                                    'unit_kerja_induk' => trim($res['kodeCabang']),
                                    // 'rolename' => to_upper($res['namaFungsi']),
                                    'rolename' => $res['namaFungsi'],
                                    'idrole' => trim($res['idFungsi']),
                                    'jabatan' => $res['jabatan'],
                                    'limit_debet' => 5000000000,
                                    'limit_kredit' => 5000000000,
                                    'isFinger' => true
                                ]);
                            } else {
                                User::create([
                                    $username => $credentials[$username],
                                    'password' => $credentials['password'],
                                    'email' => trim($res['email']),
                                    'status' => 0,
                                    'isLogin' => false
                                ]);

                                $user = User::findByUsername($credentials[$username]);
                                $user->profile()->create([
                                    'nama' => to_upper($res['nama']),
                                    'nip' => $res['nip'],
                                    'hp' => null,
                                    // 'unit_kerja_kode' => trim($res['kodeCabang']),
                                    'unit_kerja_kode' => trim($res['kodePenempatan']),
                                    'unit_kerja_induk' => trim($res['kodeCabang']),
                                    // 'rolename' => to_upper($res['namaFungsi']),
                                    'rolename' => $res['namaFungsi'],
                                    'idrole' => trim($res['idFungsi']),
                                    'jabatan' => $res['jabatan'],
                                    'isFinger' => true
                                ]);
                            }
                        } else {
                            return false;
                        }
                    }

                    $user->syncRoles(trim($res['namaFungsi']));
                    $user->syncPermissions((\Modules\HakAkses\Entities\Role::where('id', $this->level)->first())->permissions()->pluck('name')->toArray());
                    // dd($user);

                    return true;
                    $r = User::findByUsername($credentials[$this->username()])->roles->first();

                    $this->level = $r->id; //id role
                    $this->role = $r->name; //nama role
                }

                $res = json_decode($response, true);
                $this->message = $res['message'];
                return false;
            }

            return false;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() == '404') {
                    return false;
                }
            }
        }
    }
}
