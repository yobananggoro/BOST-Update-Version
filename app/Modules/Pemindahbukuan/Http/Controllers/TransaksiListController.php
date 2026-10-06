<?php

namespace Modules\Pemindahbukuan\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Pemindahbukuan\Entities\Transactions;
use App\Entities\UnitKerja;
use App\Http\Helper\BostHelper;
use PDF;

class TransaksiListController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $data = Transactions::fetch($request);
        $branch = UnitKerja::GetAll();
        // dd($data);

        return view('pemindahbukuan::transaksi-list.default', compact('request', 'data', 'branch'));
    }

    public function show($id)
    {
        $data = Transactions::findOrFail($id);
        $additional_info = json_decode($data->additional_info, true);
        $response_message = json_decode($data->response_message, true);
        \Assets::addJs('custom/pemindahbukuan/cekstatus.js');
        // dd($response_message);
        // dd($data,$additional_info,$response_message['data']);
        // dd($data,$additional_info,$additional_info['rekening_sumber'][0]['ccySrc']);

        if (is_null($response_message)) {
            return view('pemindahbukuan::transaksi-list.detailValidate', compact('data', 'additional_info'));
        } else {
            $response_data = isset($response_message['data']) ? $response_message['data'] : $response_message;
            // dd($response_data,$response_message,strtolower($response_message['data'][0]['message']) === 'timeout backend');

            if ($data->tipe_transaksi == 1) {
                return view('pemindahbukuan::transaksi-list.detailPostingITA', compact('data', 'additional_info', 'response_data', 'response_message'));
            } else {
                return view('pemindahbukuan::transaksi-list.detailPostingAGI', compact('data', 'additional_info', 'response_data', 'response_message'));
            }
        }
    }

    public function cekStatusTransaksi(Request $request)
    {
        try {
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->cekStatusTransaksi($request);
            $json_string = $resp ? json_decode($resp, true) : null;
            // dd($resp->status(), $json_string);

            if ($resp->status() == 200) {
                if (isset($json_string['responseCode']) && (in_array($json_string['responseCode'], ['00','14','99']))) {
                    $rcStatus = $json_string['responseCode'] == '00' ? 2 : 3;
                    $isUpdated = Transactions::where('reff', $request->reff)
                        ->update([
                            'status_transaksi' => $rcStatus,
                            'response_message' => is_array($json_string) ? json_encode($json_string) : $resp
                        ]);

                    if ($isUpdated) {
                        $dbMessage = 'Database updated successfully.';
                    } else {
                        $dbMessage = 'API success, but failed to update local database.';
                    }
                }
            }

            if ($request->ajax()) {
                return response()->json([
                    "status"     => $resp->status(),
                    "data"       => $json_string,
                    "db_message" => isset($dbMessage) ? $dbMessage : 'null'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "error"  => 'Terjadi kesalahan internal sistem.'
            ], 500);
        }
    }

    // public function updtStatus(Request $request)
    // {
    //     $rcStatus = $request->rcStatus == '00' ? 2 : 3;
    //     // dd($rcStatus);
    //     $isUpdated = Transactions::where('reff', $request->numbreff)
    //         ->update(['status_transaksi' => $rcStatus, 'response_message' => $request->msgStatus]); // Data dikirim dalam bentuk array

    //     if ($isUpdated) {
    //         return redirect()->back();
    //     }
    // }
}
