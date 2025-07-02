<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Entities\Token;
use App\Http\Helper\BostHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GIController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $accuse = 'internal';
        \Assets::addJs('custom/account.js');
        
        return view('account::gi33.default', compact('accuse'));
    }
    
    public function store(Request $request)
    {
        // \Assets::addJs('custom/account.js');
        $ZLEAN = $request->extAcctNumber;
        $ZLAB  = $request->branch;
        $ZLAN  = $request->cif;
        $ZLAS  = $request->suffix;
        if ($ZLEAN != null or ($ZLAB != null and $ZLAN != null and $ZLAS != null)) {
            $accuse = is_null($request->extAcctNumber) ? 'internal' : 'external';
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->gi($request);
            
            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $json_string            = json_decode($resp, true);
                    $status                 = $resp->status();
                    $code                   = $json_string['responseCode'];
                    $branch                 = $json_string['data'][0]['branch'];
                    $cif                    = $json_string['data'][0]['cif'];
                    $suffix                 = $json_string['data'][0]['suffix'];
                    $accountShortName       = $json_string['data'][0]['accountShortName'];
                    $accountType            = $json_string['data'][0]['accountType'];
                    $externalAccountNumber  = $json_string['data'][0]['accountNumberExt'];
                    $accountNumber          = $json_string['data'][0]['accountNumber'];
                    $currency               = $json_string['data'][0]['currency'];
                    
                    if ($request->ajax())
                    return response()->json([
                        'status'                => $status, 
                        'code'                  => $code, 
                        'branch'                => $branch, 
                        'cif'                   => $cif, 
                        'suffix'                => $suffix, 
                        'accountShortName'      => $accountShortName, 
                        'accountType'           => $accountType, 
                        'currency'              => $currency, 
                        'externalAccountNumber' => $externalAccountNumber
                    ]);
                    
                    // return view('account::gi33.default', compact('accountShortName', 'accountType', 'externalAccountNumber', 'accountNumber', 'currency', 'accuse'));
                    
                } else {
                    $json_string    = json_decode($resp, true);

                    $status         = $resp->status();
                    $code           = $json_string['responseCode'];
                    $desc           = $json_string['responseDesc'];
                    $msgdesc        = isset($json_string['data'][0]['messageDesc']) ?  $json_string['data'][0]['messageDesc'] : $json_string['data'][0]['message'];
                    $msgid          = isset($json_string['data'][0]['messageId']) ? $json_string['data'][0]['messageId'] : "";
                    $response       = 'Data tidak ditemukan!<br>' . $msgdesc . ' | '.$code;
                    
                    if ($request->ajax())
                    return response()->json(['status' => $status, 'code' => $code, 'desc' => $desc, 'msgdesc' => 'Data tidak ditemukan!<br>'.$msgdesc, 'msgid' => $msgid]);
                    
                    // return redirect('account-gi')->with($status, $response);
                }
            } else if ($resp->status() == 400) {
                if($resp['responseCode'] == 401){
                    $status     = 'error';
                    $response   = 'Terjadi gangguan sistem!<br>' . $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                } else {
                    $status     = 'error';
                    $response   = 'Terjadi gangguan sistem!<br>' . $resp->status() . ' | ' . $resp->getReasonPhrase();
                }

                if ($request->ajax()){
                    return response()->json(['message' => $response, 'status' => $resp['responseCode']]);
                }
                
                // return redirect('account-balance')->with($status, $response);
                
            } else {
                $status     = 'error';
                $response   = $resp->status().' | '.$resp->getReasonPhrase();
                
                if ($request->ajax())
                return response()->json(['message' => 'Terjadi gangguan sistem!<br>'.$response, 'status' => $resp->status()]);
                
                // return redirect('account-gi')->with($status, $response);
            }
            
        } else {
            $status     = 'error';
            $response   = 'External Account atau Internal Account Tidak Boleh Kosong';
            
            if ($request->ajax())
            return response()->json(['message' => $response, 'status' => $status]);
            
            // return redirect('account-gi')->with($status, $response);
        }
    }
}
