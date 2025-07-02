<?php

namespace App\Concerns;

use Modules\User\Entities\User;
use GuzzleHttp\Exception\ClientException;

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

            $this->level = $r->id;
            $this->role = $r->name;
        }

        return $is_authenticated;
    }

    /**
     * @param array $credentials
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uim(array $credentials)
    {
        // dd($credentials);exit;
        $secretKey = config('app.https') ? config('auth.domain_hash_key') : config('auth.hash_key');
        $username = $this->username();
        $client = new \GuzzleHttp\Client();
        $encrypter = new \Illuminate\Encryption\Encrypter($secretKey, config('app.cipher'));
        // dd($client); 
        $response = $client->request('POST', config('auth.api_host'), [
            'form_params' => [
                'userId' => $credentials[$username],
                'password' => $encrypter->encrypt($credentials['password']),
                'appId' => config('app.id'),
            ],
        ]); 

        if ($response->getStatusCode() == 200) {
            $res = json_decode($response->getBody()->getContents())->response;
            // dd($res);
            $this->level = $res->idFungsi;
            $this->role = trim($res->namaFungsi);
            // $this->role = trim($res->namaFungsi);
            $user = User::findByUsername($credentials[$username]);
            // dd($res->email);exit;
            if (!is_null($user->first())) {
                $user->update(['password' => $credentials['password']]);
                $user->profile()->update([
                    'nama' => to_upper($res->nama),
                    'nip' => $res->nip,
                    'hp' => trim($res->hp),
                    'unit_kerja_kode' => trim($res->kodeCabang),
                ]);
            } else {
                if($res->idFungsi == 1302 || $res->idFungsi == 1316){
                    // dd('a');exit;
                    User::create([
                        $username => $credentials[$username],
                        'password' => $credentials['password'],
                        'email' => trim($res->email),
                        'status' => true,
                    ]);
                } else {
                    // dd('b');exit;
                    User::create([
                        $username => $credentials[$username],
                        'password' => $credentials['password'],
                        'email' => trim($res->email),
                        'status' => false,
                    ]);
                }
                
                $user = User::findByUsername($credentials[$username]);
                $user->profile()->create([
                    'nama' => to_upper($res->nama),
                    'nip' => $res->nip,
                    'hp' => trim($res->hp),
                    'unit_kerja_kode' => trim($res->kodeCabang),
                    'rolename' => to_upper($res->namaFungsi),
                    'idrole' => trim($res->idFungsi)
                ]);
            }

            $user->syncRoles($res->namaFungsi);
            // $user->syncRoles($res->menu);
            $user->syncPermissions((\Modules\HakAkses\Entities\Role::where('id', $this->level)->first())
                ->permissions()->pluck('name')->toArray());

            return true;
        }

        return false;
    }
}
