<?php

namespace App\Concerns;

use Modules\User\Entities\User;
use Modules\User\Entities\Role;
use GuzzleHttp\Exception\ClientException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
    public function uimNG(array $credentials, $request)
    {
        // dd($credentials);exit;
        $secretKey = config('app.https') ? config('auth.domain_hash_key') : config('auth.hash_key');
        $username = $this->username();
        // $client = new \GuzzleHttp\Client();
        $encrypter = new \Illuminate\Encryption\Encrypter($secretKey, config('app.cipher'));
        $url = config('auth.api_host');
        $role = Role::pluck('name')->all();
        $message = [
            'userId'        => $credentials[$username],
            'password'      => $encrypter->encrypt($credentials['password']),
            'appId'         => config('app.id'),
            'isEncrypted'   => true
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
                            // if (in_array($res['namaFungsi'], ['SUPER ADMIN', 'SPV', 'MO', 'PINCAB'])) {
                            if (!in_array($res['namaFungsi'], ['Administrasi Dana Dan Jasa', 'Administrasi Kredit', 'Administrasi Operasional'])) {
                                User::create([
                                    $username => $credentials[$username],
                                    'password' => $credentials['password'],
                                    'email' => trim($res['email']),
                                    'status' => 1,
                                    'isLogin' => false
                                ]);
                            } else {
                                User::create([
                                    $username => $credentials[$username],
                                    'password' => $credentials['password'],
                                    'email' => trim($res['email']),
                                    'status' => 0,
                                    'isLogin' => false
                                ]);
                            }

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
                        } else {
                            return false;
                        }
                    }

                    $user->syncRoles(trim($res['namaFungsi']));
                    $user->syncPermissions((\Modules\HakAkses\Entities\Role::where('id', $this->level)->first())
                        ->permissions()->pluck('name')->toArray());

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

    // public function uimNG(array $credentials, $request)
    // {
    //     $secretKey = config('app.https') ? config('auth.domain_hash_key') : config('auth.hash_key');
    //     $username = $this->username();
    //     $encrypter = new \Illuminate\Encryption\Encrypter($secretKey, config('app.cipher'));
    //     $url = config('auth.api_host');
    //     $roleList = Role::pluck('name')->all();

    //     $message = [
    //         'userId'      => $credentials[$username],
    //         'password'    => $encrypter->encrypt($credentials['password']),
    //         'appId'       => config('app.id'),
    //         'isEncrypted' => true
    //     ];

    //     try {
    //         $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($url, $message);
    //         unset($message['password']);
    //         Log::info("Auth UIM Request: " . json_encode($message));
    //         Log::info("Auth UIM Response: " . $response->body());

    //         if ($response->ok()) {
    //             $body = $response->json();
    //             if (($body['statusCode'] ?? null) == 200 && isset($body['data'])) {
    //                 $res = $body['data'];
    //                 $user = User::findByUsername($credentials[$username]);
    //                 $userExists = !is_null($user->first());

    //                 if ($userExists) {
    //                     $now = now();
    //                     $idle = $now->diffInMinutes($user->last_activity);
    //                     if ($user->isLogin && $user->profile->rolename != 'SUPER ADMIN' && $idle <= config('session.lifetime')) {
    //                         $this->sendMultipleLoggedInNotAllowedResponse($request);
    //                         return false;
    //                     }
    //                 }

    //                 $this->level = $res['idFungsi'];
    //                 $this->role = trim($res['namaFungsi']);

    //                 $profileData = [
    //                     'nama'            => to_upper($res['nama']),
    //                     'nip'             => $res['nip'],
    //                     'hp'              => null,
    //                     'unit_kerja_kode' => trim($res['kodeCabang']),
    //                     'rolename'        => $res['namaFungsi'],
    //                     'idrole'          => trim($res['idFungsi']),
    //                     'jabatan'         => $res['jabatan'],
    //                 ];

    //                 if ($userExists) {
    //                     $user->update(['password' => $credentials['password']]);
    //                     $user->profile()->update($profileData);
    //                 } else {
    //                     if (in_array(trim($res['namaFungsi']), $roleList)) {
    //                         if (!in_array($res['namaFungsi'], ['Administrasi Dana Dan Jasa', 'Administrasi Kredit', 'Administrasi Operasional'])) {
    //                             $user = User::create([
    //                                 $username => $credentials[$username],
    //                                 'password' => $credentials['password'],
    //                                 'email'    => trim($res['email']),
    //                                 'status'   => 1,
    //                                 'isLogin'  => false
    //                             ]);
    //                             $user->profile()->create(array_merge($profileData, ['isFinger' => true]));
    //                         } else {
    //                             $user = User::create([
    //                                 $username => $credentials[$username],
    //                                 'password' => $credentials['password'],
    //                                 'email'    => trim($res['email']),
    //                                 'status'   => 0,
    //                                 'isLogin'  => false
    //                             ]);
    //                             $user->profile()->create(array_merge($profileData, ['isFinger' => false]));
    //                         }
    //                     } else {
    //                         return false;
    //                     }
    //                 }

    //                 $user->syncRoles(trim($res['namaFungsi']));
    //                 $user->syncPermissions(
    //                     (\Modules\HakAkses\Entities\Role::where('id', $this->level)->first())
    //                         ->permissions()->pluck('name')->toArray()
    //                 );

    //                 return true;
    //             }
    //         }
    //         return false;
    //     } catch (\GuzzleHttp\Exception\ClientException $e) {
    //         Log::error("UIMNG ClientException: " . $e->getMessage());
    //         if ($e->hasResponse() && $e->getResponse()->getStatusCode() == 404) {
    //             return false;
    //         }
    //         throw $e;
    //     } catch (\Exception $e) {
    //         Log::error("UIMNG Exception: " . $e->getMessage());
    //         return false;
    //     }
    // }
}
