<?php

namespace Modules\BulkTransaksi\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helper\BulkUpload\BulkHelper;
use App\Http\Helper\BostHelper;
use App\Entities\UnitKerja;
use PDF;

class RemoteBulkUploadController extends \App\Http\Controllers\Controller
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
        return view('bulktransaksi::remote-otorsasibulk.default', compact('data', 'branch', 'request'));
    }

    public function listBulk(Request $request)
    {
        \Assets::addJs('custom/bulktransaksi/listbulk.js');
        \Assets::addJs('dataTables.js');
        try {
            $BackEndHelper = new BulkHelper();
            $resp = $BackEndHelper->getListBulkOto($request);
            $branch = UnitKerja::GetAll();
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $data = json_decode($resp, true)['data'];
                    // dd($data);

                    return view('bulktransaksi::remote-otorsasibulk.default', compact('data', 'request', 'branch'));
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

            return redirect('remote-otorisasibulk')->with($status, $response)->with('from_redirect', true);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function listDetail(Request $request)
    {
        \Assets::addJs('custom/remoteOto.js');
        \Assets::addJs('dataTables.js');
        \Assets::addJs('custom/bulktransaksi/listbulk.js');

        try {
            $BackEndHelper = new BulkHelper();
            $size = config('parameter.size_detail_bulk');
            $resp = $BackEndHelper->getListDetail($request, $size);
            // dd($resp, json_decode($resp[0], true));
            if ($resp[0]->status() == 200) {
                $data = json_decode($resp[0], true)['data'];
                $page = $resp[1];
                usort($data, function ($a, $b) {
                    return $a['id'] - $b['id'];
                });
                // dd($data,$page,$request);

                return view('bulktransaksi::remote-otorsasibulk.detail', compact('data', 'page', 'request', 'size'));
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

            return redirect('remote-otorisasibulk')->with($status, $response)->with('from_redirect', true);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function approval(Request $request)
    {
        // dd($request, auth()->user()->profile->limit_debet);
        \Assets::addJs('dataTables.js');

        if ($request->subject == 'approve') {
            if (auth()->user()->profile->limit_debet >= $request->amount) {
                // dd('a');
                if (auth()->user()->profile->isFinger == true) {
                    $action = $this->checkOtorisasi($request);

                    if ($action == '02') {
                        $status = 'warning';
                        $response = 'Tidak ada fingerprint yang cocok.';

                        return redirect()->back()->with($status, $response);
                    } else if ($action == '03') {
                        $status = 'error';
                        $response = 'Terjadi Gangguan pada saat verifikasi fingerprint.';

                        return redirect()->back()->with($status, $response)->with('from_redirect', true);
                    }
                }
                // dd('b');
                try {
                    $BackEndHelper = new BulkHelper();
                    $resp = $BackEndHelper->approveBulk($request);
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

                    return redirect('remote-otorisasibulk')->with($status, $response)->with('from_redirect', true);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    die;
                }
            } else {
                $status = 'warning';
                $response = 'Nomor Refference <b>' . $request->reff . '</b> tidak dapat diproses.<br>Limit Otorisiasi anda kurang dari jumlah nominal yang akan ditransaksikan.<br>  ';
            }
        } else {
            try {
                $BackEndHelper = new BulkHelper();
                $resp = $BackEndHelper->approveBulk($request);
                // dd($resp, json_decode($resp, true));

                if ($resp->status() == 200) {
                    $status     = 'warning';
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

                return redirect('remote-otorisasibulk')->with($status, $response)->with('from_redirect', true);
            } catch (\Exception $e) {
                echo $e->getMessage();
                die;
            }

            $status = 'warning';
            $response = 'Nomor Refference ' . $request->reff . ' ditolak.';
        }

        \Assets::addJs('custom/pemindahbukuan/remoteOto.js');
        return redirect('remote-otorisasibulk')->with($status, $response)->with('from_redirect', true);
    }

    public function checkOtorisasi($data)
    {
        try {
            $statusOto = "00";
            if (auth()->user()->profile->isFinger == true) {
                $BackEndHelper = new BostHelper();
                $response = $BackEndHelper->otorisasiFinger($data);

                if ($response->status() == 200) {
                    $json_string = json_decode($response, true);

                    if ($json_string['statusCode'] == 200) {
                        $statusOto = "00"; //Sukses
                    } else {
                        $statusOto = "02"; //Finger Tidak Sesuai
                    }
                } else {
                    $statusOto = "03";
                }
            }

            return $statusOto;
        } catch (\Exception $e) {
            $status = 'warning';
            $response = 'Terjadi kesalahan: ' . $e->getMessage();

            return redirect()->back()->with($status, $response)->with('from_redirect', true);
        }
    }
}
