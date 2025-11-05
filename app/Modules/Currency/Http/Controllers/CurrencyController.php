<?php

namespace Modules\Currency\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper\BostHelper;

class CurrencyController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/jenistrx.js');
        return view('currency::default');
    }

    public function getList(Request $request)
    {
        // dd('a');
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/jenistrx.js');
        try {
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->getCurrency();
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
                return view('currency::default', compact('data'));
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
            $resp = $BackEndHelper->reloadCurrency();
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $status     = 'success';
                    $response   = $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                } else {
                    $status     = 'warning';
                    $response   = $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                }

                return redirect('list-currency')->with($status, $response)->with('from_redirect', true);
            }
        } catch (Exception $e) {
            return $e->getMessage();
            die;
        }
    }

    public function getRates(Request $request)
    {
        // var_dump($request->all());
        try {
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->getCurrencyRates($request);
            // var_dump(json_decode($resp, true));

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $json_string    = json_decode($resp, true);
                    $status         = $resp->status();
                    $data           = $json_string['data'];
                }

                if ($request->ajax()) {
                    return response()->json([
                        "status" => $status,
                        "rates" => $data
                    ]);
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
            die;
        }
    }
}
