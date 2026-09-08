<?php

namespace Modules\Currency\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper\BostHelper;
use Illuminate\Support\Facades\Cache;

class CurrencyController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/jenistrx.js');
        return view('currency::default');
    }

    private function getCachedCurrencyData()
    {
        $cacheKey = 'bost_currency_data_clean';

        $BackEndHelper = new BostHelper();
        $resp = $BackEndHelper->getCurrency();

        if ($resp->status() == 200 && isset($resp['responseCode']) && $resp['responseCode'] == '00') {
            $json_string = json_decode($resp->body(), true);
            $data = $json_string['data'] ?? [];

            Cache::put($cacheKey, $data, 86400);

            return $data;
        }

        if (Cache::has($cacheKey)) {
            // Log atau rekam error API secara silent untuk monitoring internal
            Log::warning('API Currency bermasalah. Menggunakan data fallback dari cache.');

            return Cache::get($cacheKey);
        }

        return [];
    }

    public function getList(Request $request)
    {
        // dd('a');
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/jenistrx.js');

        try {
            // Mengambil dari fungsi cache aman
            $data = $this->getCachedCurrencyData();

            if (empty($data)) {
                return response()->json(["status" => 500, "message" => "Gagal load data."], 500);
            }

            if ($request->ajax()) {
                return response()->json([
                    "status" => 200,
                    "listTrx" => $data
                ]);
            }

            return view('currency::default', compact('data'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //Jika ingin digunakan dari luar controller panggil kesini
    public function getData()
    {
        $currencyList = $this->getCachedCurrencyData();

        return response()->json($currencyList);
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
