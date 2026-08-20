<?php

namespace Modules\Rekening\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Entities\Token;
use App\Http\Helper\BostHelper;
use Modules\Rekening\Entities\Rekening;
use Modules\Rekening\Entities\Currency;
use Modules\Rekening\Http\Requests\RekeningRequest;


class CostcenterController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/rekening/rekening.js');
        return view('rekening::costcenter');
    }

    public function getList(Request $request)
    {
        // dd('a');
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/rekening/rekening.js');
        try {
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->rekeningCostcenter();
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
                return view('rekening::costcenter', compact('data'));
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
            $resp = $BackEndHelper->reloadRekeningCostcenter();
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $status     = 'success';
                    $response   = $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                    
                } else {
                    $status     = 'warning';
                    $response   = $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                }

                return redirect('rekening-costcenter')->with($status, $response)->with('from_redirect', true);
            }
        } catch (Exception $e) {
            return $e->getMessage();
            die;
        }
    }
}
