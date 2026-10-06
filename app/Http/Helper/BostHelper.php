<?php

namespace App\Http\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
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
		// $this->clientId = env('CLIENTID');
		$this->clientId = config('bost.client_id');
		$this->clientSecret = config('bost.client_secret');
		$this->checkToken();
	}

	// public function checkToken()
	// {
	// 	$getToken = Token::FindToken($this->clientId)->first();
	// 	// dd($getToken);
	// 	if (is_null($getToken)) {
	// 		// dd('q');
	// 		$this->auth();
	// 	} else {
	// 		$currentToken = (strtotime(Carbon::now()) - strtotime($getToken->updated_at)) * 1000;
	// 		if ($getToken->expiredToken - $currentToken < 43200000) { // 43200000 = 12 jam dalam milidetik
	// 			// dd('b');
	// 			$this->auth();
	// 			$getToken = Token::FindToken($this->clientId)->first(); // Refresh after auth
	// 		}
	// 	}

	// 	$this->setToken = $getToken;
	// }

	public function checkToken()
	{
		$lock = Cache::lock('token_refresh_lock', 10); // 10 detik

		try {
			if ($lock->get()) { // hanya 1 process yang boleh masuk block ini
				$getToken = Token::FindToken($this->clientId)->first();

				if (is_null($getToken)) {
					$this->auth();
				} else {
					$currentToken = (strtotime(Carbon::now()) - strtotime($getToken->updated_at)) * 1000;
					if ($getToken->expiredToken - $currentToken < 43200000) {
						$this->auth();
					}
				}

				$getToken = Token::FindToken($this->clientId)->first();
			} else {
				// process lain sedang refresh token
				// tunggu token selesai di-refresh
				usleep(300000); // 0.3 detik
				$getToken = Token::FindToken($this->clientId)->first();
			}
		} finally {
			optional($lock)->release();
		}

		$this->setToken = $getToken;
	}

	public function getToken()
	{
		return $this->setToken;
	}

	public function auth()
	{
		// $clientId = env('CLIENTID');
		// $clientSecret = env('CLIENTSECRET');
		$clientId = $this->clientId;
		$clientSecret = $this->clientSecret;
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
				// $json_string = json_decode($response, true);
				$json_string = $response->json();

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
		$account = $request->branch . $request->cif . $request->suffix;
		// dd($request,$account);
		try {
			$response = Http::withBasicAuth(config('auth.user_svs'), config('auth.pass_svs'))->get(config('app.url_svs') . $account);
			// Log::info("List Signature Request: " . json_encode($message));
			Log::info("List Signature Response: " . $response);
			// dd($response, json_decode($response, true));

			return $response;
		} catch (\Exception $e) {
			Log::error("List Signature Error: " . $e->getMessage());
			throw $e;
		}
	}

	public function jenisTransaksi()
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/trx-codes';

		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
			// dd($response, json_decode($response, true));

			if ($response->status() == 200) {
				$respMsg = json_decode($response, true);
				Log::info("List Jenis Transaksi: " . json_encode(array_diff_key($respMsg, ['data' => ''])));
			} else {
				Log::info("List Jenis Transaksi: " . $response);
			}

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function reloadJenisTransaksi()
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/trx-codes/reload';

		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
			// dd($response, json_decode($response, true));

			if ($response->status() == 200) {
				$respMsg = json_decode($response, true);
				Log::info("Reload Core Jenis Transaksi: " . json_encode(array_diff_key($respMsg, ['data' => ''])));
			} else {
				Log::info("Reload Core Jenis Transaksi: " . $response);
			}

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function flagingJenisTransaksi($request)
	{
		$tokens = $this->setToken->accessToken;
		$idJenis = (int) $request->id;

		if ($request->flag === 'on') {
			$url = config('app.backend_bo') . '/transactions/trx-codes/'.$idJenis.'/status?active=true';
		} else {
			$url = config('app.backend_bo') . '/transactions/trx-codes/'.$idJenis.'/status?active=false';
		}

		try {
			$response = Http::withHeaders(['X-User-Id' => auth()->user()->username, 'Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->patch($url);
			// dd($response, json_decode($response, true));

			if ($response->status() == 200) {
				Log::info("Flaging Jenis Transaksi: " . $response);
			} else {
				Log::info("Flaging Jenis Transaksi: " . $response);
			}

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function getCurrency()
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/ccy-codes';

		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
			// dd($response, json_decode($response, true));

			if ($response->status() == 200) {
				$respMsg = json_decode($response, true);
				Log::info("List Currency: " . json_encode(array_diff_key($respMsg, ['data' => ''])));
			} else {
				Log::info("List Currency: " . $response);
			}

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function getCurrencyRates($request)
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/get-rates/' . $request->ccy;
		$message = array(
			'currency' => $request->ccy
		);

		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
			// dd($response, json_decode($response, true));
			Log::info("Currency Rates Request: " . json_encode($message));
			Log::info("Currency Rates Response: " . $response);

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function reloadCurrency()
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/ccy-codes/reload';

		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
			// dd($response, json_decode($response, true));

			if ($response->status() == 200) {
				$respMsg = json_decode($response, true);
				Log::info("Reload Core Currency: " . json_encode(array_diff_key($respMsg, ['data' => ''])));
			} else {
				Log::info("Reload Core Currency: " . $response);
			}

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function kodefikasiList($request)
	{
		// dd($request);
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/codification/' . $request->groupCode;

		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
			// dd(json_decode($response, true));
			Log::info("List Kodefikasi Request: " . $request->groupCode);

			if ($response->status() == 200) {
				$respMsg = json_decode($response, true);
				Log::info("List Kodefikasi Response: " . json_encode(array_diff_key($respMsg, ['data' => ''])));
			} else {
				Log::info("List Kodefikasi Response: " . $response);
			}

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function userKode()
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/get-user-code';

		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
			// dd($response, json_decode($response, true));

			if ($response->status() == 200) {
				$respMsg = json_decode($response, true);
				Log::info("List User Kode: " . json_encode(array_diff_key($respMsg, ['data' => ''])));
			} else {
				Log::info("List User Kode: " . $response);
			}

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function kodefikasiStore($request)
	{
		// dd($request);
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/codification';
		$message = array(
			'groupCode' => $request->groupCode,
			'keyCode' => $request->keyCode,
			'value' => $request->values,
			'description' => $request->description,
			'isActive' => $request->isActive == 1 ? true : false,
			'createdBy' => auth()->user()->username
		);
		// dd($message);
		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->post($url, $message);
			// dd($response, json_decode($response, true));
			Log::info("Kodefikasi Store Request: " . json_encode($message));
			Log::info("Kodefikasi Store Response: " . $response);

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function kodefikasiEdit($request)
	{
		// dd($request);
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/codification/' . $request->groupCode . '/' . $request->keyCode;
		$message = array(
			'value' => $request->values,
			'description' => $request->description,
			'isActive' => $request->isActive == 1 ? true : false,
			'updatedBy' => auth()->user()->username
		);
		// dd($message);
		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->put($url, $message);
			// dd($response, json_decode($response, true));
			Log::info("Kodefikasi Edit Request: " . json_encode($message));
			Log::info("Kodefikasi Edit Response: " . $response);

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function kodefikasiDelete($request)
	{
		// dd($request);
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/codification/' . $request->groupCode . '/' . $request->keyCode;

		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->delete($url);
			// dd($response, json_decode($response, true));
			Log::info("Kodefikasi Delete Request: " . $request->groupCode . "|" . $request->keyCode);
			Log::info("Kodefikasi Delete Response: " . $response);

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function reloadUserKode()
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/get-user-code/reload';

		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
			// dd($response, json_decode($response, true));

			if ($response->status() == 200) {
				$respMsg = json_decode($response, true);
				Log::info("Reload Core User Kode: " . json_encode(array_diff_key($respMsg, ['data' => ''])));
			} else {
				Log::info("Reload Core User Kode: " . $response);
			}

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function rekeningCostcenter()
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/get-cc-acc';

		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
			// dd($response, json_decode($response, true));

			if ($response->status() == 200) {
				$respMsg = json_decode($response, true);
				Log::info("Rekening CostCenter: " . json_encode(array_diff_key($respMsg, ['data' => ''])));
			} else {
				Log::info("Rekening CostCenter: " . $response);
			}

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function reloadRekeningCostcenter()
	{
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/get-cc-acc/reload';

		try {
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
			// dd($response, json_decode($response, true));

			if ($response->status() == 200) {
				$respMsg = json_decode($response, true);
				Log::info("Reload Core Rekening Costcenter: " . json_encode(array_diff_key($respMsg, ['data' => ''])));
			} else {
				Log::info("Reload Core Rekening Costcente: " . $response);
			}

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	public function cekStatusTransaksi($request)
	{
		// dd($request);
		$tokens = $this->setToken->accessToken;
		$url = config('app.backend_bo') . '/transactions/check-status/' . $request->reff;

		try {
			Log::info("Cek Status Request: " . $request->reff);
			$response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
			Log::info("Cek Status Response: " . $response);
			// dd(json_decode($response, true));

			return $response;
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}
}
