<?php

namespace Modules\BulkTransaksi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Imports\TotalImport;
use App\Http\Helper\BulkUpload\BulkHelper;
use App\Http\Helper\Transaksi\TransaksiSequence;
use Modules\BulkTransaksi\Http\Requests\BulkUploadRequest;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\HeadingRowImport;
use App\Entities\TransactionSeq;

class BulkManyToManyController extends \App\Http\Controllers\Controller
{
    private function generateReff()
    {
        $TransaksiSequence = new TransaksiSequence();
        return $TransaksiSequence::generateReff();
    }

    public function index(Request $request)
    {
        $reff = $this->generateReff();
        $branch = auth()->user()->profile->unit_kerja_kode;
        $accuse = 'internal';

        \Assets::addJs('custom/apuppt.js');
        \Assets::addJs('custom/jenistrx.js');
        \Assets::addJs('custom/bulktransaksi/bulk_manytomany.js');
        \Assets::addJs('custom/prompt/prompt.js');
        return view('bulktransaksi::manytomany.default', compact('reff', 'accuse'));
    }

    public function validasi(BulkUploadRequest $request)
    {
        try {
            $headings = (new HeadingRowImport)->toArray($request->file('file'));
            if (!isset($headings[0][0]) || !in_array('refference', $headings[0][0])) {
                return redirect()->back()->withErrors([
                    'file' => ['Silahkan periksa kembali template anda, disarankan menggunakan template yang sudah disediakan..']
                ]);
            }
            
            $import = new TotalImport();
            Excel::import($import, $request->file('file'));
            $totalRows = $import->getRows();
            $maxRowBulk = (int)config('parameter.max_bulk_rows');

            if ($request->reff == $this->generateReff()) {
                if ($totalRows <= $maxRowBulk) {
                    $BackEndHelper = new BulkHelper();
                    $resp = $BackEndHelper->bulkUploadMTM($request);
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
                    $response   = 'Batas maksimal ' . number_format($maxRowBulk, 0, '', '.') . ' baris, Jumlah baris pada file melebihi kapasitas yang bisa diakomodir oleh sistem!';
                }
            } else {
                $status = 'warning';
                $response = 'Nomor Refference tidak boleh sama.';
            }

            return redirect('upload-manytomany')->with($status, $response);
        } catch (ValidationException $e) {
            // Mengambil semua pesan error validasi Excel
            $failures = $e->failures();

            // Mengambil pesan error pertama saja untuk ditampilkan ke user
            $errorMessage = $failures[0]->errors()[0];

            return redirect()->back()->withErrors([
                'file' => $errorMessage
            ]);
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

            return redirect('upload-manytomany')->with($status, $response);
        }
    }
}
