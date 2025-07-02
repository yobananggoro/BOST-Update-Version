<?php

namespace App\Http\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use App\Entities\Token;
use Modules\Otorisasi\Entities\Otorisasi;
use Modules\User\Entities\User;

class BostHelper extends Controller
{
	protected $clientId;
	protected $setToken;

	public function __construct()
	{
		$this->clientId = env('CLIENTID');
		$this->checkToken();
	}

	public function checkToken()
	{
		$getToken = Token::FindToken($this->clientId)->first();
		// dd($getToken);
		if (is_null($getToken)) {
			// dd('q');
			$this->auth();
		} else {
			$currentToken = (strtotime(Carbon::now()) - strtotime($getToken->updated_at)) * 1000;
			if ($getToken->expiredToken - $currentToken < 43200000) { // 43200000 = 12 jam dalam milidetik
				// dd('b');
				$this->auth();
				$getToken = Token::FindToken($this->clientId)->first(); // Refresh after auth
			}
		}

		$this->setToken = $getToken;
	}

	public function getToken()
    {
        return $this->setToken;
    }

	public function auth()
	{
		$clientId = env('CLIENTID');
		$clientSecret = env('CLIENTSECRET');
		$url = config('app.backend_bo') . '/auth/login';

		$message = [
			'clientId' => $clientId,
			'clientSecret' => $clientSecret
		];
		// dd($message);
		try {
			$response = Http::withHeaders(['Content-Type' => 'application/json'])->post($url, $message);
			Log::info("Get Token Request: " . json_encode($message));
			Log::info("Get Token Response: " . $response);
			// dd($response, json_decode($response, true));exit;

			if ($response->status() == 200) {
				$json_string = json_decode($response, true);

				$data = Token::FindToken($this->clientId)->first();
				if (is_null($data)) {
					DB::table('mst_token')->insert([
						'id' => Uuid::uuid4(),
						'expiredToken' => $json_string['body']['expiredInMs'],
						'accessToken' => $json_string['body']['accessToken'],
						'typeToken' => $json_string['body']['tokenType'],
						'clientId' => $clientId,
						'created_at' => Carbon::now(),
						'updated_at' => Carbon::now()
					]);
				} else {
					DB::table('mst_token')->where('clientId', $this->clientId)->update([
						'expiredToken' => $json_string['body']['expiredInMs'],
						'accessToken' => $json_string['body']['accessToken'],
						'typeToken' => $json_string['body']['tokenType'],
						'clientId' => $clientId,
						'updated_at' => Carbon::now()
					]);
				}
			}

			return $response;
		} catch (\Exception $e) {
			Log::error("Auth Error: " . $e->getMessage());
			throw $e;
		}
	}

	public function ab($request)
	{
		$tokens = $this->setToken->accessToken;
		// dd($tokens);
		$url = config('app.backend_bo') . '/accounts/balance';

		$message = array(
			'accountNumber' => $request->extAcctNumber,
			'branch' => $request->branch,
			'cif' => $request->cif,
			'suffix' => $request->suffix,
		);

		try {

			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->get($url, $message);
			Log::info("AB Request: " . json_encode($message));
			Log::info("AB Response: " . $response);
			// dd($response, json_decode($response, true), $response['responseCode']);exit;

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function gi($request)
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/accounts/general-enquiry';

		$message = array(
			'accountNumber' => $request->extAcctNumber,
			'branch' => $request->branch,
			'cif' => $request->cif,
			'suffix' => $request->suffix,
		);

		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->post($url, $message);
			Log::info("GI33 Request: " . json_encode($message));
			Log::info("GI33 Response: " . $response);
			// dd($response, json_decode($response, true));exit;

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function ListAtm($request, $branchCode, $page, $id_atm)
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/simba/list_atm';

		Log::info("Get List Atm Request: " . $url);

		$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->get($url, [
			'branchcode' => $branchCode,
			'page' => $page,
			'id_atm' => $id_atm,
		]);

		if ($response->status() == 400) {
			$this->auth();
			$this->ListAtm($request, $branchCode, $page);
		}

		Log::info("Get List Atm Response: " . $response);

		return $response;
	}

	public function ListEmail($request, $branchCode, $page)
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/simba/list_email';

		Log::info("Get List Email Request: " . $url);

		$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->get($url, ['branchcode' => $branchCode, 'page' => $page,]);

		if ($response->status() == 400) {
			$this->auth($request);
			$this->ListEmail($request, $branchCode, $page);
		}
		Log::info("Get List Email Response: " . $response);

		return $response;
	}

	public function ListEmailFilter($request, $branchCode, $page, $email)
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/simba/list_email';

		Log::info("Get List Email Request: " . $url);

		$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->get($url, ['branchcode' => $branchCode, 'page' => $page, 'email' => $email]);

		if ($response->status() == 400) {
			$this->auth($request);
			$this->ListEmail($request, $branchCode, $page);
		}
		Log::info("Get List Email Response: " . $response);

		return $response;
	}

	public function AddEmail($request, $email, $user, $branchCode)
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/simba/email';

		$data = array(
			'branchCode' => $branchCode,
			'email' => $email,
			'createdBy' => $user,
		);

		Log::info("Post Add Email Request: " . json_encode($data));

		$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->post($url, $data);
		if ($response->status() == 400) {
			$this->auth($request);
			$this->AddEmail($request, $email, $user, $branchCode);
		}
		Log::info("Post Add Email Response: " . $response);

		return $response;
	}

	public function getEmail($id)
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/simba/email/' . $id;

		Log::info("Get Email Request: " . $url);

		$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->get($url, []);
		if ($response->status() == 400) {
			$this->auth();
			$this->getEmail($id);
		}

		Log::info("Get Email Response: " . $response);

		return $response;
	}

	public function putEmail($request, $email, $user, $branchCode, $id)
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/simba/email/' . $id;

		$data = array(
			'branchCode' => $branchCode,
			'email' => $email,
			'updatedBy' => $user,
		);

		Log::info("Put Update Email Request: " . $url . " " . json_encode($data));

		$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->put($url, $data);
		if ($response->status() == 400) {
			$this->auth($request);
			$this->PutEmail($request, $email, $user, $branchCode, $id);
		}
		Log::info("Put Update Email Response: " . $response);

		return $response;
	}

	public function deleteEmail($request, $id)
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/simba/email/' . $id;

		Log::info("Delete Email Request: " . $url);

		$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->delete($url, []);
		if ($response->status() == 400) {
			$this->auth($request);
			$this->deleteEmail($request, $id);
		}
		Log::info("Delete Email Response: " . $response);

		return $response;
	}

	public function reloadIdAtm()
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/simba/reloadTermId';

		Log::info("Reload Id Atm Request: " . $url);

		$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url, []);
		if ($response->status() == 400) {
			$this->auth($request);
			$this->reloadIdAtm();
		}
		Log::info("Reload Id Atm Response: " . $response);

		return $response;
	}

	public function reportTrx($request)
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/history';

		$message = array(
			'startDate' => $request->startDate,
			'endDate' => $request->endDate,
			'userId' => $request->userid,
			'branch' => $request->branch,
		);
		// dd($message);
		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->post($url, $message);
			Log::info("Get Report Request: " . json_encode($message));
			Log::info("Get Report Response: " . $response);
			// dd($response, json_decode($response, true));exit;

			if ($response->status() == 400) {
				$this->auth($request);
				// return $this->reportTrx($request);
			}

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function otorisasiFinger($request)
	{
		// dd($request);
		$url = config('auth.host_fingerprint_uim');
		$appId = config('app.id');
		$message = array(
			'userId' => $request->usernameAuth,
			'appId' => $appId,
			'fingerprintCode' => $request->b64Finger
		);
		// dd($message);
		try {
			$response = Http::withHeaders(['Content-Type' => 'application/json'])->post($url, $message);
			unset($message['fingerprintCode']);

			Log::info("Fingerprint Otorisasi Request: " . json_encode($message));
			Log::info("Fingerprint Otorisasi Response: " . $response);
			// dd($response, json_decode($response, true));exit;

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function checkSignatureSVS($request)
	{
		// dd($request);
		try {
			$response = Http::withBasicAuth(config('auth.user_svs'), config('auth.pass_svs'))->get(config('app.url_svs').$request->cif_cust);
			// Log::info("List Signature Request: " . json_encode($message));
			Log::info("List Signature Response: " . $response);
			// dd($response, json_decode($response, true));

			return $response;
		} catch (\Exception $e) {
			Log::error("List Signature Error: " . $e->getMessage());
			throw $e;
		}
	}
}
