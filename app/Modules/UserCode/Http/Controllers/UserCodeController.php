<?php

namespace Modules\UserCode\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper\BostHelper;

class UserCodeController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {

        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/usercode.js');
        return view('usercode::default');
    }

    public function getList(Request $request)
    {
        // dd('a');
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/usercode.js');
        try {
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->userKode();
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $json_string    = json_decode($resp, true);
                    $status         = $resp->status();
                    $data           = $json_string['data'];
                }

                if ($request->ajax()) {
                    return response()->json([
                        "status" => $status,
                        "listTrx" => $data
                    ]);
                }
                // dd($data);
                return view('usercode::default', compact('data'));
            }
        } catch (Exception $e) {
            return $e->getMessage();
            die;
        }
    }

    public function reloadCore(Request $request)
    {
        // dd('a');
        try {
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->reloadUserKode();
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $status     = 'success';
                    $response   = $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                    
                } else {
                    $status     = 'warning';
                    $response   = $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                }

                return redirect('user-code')->with($status, $response)->with('from_redirect', true);
            }
        } catch (Exception $e) {
            return $e->getMessage();
            die;
        }
    }
}
