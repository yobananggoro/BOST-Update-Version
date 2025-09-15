<?php

namespace Modules\BulkTransaksi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Helper\BulkUpload\BulkHelper;
use App\Entities\UnitKerja;
use Modules\User\Entities\User;
use Barryvdh\Snappy\Facades\SnappyPdf;
use ZipArchive;

class ListBulkUploadController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $branch = UnitKerja::GetAll();
        $data = "";
        
        if (auth()->user()->profile->rolename != "SUPER ADMIN" && !$request->session()->has('from_redirect')) {
            return $this->listBulk($request);
        }

        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/bulktransaksi/listbulk.js');
        return view('bulktransaksi::transaksi-list.default', compact('data', 'branch', 'request'));
    }

    public function listBulk(Request $request)
    {
        \Assets::addJs('custom/bulktransaksi/listbulk.js');
        \Assets::addJs('dataTables.js');
        try {
            $BackEndHelper = new BulkHelper();
            $resp = $BackEndHelper->getListBulk($request);
            // $branch = UnitKerja::GetAll();
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $data = json_decode($resp, true)['data'];
                    $branch = UnitKerja::GetAll();

                    // dd($data);
                    return view('bulktransaksi::transaksi-list.default', compact('data', 'request', 'branch'));
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

            return redirect('list-bulkupload')->with($status, $response)->with('from_redirect', true);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function listDetail(Request $request)
    {
        // dd($request);
        \Assets::addJs('custom/bulktransaksi/listbulk.js');
        \Assets::addJs('dataTables.js');
        try {
            $BackEndHelper = new BulkHelper();
            $size = config('parameter.size_detail_bulk');
            $resp = $BackEndHelper->getListDetail($request, $size);
            // dd($resp, json_decode($resp[0], true));

            if ($resp[0]->status() == 200) {
                $data = json_decode($resp[0], true)['data'];
                $addtInfo = isset(json_decode($resp[0], true)['addtInfo']) ? json_decode($resp[0], true)['addtInfo'] : '';
                $page = $resp[1];
                usort($data, function ($a, $b) {
                    return $a['id'] - $b['id'];
                });
                // dd($addtInfo);

                return view('bulktransaksi::transaksi-list.detail', compact('data', 'page', 'request', 'size', 'addtInfo'));
            } else if ($resp[0]->status() == 400) {
                $status = 'warning';

                if (isset($resp[0]['responseCode'])) {
                    $response   = $resp[0]['responseCode'] . ' | ' . $resp[0]['responseDesc'];
                } else {
                    $response   = $resp[0]->status() . ' | ' . $resp[0]['message'] . '<br>' . implode(', <br>', $resp[0]['errors']);
                }
            } else {
                $status     = 'error';
                $response   = 'Terjadi Gangguan Sistem!<br> Silahkan Coba Kembali.';
            }

            return redirect('list-bulkupload')->with($status, $response)->with('from_redirect', true);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function verify(Request $request)
    {
        \Assets::addJs('dataTables.js');
        try {
            $BackEndHelper = new BulkHelper();
            $resp = $BackEndHelper->verifyBulk($request);
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                $status     = 'success';
                $response   = $resp['responseCode'] . ' | ' . $resp['responseDesc'];
            } else if ($resp->status() == 400) {
                $status = 'warning';

                if (isset($resp['responseCode'])) {
                    $response   = $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                } else {
                    $response   = $resp->status() . ' | ' . $resp['message'];
                }
            } else {
                $status     = 'error';
                $response   = 'Terjadi Gangguan Sistem!<br> Silahkan Coba Kembali.';
            }

            return redirect('list-bulkupload')->with($status, $response)->with('from_redirect', true);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function pdf(Request $request)
    {
        // dd($request);
        $printDate = now();
        $user = User::where('username', $request->usermaker)->first();

        $BulkHelper = new BulkHelper();
        $resp = $BulkHelper->getDetailReport($request);
        // dd($resp, json_decode($resp, true));

        if ($resp->status() == 200) {
            $data = json_decode($resp, true)['data'];

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

            // Membuka file ZIP untuk penambahan
            if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $pdfFiles = []; // Array untuk menyimpan path file PDF sementara

                foreach ($chunks as $index => $chunk) {
                    // Membuat PDF untuk setiap chunk data
                    $pdfName = "laporan-{$index}.pdf";
                    $pdfPath = $tempFolder . '/' . $pdfName;
                    // Menghasilkan PDF dari chunk data
                    $pdf = SnappyPdf::loadView('bulktransaksi::transaksi-list.pdf', [
                        'printDate' => now(),
                        'user' => User::where('username', $request->usermaker)->first(),  // Sesuaikan dengan pengguna yang sesuai
                        'reff' => $request->reff,
                        'useroto' => $request->useroto,
                        'timeoto' => $request->timeoto,
                        'data' => $chunk,
                    ])
                        ->setOption('page-size', 'A4')  // Ukuran halaman
                        ->setOption('orientation', 'landscape')  // Orientasi halaman
                        ->save($pdfPath);  // Simpan PDF ke path sementara

                    // Menambahkan file PDF ke dalam ZIP
                    $zip->addFile($pdfPath, $pdfName);
                    $pdfFiles[] = $pdfPath;  // Menambahkan path file PDF ke array
                }

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
    }
}
