<?php

namespace Modules\Fingerstatus\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Helper\BostHelper;

class FingerstatusController extends \App\Http\Controllers\Controller
{
    /**
    * @param Request $request
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
    public function index(Request $request)
    {
        return view('fingerstatus::default');
    }
    
    public function checkFinger(Request $request)
    {
        // dd($request);
        $BackEndHelper = new BostHelper();
        $resp = $BackEndHelper->otorisasiFinger($request);
        
        // dd($resp, json_decode($resp, true), $resp->status());exit;
        if ($resp->status() == 200) {
            $json_string    = json_decode($resp, true);
            
            if($json_string['statusCode'] == 200){
                $code   = $json_string['statusCode'];
                $desc   = 'Fingerprint Berhasil';
                
                if ($request->ajax())
                return response()->json(['code' => $code, 'desc' => $desc]);
            } else {
                $code   = $json_string['statusCode'];
                $desc   = $json_string['errorCode'];
                
                if ($request->ajax())
                return response()->json(['code' => $code, 'desc' => $desc]);
            }
        } else {
            $code   = $resp->status();
            $desc   = 'Sedang Terjadi Gangguan!';
            
            if ($request->ajax())
            return response()->json(['code' => $code, 'desc' => $desc]);
        }
    }
    
}