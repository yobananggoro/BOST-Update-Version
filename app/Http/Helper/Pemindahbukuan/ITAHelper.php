<?php

namespace App\Http\Helper\Pemindahbukuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use App\Entities\Token;
use App\Http\Helper\BostHelper;

class ITAHelper extends Controller
{
    protected $clientId;
    protected $setToken;

    public function __construct()
    {
        $this->clientId = env('CLIENTID');
        $BostHelper = new BostHelper();
        $getToken = $BostHelper->getToken();

        $this->setToken = $getToken;
    }

    public function itaval($request)
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/transactions/transfer-interbank';
        
        $message = array(
            'branchSrc'             => $request->branchSrc,
            'cifSrc'                => $request->cifSrc,
            'suffixSrc'             => $request->suffixSrc,
            'sourceAccount'         => $request->extSrc,
            'branchDst'             => $request->branchDst,
            'cifDst'                => $request->cifDst,
            'suffixDst'             => $request->suffixDst,
            'destinationAccount'    => $request->extDst,
            'isSourceExternal'      => $request->accuseSrc == 'external' ? "Y":"N",
            'isDestinationExternal' => $request->accuseDst == 'external' ? "Y":"N",
            'isValidate'            => "Y",
            'ref'                   => $request->reff,
            'userId'                => auth()->user()->username,
            'branchUser'            => auth()->user()->profile->unit_kerja_kode,
            'amount'                => $request->nominal,
            // 'narrative1'            => $request->narative1,
            // 'narrative2'            => $request->narative2,
            'narrative3'            => $request->narative3,
            'narrative4'            => $request->narative4
        );
        // dd($message);
        try{
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->post($url, $message);
            Log::info("ITA Validation Request: " . json_encode($message));
            Log::info("ITA Validation Response: " . $response);

            // if ($response->status() == 500) {
            //     Log::info("ITA Validation Response: " . $response->getStatusCode() . "|" . auth()->user()->username . "|" . $response->getReasonPhrase());
            // } else {
            //     Log::info("ITA Validation Response: " . $response);
            // }

            return $response;
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
    
    public function itapost($request)
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/transactions/transfer-interbank';
        
        $message = array(
            'branchSrc'             => $request->branchSrc,
            'cifSrc'                => $request->cifSrc,
            'suffixSrc'             => $request->suffixSrc,
            'sourceAccount'         => $request->extSrc,
            'branchDst'             => $request->branchDst,
            'cifDst'                => $request->cifDst,
            'suffixDst'             => $request->suffixDst,
            'destinationAccount'    => $request->extDst,
            'isSourceExternal'      => $request->accuseSrc == 'external' ? "Y":"N",
            'isDestinationExternal' => $request->accuseDst == 'external' ? "Y":"N",
            'ref'                   => $request->reff,
            'userId'                => $request->userid,
            'headUser'              => auth()->user()->username,
            'branchUser'            => auth()->user()->profile->unit_kerja_kode,
            'amount'                => $request->nominal,
            // 'narrative1'            => $request->narative1,
            // 'narrative2'            => $request->narative2,
            'narrative3'            => $request->narative3,
            'narrative4'            => $request->narative4,
            'isValidate'            => "N"
        );
        
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->post($url, $message);
            // dd($response, json_decode($response->getBody()->getContents(), true), json_decode($response, true)['error']);
            Log::info("ITA Posting Request: " . json_encode($message));
            Log::info("ITA Posting Response: ".$response->status()."|". $response);

            return $response;
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}
