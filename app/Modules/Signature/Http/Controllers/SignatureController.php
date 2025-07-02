<?php

namespace Modules\Signature\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Helper\BostHelper;

class SignatureController extends \App\Http\Controllers\Controller
{
    /**
    * @param Request $request
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
    public function index(Request $request)
    {
        \Assets::addJs('custom/signature.js');
        return view('signature::view_signature');
    }
    
    public function checkImageByCIF(Request $request)
    {
        // dd($request);
        $BackEndHelper = new BostHelper();
        $resp = $BackEndHelper->checkSignatureSVS($request);
        $data = json_decode($resp, true);
        // dd($resp, json_decode($resp, true), $resp->status());exit;

        \Assets::addJs('custom/signature.js');
        return view('signature::view_signature', compact('data','request'));
    }
    
}