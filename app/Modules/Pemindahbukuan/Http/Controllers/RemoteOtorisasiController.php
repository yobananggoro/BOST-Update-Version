<?php

namespace Modules\Pemindahbukuan\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Pemindahbukuan\Entities\Transactions;
use Modules\Opsi\Entities\OptionGroup;
use Modules\Opsi\Entities\OptionValue;
use Modules\Pemindahbukuan\Http\Controllers\OnetooneController;
use Modules\Pemindahbukuan\Http\Controllers\OnetomanyController;
use App\Entities\UnitKerja;
use App\Entities\ReffToken;
use App\Http\Helper\BostHelper;

class RemoteOtorisasiController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $data = Transactions::otoremote($request);
        $branch = UnitKerja::GetAll();
        // dd($branch);

        return view('pemindahbukuan::remote-otorisasi.default', compact('request', 'data', 'branch'));
    }

    public function show($id)
    {
        $data = Transactions::findOrFail($id);
        $additional_info = json_decode($data->additional_info, true);
        // dd($data->response_message, json_decode($data->response_message, true)['data']['messageDesc']);
        // dd($data, $additional_info);

        \Assets::addJs('custom/remoteOto.js');
        return view('pemindahbukuan::remote-otorisasi.detail', compact('data', 'additional_info'));
    }

    public function checkOtorisasi($data)
    {
        // dd($data);
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

            return redirect()->back()->with($status, $response);
        }
    }

    public function approval(Request $request)
    {
        $data = Transactions::findOrFail($request->id);

        if (auth()->user()->profile->limit_debet >= $request->total_nominal) {
            if ($request->subject == 'approve') { //transaksi diapprove

                if (auth()->user()->profile->isFinger == true) {
                    $action = $this->checkOtorisasi($request);

                    if ($action == '02') {
                        $status = 'warning';
                        $response = 'Tidak ada fingerprint yang cocok.';

                        return redirect()->back()->with($status, $response);
                    } else if ($action == '03') {
                        $status = 'error';
                        $response = 'Terjadi Gangguan pada saat verifikasi fingerprint.';

                        return redirect()->back()->with($status, $response);
                    }
                }

                $post = $this->transactions($request);
                if ($post) {
                    $status = 'success';
                    $response = 'Nomor Refference ' . $data->reff . ' disetujui.';
                } else {
                    $status = 'error';
                    $response = 'Terjadi Gangguan!<br> Silahkan perikasa kembali Nomor Refference ' . $data->reff . '.';
                    $this->cancelReffToken($request);
                }
            } else { //transaksi ditolak
                $data->user_override = auth()->user()->username;
                $data->status_override = 3;
                $data->save();

                $status = 'success';
                $response = 'Nomor Refference ' . $data->reff . ' ditolak.';
            }
        } else {
            $status = 'error';
            $response = 'Nomor Refference <b>' . $data->reff . '</b> tidak dapat diproses.<br>Limit Otorisiasi anda kurang dari jumlah nominal yang akan ditransaksikan.<br>  ';
        }

        \Assets::addJs('custom/remoteOto.js');
        return redirect('remote-otorisasi')->with($status, $response);
    }

    public function transactions($data)
    {
        if ($data->tipe_transaksi == '1') {
            // dd('a');
            $post = app(OnetooneController::class)->posting($data); //One to One
        } else if ($data->tipe_transaksi == '2') {
            // dd('b');
            $post = app(OnetomanyController::class)->posting($data); //One to Many
        } else {
            // dd('c');
            $post = app(ManytooneController::class)->posting($data); //Many to One
        }


        // dd($post,is_bool($post));
        $post = is_bool($post) == true ? $post = true : $post = false;

        return $post;
    }

    public function cancelReffToken($data)
    {
        $reffToken = ReffToken::where('token', auth()->user()->username . "-" . $data->id);  //cek reference token
        // dd($data,$reffToken);
        if (!is_null($reffToken)) {
            try {
                $reffToken->delete();

                return;
            } catch (\Exception $e) {
                $status = 'warning';
                $response = 'Terjadi kesalahan pada saat: ' . $e->getMessage();

                return redirect()->back()->with($status, $response);
            }
        }
    }
}
