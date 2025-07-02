<?php

namespace Modules\Pemindahbukuan\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper\BostHelper;
use Modules\User\Entities\User;
use App\Entities\UnitKerja;
use Carbon\Carbon;
use PDF;
use DOMDocument;

class ReporTransaksiController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        \Assets::addJs('custom/pemindahbukuan/report.js');
        $data = "";
        $data_list = "";
        $branch = UnitKerja::GetAll();
        
        return view('pemindahbukuan::report-transaksi.default', compact('data','data_list','branch','request'));
    }
    
    public function getReport(Request $request) 
    {
        \Assets::addJs('custom/pemindahbukuan/report.js');
        try{
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->reportTrx($request);
            $branch = UnitKerja::GetAll();
            
            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $data = json_decode($resp, true)['data'];
                    // dd($data);

                    return view('pemindahbukuan::report-transaksi.default', compact('data','request','branch'));
                } else {
                    $json_string    = json_decode($resp, true);
                    $code           = $json_string['responseCode'];
                    $desc           = $json_string['responseDesc'];
                    $status         = 'error';
                    $response       = $code.' | '.$desc;
                    
                    return redirect('report-transaksi')->with($status, $response);
                }
            } else {
                $json_string    = json_decode($resp, true);
                $status         = $resp->status();
                $code           = $json_string['responseCode'];
                $desc           = $json_string['responseDesc'];
                $msgdesc        = isset($json_string['data'][0]['messageDesc']) ?  $json_string['data'][0]['messageDesc'] : $json_string['data'][0]['message'];
                $msgid          = isset($json_string['data'][0]['messageId']) ? $json_string['data'][0]['messageId'] : "";
                $response       = 'Data tidak ditemukan!<br>' . $msgdesc . ' | '.$code;
                
                if ($request->ajax())
                return response()->json(['status' => $status, 'code' => $code, 'desc' => $desc, 'msgdesc' => 'Data tidak ditemukan!<br>'.$msgdesc, 'msgid' => $msgid]);
            }
            
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        } 
    }
    
    public function pdf(Request $request)
    {
        \Assets::addJs('custom/pemindahbukuan/report.js');
        $printDate = now(); 
        $user = User::where('username', $request->userid)->first();
        
        try{
            $BackEndHelper = new BostHelper();
            $resp = $BackEndHelper->reportTrx($request);
            
            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $data = json_decode($resp, true)['data'];

                    // dd($data, $request);
                    $pdf = PDF::loadview('pemindahbukuan::report-transaksi.pdf', ['printDate' => $printDate, 'user' => $user, 'request' => $request, 'data' => $data]);
                    $pdf->setPaper('A4', 'landscape');
                    
                    return $pdf->stream('laporan-pdf.pdf');
                } else {
                    $json_string    = json_decode($resp, true);
                    $code           = $json_string['responseCode'];
                    $desc           = $json_string['responseDesc'];
                    $status         = 'error';
                    $response       = $code.' | '.$desc;
                    
                    return redirect('report-transaksi')->with($status, $response);
                }
            } else {
                $json_string    = json_decode($resp, true);
                $status         = $resp->status();
                $code           = $json_string['responseCode'];
                $desc           = $json_string['responseDesc'];
                $msgdesc        = isset($json_string['data'][0]['messageDesc']) ?  $json_string['data'][0]['messageDesc'] : $json_string['data'][0]['message'];
                $msgid          = isset($json_string['data'][0]['messageId']) ? $json_string['data'][0]['messageId'] : "";
                $response       = 'Data tidak ditemukan!<br>' . $msgdesc . ' | '.$code;
                
                if ($request->ajax())
                return response()->json(['status' => $status, 'code' => $code, 'desc' => $desc, 'msgdesc' => 'Data tidak ditemukan!<br>'.$msgdesc, 'msgid' => $msgid]);
            }
            
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        } 
        
        
    }
}
