<?php

namespace Modules\JenisTrx\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper\BostHelper;
use Illuminate\Support\Facades\Cache;

class JenisTrxController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {

        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/jenistrx.js');
        return view('jenistrx::default');
    }

    public function getList(Request $request)
    {
        // dd('a');
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/jenistrx.js');
        try {
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->jenisTransaksi();
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
                return view('jenistrx::default', compact('data'));
            }
        } catch (Exception $e) {
            return $e->getMessage();
            die;
        }
    }

    public function listDropdown(Request $request)
    {
        try {
            $resp = Cache::remember('dropdown_items', 3600, function () use ($request) {

                $BackEndHelper = new BostHelper();
                $response = $BackEndHelper->jenisTransaksi($request);

                $data = $response->json();

                if (!isset($data['responseCode']) || $data['responseCode'] !== '00') {
                    return false; // jangan cache error
                }

                return $data;
            });

            if ($resp === false) {

                Cache::forget($cacheKey);

                $BackEndHelper = new BostHelper();
                $response = $BackEndHelper->jenisTransaksi($request);
                $resp = $response->json();
            }

            $filtered = collect($resp['data'] ?? [])
                // ->where('isActive', true)
                ->sortBy('trxName')
                ->values()
                ->all();

            return response()->json([
                "status" => 200,
                "listTrx" => $filtered
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => 500,
                "error" => $e->getMessage()
            ]);
        }
    }

    public function reloadCore(Request $request)
    {
        // dd('a');
        try {
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->reloadJenisTransaksi();
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $status     = 'success';
                    $response   = $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                    
                } else {
                    $status     = 'warning';
                    $response   = $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                }

                return redirect('jenis-transaksi')->with($status, $response)->with('from_redirect', true);
            }
        } catch (Exception $e) {
            return $e->getMessage();
            die;
        }
    }
}
