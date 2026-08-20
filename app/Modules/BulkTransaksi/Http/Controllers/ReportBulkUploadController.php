<?php

namespace Modules\BulkTransaksi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Helper\BulkUpload\BulkHelper;
use App\Http\Helper\BulkUpload\ExportExcel;
use App\Entities\UnitKerja;
use Modules\User\Entities\User;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;
use PDF;
use DOMDocument;

class ReportBulkUploadController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $branch = UnitKerja::GetAll();
        $data = "";

        // if (auth()->user()->profile->rolename != "SUPER ADMIN" && !$request->session()->has('from_redirect')) {
        //     return $this->listReport($request);
        // }

        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/bulktransaksi/listbulk.js');
        \Assets::addJs('custom/bulktransaksi/report_bulk.js');
        return view('bulktransaksi::report-bulk.default', compact('data', 'branch', 'request'));
    }

    public function listReport(Request $request)
    {
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/bulktransaksi/listbulk.js');
        \Assets::addJs('custom/bulktransaksi/report_bulk.js');
        try {
            $BackEndHelper = new BulkHelper();
            $resp = $BackEndHelper->getListReport($request);
            // $branch = UnitKerja::GetAll();
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $data = json_decode($resp, true)['data'];
                    $addtInfo = json_decode($resp, true)['addtInfo'];
                    $branch = UnitKerja::GetAll();

                    // dd($data, $addtInfo);
                    return view('bulktransaksi::report-bulk.default', compact('data', 'request', 'branch', 'addtInfo'));
                } else {
                    $status     = 'warning';
                    $response   = $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                }
            } else if ($resp->status() == 400) {
                $status = 'warning';

                if (isset($resp['responseCode'])) {
                    $response   = $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                } else {
                    $response   = $resp->status() . ' | ' . $resp['message'] . '<br>' . implode(', <br>', $resp['errors']);
                }
            } else if ($resp->status() == 503) {
                $status     = 'error';
                $response   = $resp->status() . ' | ' . $resp->getReasonPhrase();
            } else {
                $status     = 'error';
                $response   = 'Terjadi Gangguan Sistem!<br> Silahkan Coba Kembali.';
            }

            return redirect('report-bulkupload')->with($status, $response)->with('from_redirect', true);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function export(Request $request)
    {
        \Assets::addJs('custom/bulktransaksi/report_bulk.js');
        $printDate = now();
        $maker = User::where('username', $request->createdBy)->first();
        $approver = User::where('username', auth()->user()->profile->rolename != "SUPER ADMIN" ? auth()->user()->username : $request->updatedBy)->first();

        try {
            $BackEndHelper = new BulkHelper();
            $resp = $BackEndHelper->getListReport($request);
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $data = json_decode($resp, true)['data'];
                    $addtInfo = json_decode($resp, true)['addtInfo'];

                    // dd($maker, $approver);
                    // dd($printDate, $maker, $approver, $request, $data, $addtInfo);
                    $pdf = PDF::loadview('bulktransaksi::report-bulk.exportPDF', ['printDate' => $printDate, 'maker' => $maker, 'approver' => $approver, 'request' => $request, 'data' => $data, 'addtInfo' => $addtInfo]);
                    $pdf->setPaper('A4', 'landscape');

                    return $pdf->stream('report-bulk.exportPDF');
                } else {
                    $json_string    = json_decode($resp, true);
                    $code           = $json_string['responseCode'];
                    $desc           = $json_string['responseDesc'];
                    $status         = 'error';
                    $response       = $code . ' | ' . $desc;

                    return redirect('report-bulk-transaksi')->with($status, $response);
                }
            } else {
                $json_string    = json_decode($resp, true);
                $status         = $resp->status();
                $code           = $json_string['responseCode'];
                $desc           = $json_string['responseDesc'];
                $msgdesc        = isset($json_string['data'][0]['messageDesc']) ?  $json_string['data'][0]['messageDesc'] : $json_string['data'][0]['message'];
                $msgid          = isset($json_string['data'][0]['messageId']) ? $json_string['data'][0]['messageId'] : "";
                $response       = 'Data tidak ditemukan!<br>' . $msgdesc . ' | ' . $code;

                if ($request->ajax())
                    return response()->json(['status' => $status, 'code' => $code, 'desc' => $desc, 'msgdesc' => 'Data tidak ditemukan!<br>' . $msgdesc, 'msgid' => $msgid]);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function pdfDownload(Request $request)
    {
        // dd($request);
        $printDate = now();
        $user = User::where('username', $request->usermaker)->first();

        try {
            $BackEndHelper = new BulkHelper();
            $resp = $BackEndHelper->getListReport($request);
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                $data = json_decode($resp, true)['data'];
                $addtInfo = json_decode($resp, true)['addtInfo'];

                usort($data, function ($a, $b) {
                    return $a['id'] - $b['id'];
                });

                $chunks = array_chunk($data, 5000);

                // Menyiapkan folder sementara untuk menyimpan file PDF
                $tempFolder = storage_path('app/temp/pdfs/' . auth()->user()->username);
                if (!is_writable($tempFolder)) {
                    // Coba membuat folder jika tidak bisa ditulis
                    if (!file_exists($tempFolder)) {
                        mkdir($tempFolder, 0777, true);
                    }
                }

                // Nama file ZIP untuk menyimpan PDF
                $zipFile = storage_path('app/temp/pdfs/laporan-pdf.zip');
                $zip = new ZipArchive;

                $maker = User::where('username', $request->createdBy)->first();
                $approver = User::where('username', auth()->user()->profile->rolename != "SUPER ADMIN" ? auth()->user()->username : $request->updatedBy)->first();

                // Membuka file ZIP untuk penambahan
                if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                    $pdfFiles = []; // Array untuk menyimpan path file PDF sementara

                    foreach ($chunks as $index => $chunk) {
                        // Membuat PDF untuk setiap chunk data
                        $pdfName = "laporan-{$index}.pdf";
                        $pdfPath = $tempFolder . '/' . $pdfName;

                        // $pdf = PDF::loadview('bulktransaksi::report-bulk.exportPDF', ['printDate' => $printDate, 'maker' => $maker, 'approver' => $approver, 'request' => $request, 'data' => $data, 'addtInfo' => $addtInfo]);
                        // Menghasilkan PDF dari chunk data
                        $pdf = SnappyPdf::loadView('bulktransaksi::report-bulk.exportPDF', [
                            'printDate' => now(),
                            'maker' => $maker,  // Sesuaikan dengan pengguna yang sesuai
                            'approver' => $approver,
                            'request' => $request,
                            'data' => $chunk,
                            'addtInfo' => $addtInfo
                        ])
                            ->setOption('page-size', 'A4')  // Ukuran halaman
                            ->setOption('orientation', 'landscape')  // Orientasi halaman
                            ->save($pdfPath);  // Simpan PDF ke path sementara

                        // Menambahkan file PDF ke dalam ZIP
                        $zip->addFile($pdfPath, $pdfName);
                        $pdfFiles[] = $pdfPath;  // Menambahkan path file PDF ke array
                    }
                    // dd($pdf);
                    // Menutup file ZIP setelah semua file PDF ditambahkan
                    $zip->close();

                    // Menghapus file sementara setelah pengunduhan
                    register_shutdown_function(function () use ($pdfFiles, $zipFile, $tempFolder) {
                        foreach ($pdfFiles as $file) {
                            @unlink($file);  // Menghapus file PDF sementara
                        }
                        @unlink($zipFile);  // Menghapus file ZIP setelah unduhan
                        @rmdir($tempFolder);  // Menghapus folder sementara setelah unduhan
                    });

                    // Mengunduh file ZIP yang berisi semua file PDF
                    return response()->download($zipFile)->deleteFileAfterSend(true);  // Menghapus file ZIP setelah diunduh
                } else {
                    return response()->json(['error' => 'Gagal membuat file ZIP.'], 500);
                }
            } else {
                return response()->json(['error' => 'Terjadi kesalahan dalam pengambilan data.'], 500);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
}
