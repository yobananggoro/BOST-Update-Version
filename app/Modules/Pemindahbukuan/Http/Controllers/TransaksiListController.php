<?php

namespace Modules\Pemindahbukuan\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Pemindahbukuan\Entities\Transactions;
use App\Entities\UnitKerja;
use PDF;

class TransaksiListController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $data = Transactions::fetch($request);  
        $branch = UnitKerja::GetAll();
        // dd($data);
        
        return view('pemindahbukuan::transaksi-list.default', compact('request','data','branch')); 
    }

    public function show($id)
    {
        $data = Transactions::findOrFail($id);
        $additional_info = json_decode($data->additional_info, true);
        $response_message = json_decode($data->response_message, true);
        // dd($data,$additional_info,$response_message['data']);
        // dd($data,$additional_info,$additional_info['rekening_sumber'][0]['ccySrc']);

        if(is_null($response_message)){
            return view('pemindahbukuan::transaksi-list.detailValidate', compact('data', 'additional_info'));
        } else {
            $response_data = $response_message['data'];
            // dd($response_data,$response_message);

            if($data->tipe_transaksi == 1){
                return view('pemindahbukuan::transaksi-list.detailPostingITA', compact('data', 'additional_info', 'response_data', 'response_message'));
            } else {
                return view('pemindahbukuan::transaksi-list.detailPostingAGI', compact('data', 'additional_info', 'response_data', 'response_message'));
            }
        }
    }
}
