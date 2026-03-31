<?php

namespace Modules\BulkTransaksi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use App\Imports\TotalImport;
use App\Http\Helper\BulkUpload\BulkHelper;
use App\Http\Helper\Transaksi\TransaksiSequence;
use Modules\BulkTransaksi\Http\Requests\BulkUploadRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Entities\TransactionSeq;

class BulkOneToOneHOController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $TransaksiSequence = new TransaksiSequence();
        $reff = $TransaksiSequence::generateReff();

        \Assets::addJs('custom/bulktransaksi/bulk_onetoone.js');
        return view('bulktransaksi::onetoone-ho.default', compact('reff'));
    }

    public function validasi(BulkUploadRequest $request)
    {
        try {
            $import = new TotalImport();
            Excel::import($import, $request->file('file'));
            $totalRows = $import->getRows();
            $maxRowBulk = (int)config('parameter.max_bulk_rows');

            if ($totalRows <= $maxRowBulk) {
                $BackEndHelper = new BulkHelper();
                $resp = $BackEndHelper->bulkUploadITAHO($request);
                // dd($resp, $resp->getStatusCode(), $resp->original['message']);

                if ($resp->getStatusCode() == '202') {
                    $TransaksiSequence = new TransaksiSequence();
                    $incrementSeq = $TransaksiSequence::increaseCounter();

                    $status = 'success';
                    $response = $resp->getStatusCode() . ' | ' . $resp->original['message'];
                } else if ($resp->getStatusCode() == '400') {
                    $startPos = strpos($resp->original['message'], "response:");

                    if ($startPos != false) {
                        $startPos += strlen("response: ");
                        $substring = substr($resp->original['message'], $startPos);
                        $message = $substring;
                    }

                    $status     = 'error';
                    $response   = $resp->getStatusCode() . ' | ' . $message;
                } else {
                    // dd(false);
                    $status     = 'error';
                    $response   = 'Terjadi Gangguan Sistem!<br>' . $resp->status() . ' | ' . $resp->getReasonPhrase();
                }
            } else {
                $status     = 'error';
                $response   = 'Batas maksimal '.number_format($maxRowBulk, 0, '', '.').' baris, Jumlah baris pada file melebihi kapasitas yang bisa diakomodir oleh sistem!';
            }

            return redirect('upload-onetoone-ho')->with($status, $response);
        } catch (Exception $e) {
            return $e->getMessage();
            die;
        }
    }

    public function downloadTemplate($filename)
    {
        $filePath = public_path("template/{$filename}");
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            $status     = 'warning';
            $response   = '404 | File not found';

            return redirect('upload-onetoone-ho')->with($status, $response);
        }
    }
}
