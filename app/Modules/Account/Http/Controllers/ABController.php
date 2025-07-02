<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Account\Entities\Rekening;
use Modules\Account\Http\Requests\ABRequest;
use App\Entities\Token;
use App\Http\Helper\BostHelper;
use App\Concerns\TapActivity;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ABController extends \App\Http\Controllers\Controller
{
    
    /**
    * @param Request $request
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
    public function index(Request $request)
    {
        $accuse = 'external';
        
        \Assets::addJs('custom/account/ab.js');
        return view('account::ab.default', compact('accuse'));
    }
    
    public function store(Request $request) 
    {
        // dd($request);
        \Assets::addJs('custom/account/ab.js');
        
        $zlean = $request->extAcctNumber;
        $zlab  = $request->branch;
        $zlan  = $request->cif;
        $zlas  = $request->suffix;
        
        if ($zlean != null || ($zlab != null and $zlan != null and $zlas != null)) {
            $accuse = is_null($request->extAcctNumber) ? 'internal' : 'external';
            
            try{ //Penjagaan apabila masuk ke halaman error
                $BackEndHelper = new BostHelper();
                $resp = $BackEndHelper->ab($request);
                
                if ($resp->status() == 200) {
                    if ($resp['responseCode'] == '00') {
                        $json_string        = json_decode($resp, true);
                        $custFullName       = @$json_string['data']['custFullName'];
                        $custShortName      = @$json_string['data']['custShortName'];
                        $acctTypeDesc       = @$json_string['data']['acctTypeDesc'];
                        $acctType           = @$json_string['data']['acctType'];
                        $currency           = @$json_string['data']['currency'];
                        $extAcctNumber      = @$request->extAcctNumber;
                        $branch             = @$json_string['data']['branch'];
                        $cif                = @$json_string['data']['cif'];
                        $suffix             = @$json_string['data']['suffix'];
                        $balance            = @$json_string['data']['balance'];
                        $availableBalance   = @$json_string['data']['availableBalance'];
                        $ledgerBalance      = @$json_string['data']['ledgerBalance'];
                        $shadowDebits       = @$json_string['data']['shadowDebits'];
                        $shadowCredits      = @$json_string['data']['shadowCredits'];
                        $statusBalance      = @$json_string['data']['statusBalance'];
                        $acctNumber         = null;
                        
                        if (isset($json_string['data']['acctNumber']) == true) {
                            $acctNumber     = @$json_string['data']['acctNumber'];
                        } else {
                            $acctNumber     = $request->branch . '-' . $request->cif . '-' . $request->suffix;
                        }
                        
                        if ($request->ajax()){
                            return response()->json([
                                'norek'     => $acctNumber, 
                                'nama'      => $custFullName, 
                                'tipe_rek'  => $acctType, 
                                'tipe_ccy'  => $currency, 
                                'cif'       => $cif, 
                                'branch'    => $branch, 
                                'suffix'    => $suffix
                            ]);
                        }
                        //dd($extAcctNumber, $branch, $cif, $suffix);
                        return view('account::ab.default', compact('custFullName', 'custShortName', 'acctTypeDesc', 'acctType', 'currency', 'acctNumber', 'extAcctNumber', 'branch', 'cif', 'suffix', 'balance', 'ledgerBalance', 'availableBalance', 'shadowDebits', 'shadowCredits', 'statusBalance', 'accuse'));
                        
                    } else {
                        $resp       = json_decode($resp, true);
                        $code       = $resp['responseCode'];
                        $desc       = isset($resp['data'][0]['messageDesc']) ? $resp['data'][0]['messageDesc'] : $resp['data'][0]['message'];
                        $status     = 'error';
                        $response   = 'Data tidak ditemukan!<br>' . $desc . ' | '. $code;
                        
                        if ($request->ajax()){
                            return response()->json(['message' => 'Data tidak ditemukan!<br>' . $response, 'status' => $status]);
                        }
                        
                        return redirect('account-balance')->with($status, $response);
                    }
                    
                } else if ($resp->status() == 400) {
                    if($resp['responseCode'] == 401){
                        $status     = 'error';
                        $response   = 'Terjadi gangguan sistem!<br>' . $resp['responseCode'] .' | '. $resp['responseDesc'];
                    } else {
                        $status     = 'error';
                        $response   = 'Terjadi gangguan sistem!<br>' . $resp->status() .' | '. $resp->getReasonPhrase();
                    }
                    
                    if ($request->ajax()){
                        return response()->json(['message' => 'Terjadi gangguan sistem!<br>' . $response, 'status' => $resp['responseCode']]);
                    }
                    
                    return redirect('account-balance')->with($status, $response);
                    
                } else {
                    $status     = 'error';
                    $response   = 'Terjadi gangguan sistem!<br>' . $resp->status().' | '.$resp->getReasonPhrase();
                    
                    if ($request->ajax())
                    return response()->json(['message' => 'Terjadi gangguan sistem!<br>' . $response, 'status' => $status]);
                    
                    return redirect('account-balance')->with($status, $response);
                }
            } catch(\Exception $e){
                // dd($e->getMessage());
                return redirect()->back()->with('error', $e->getMessage());
            }
            
        } else {
            $status     = 'error';
            $response   = 'External Account atau Internal Account Tidak Boleh Kosong';
            
            if ($request->ajax())
            return response()->json(['message' => $response, 'status' => $status]);
            
            return redirect('account-balance')->with($status, $response);
        }
    }
}
