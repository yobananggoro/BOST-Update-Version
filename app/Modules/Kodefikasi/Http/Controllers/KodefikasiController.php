<?php

namespace Modules\Kodefikasi\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper\BostHelper;
use Illuminate\Support\Facades\Cache;

class KodefikasiController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/kodefikasi.js');
        return view('kodefikasi::default');
    }

    public function getList(Request $request)
    {
        // dd($request);
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/kodefikasi.js');
        try {
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->kodefikasiList($request);
            // dd(json_decode($resp, true));

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
                return view('kodefikasi::default', compact('data', 'request'));
            } else {
                $status     = 'error';
                $response   = $resp->status() . ' | ' . $resp->getReasonPhrase();
            }

            return redirect('kodefikasi')->with($status, $response)->with('from_redirect', true);
        } catch (Exception $e) {
            return $e->getMessage();
            die;
        }
    }

    public function listDropdown(Request $request)
    {
        try {
            $cacheKey = 'dropdown_items_' . $request->groupCode;
            $resp = Cache::remember($cacheKey, 3600, function () use ($request) {

                $BackEndHelper = new BostHelper();
                $response = $BackEndHelper->kodefikasiList($request);

                $data = $response->json();

                if (!isset($data['responseCode']) || $data['responseCode'] !== '00') {
                    return false; // jangan cache error
                }

                return $data;
            });

            if ($resp === false) {

                Cache::forget($cacheKey);

                $BackEndHelper = new BostHelper();
                $response = $BackEndHelper->kodefikasiList($request);
                $resp = $response->json();
            }

            $filtered = collect($resp['data'] ?? [])
                ->where('isActive', true)
                ->sortBy('keyCode')
                ->values()
                ->all();

            return response()->json([
                "status" => 200,
                "data" => $filtered
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => 500,
                "error" => $e->getMessage()
            ]);
        }
    }

    public function create()
    {
        return view('kodefikasi::form');
    }

    public function store(Request $request)
    {
        // dd($request);
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/kodefikasi.js');
        try {
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->kodefikasiStore($request);
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 201) {
                if ($resp['responseCode'] == '00') {
                    $json_string    = json_decode($resp, true);
                    $data           = $json_string['data'];
                }
                $status     = 'success';
                $response   = $resp->status() . ' | ' . $resp['responseDesc'];

                // return redirect('kodefikasi')->with($status, $response)->with('from_redirect', true);
            } else {
                $status     = 'error';
                $response   = $resp->status() . ' | ' . $resp->getReasonPhrase();
            }

            return redirect('kodefikasi')->with($status, $response)->with('from_redirect', true);
        } catch (Exception $e) {
            return $e->getMessage();
            die;
        }
    }

    public function listDetail(Request $request)
    {
        // dd($request);
        return view('kodefikasi::edit', compact('request'));
    }

    public function update(Request $request)
    {
        // dd($request);
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/kodefikasi.js');
        try {
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->kodefikasiEdit($request);
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $json_string    = json_decode($resp, true);
                    $data           = $json_string['data'];
                }
                $status     = 'success';
                $response   = $resp->status() . ' | ' . $resp['responseDesc'];

                // return redirect('kodefikasi')->with($status, $response)->with('from_redirect', true);
            } else {
                $status     = 'error';
                $response   = $resp->status() . ' | ' . $resp->getReasonPhrase();
            }

            return redirect('kodefikasi')->with($status, $response)->with('from_redirect', true);
        } catch (Exception $e) {
            return $e->getMessage();
            die;
        }
    }

    public function destroy(Request $request)
    {
        // dd($request);
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/kodefikasi.js');
        try {
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->kodefikasiDelete($request);
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $status     = 'success';
                    $response   = $resp->status() . ' | ' . $resp['responseDesc'];
                }
            } else {
                $status     = 'error';
                $response   = $resp->status() . ' | ' . $resp->getReasonPhrase();
            }

            return redirect('kodefikasi')->with($status, $response)->with('from_redirect', true);
        } catch (Exception $e) {
            return $e->getMessage();
            die;
        }
    }
}
