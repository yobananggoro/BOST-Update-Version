<?php

namespace Modules\Pemindahbukuan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use App\Entities\Token;
use App\Entities\ReffToken;
use App\Entities\Log;
use Modules\Pemindahbukuan\Entities\Transactions;
use App\Entities\TransactionSeq;
use Modules\Rekening\Entities\Rekening;
use Modules\Account\Entities\TipeRekening;
use Modules\Pemindahbukuan\Http\Requests\ASIValidasiRequest;
use App\Http\Helper\Pemindahbukuan\AGIHelper;
use App\Http\Helper\Transaksi\TransaksiSequence;


class OnetomanyController extends \App\Http\Controllers\Controller
{
    private function generateReff()
    {
        $TransaksiSequence = new TransaksiSequence();
        return $TransaksiSequence::generateReff();
    }

    public function index(Request $request)
    {
        $rek = to_dropdown(Rekening::get(), 'id', 'nama');
        $reff = $this->generateReff();
        $accuseSrc = "internal";
        $accuseDst1 = "internal";

        \Assets::addJs('custom/apuppt.js');
        // \Assets::addJs('custom/costcenter.js');
        \Assets::addJs('custom/prompt/prompt_dynamic.js');
        \Assets::addJs('custom/pemindahbukuan/onetomany.js');
        return view('pemindahbukuan::onetomany.default', compact('rek', 'reff', 'accuseSrc', 'accuseDst1'));
    }

    public function validasi(Request $request)
    {
        // dd($request);
        $amountSumber = (int)$request->nominalSrc;
        $amountTujuan = (int)$request->total;

        if ($amountSumber == $amountTujuan) { //Validasi Nominal Sumber dan Tujuan 
            $AGIHelper = new AGIHelper();
            $resp = $AGIHelper->agivalOTM($request);
            // dd($resp, json_decode($resp, true), $resp->status());

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $data = $this->convJson($request, $resp);

                    return view('pemindahbukuan::onetomany.validate', compact('data'));
                } else if ($resp['responseCode'] == '10') {

                    $res = json_decode($resp, true);
                    // dd($res);
                    foreach ($res['data'] as $key => $value) {
                        if ($value['rc'] == '99') {
                            $acc        = $value['branch'] . '-' . $value['cif'] . '-' . $value['suffix'];
                            $msg        = isset($value['rcMsg'][0]['messageDesc']) ? $value['rcMsg'][0]['messageDesc'] : $value['rcMsg'];
                            $errDesc[]  = $acc . ' | ' . $msg;
                        }
                    }

                    $code       = 'Error code ' . $res['responseCode'];
                    $desc       = $res['responseDesc'];
                    $status     = 'error';
                    $response   = $code . ' | ' . $desc . '<br>' . implode('<br>', $errDesc);

                    return redirect('onetomany')->with($status, $response, $errDesc);
                } else {
                    $res    = json_decode($resp, true);
                    $code   = $res['responseCode'];

                    foreach ($res['data'] as $key => $value) {
                        if ($value['rc'] == '99') {
                            $acc        = $value['branch'] . '-' . $value['cif'] . '-' . $value['suffix'];
                            $msg        = isset($value['rcMsg'][0]['messageDesc']) ? $value['rcMsg'][0]['messageDesc'] : $value['rcMsg'];
                            $errDesc[]  = $acc . ' | ' . $msg;
                        }
                    }

                    $desc       = $res['responseDesc'];
                    $status     = 'error';
                    $response   = $code . ' | ' . $desc . '<br>' . implode('<br>', $errDesc);

                    return redirect('onetomany')->with($status, $response);
                }
            } else if ($resp->status() == 400) {
                if (isset($resp['responseCode'])) {
                    if ($resp['responseCode'] == 401) {
                        $status     = 'error';
                        $response   = 'Terjadi Gangguan Sistem!<br>' . $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                    } else {
                        $status     = 'error';
                        $response   = 'Terjadi Gangguan Sistem!<br>' . $resp->status() . ' | ' . $resp->message();
                    }
                }

                return redirect('onetomany')->with($status, $response);
            } else {
                $status     = 'error';
                $response   = 'Terjadi Gangguan Sistem!<br>' . $resp->status() . ' | ' . $resp->getReasonPhrase();

                return redirect('onetomany')->with($status, $response);
            }
        } else {
            $status     = 'error';
            $response   = 'Validasi Gagal!<br> Silahkan periksa kembali inputan anda.';

            return redirect('onetomany')->with($status, $response);
        }
    }

    private function convJson($request, $respAgi)
    {
        $json_string = json_decode($respAgi, true);
        // dd($respAgi,$request);
        foreach ($json_string['data'] as $key => $value) {

            foreach ($request->tipeDst as $key1 => $value1) {
                if ($key1 == $key - 1) {
                    $tipeDst = $value1;
                }
            }

            foreach ($request->accuseDst as $key2 => $value2) {
                if ($key2 == $key - 1) {
                    $accuseDst = $value2;
                }
            }

            // dd($key,$tipeDst,$accuseDst);

            if ($value['isDebits'] != true) {
                if ($value['rc'] == '00') {
                    // dd($key,$tipeDst,$accuseDst);
                    $credit[] = array(
                        'branchDst'             => $value['branch'],
                        'cifDst'                => $value['cif'],
                        'suffixDst'             => $value['suffix'],
                        'extDst'                => isset($value['accountNumber']) ? $value['accountNumber'] : null,
                        'destinationAccount'    => $accuseDst === "internal" ? $value['branch'] . " - " . $value['cif'] . " - " . $value['suffix'] : $value['accountNumber'],
                        'namaDst'               => $value['accountName'],
                        'ccyDst'                => $value['currency'],
                        'tipeDst'               => $tipeDst,
                        'accuseDst'             => $accuseDst,
                        'nominalDst'            => $value['amount'],
                        'txCodeName'            => $value['txCodeName'],
                        'status'                => $value['rcMsg']
                    );
                } else {
                    $credit[] = array(
                        'branchDst'             => $value['branch'],
                        'cifDst'                => $value['cif'],
                        'suffixDst'             => $value['suffix'],
                        'extDst'                => isset($value['accountNumber']) ? $value['accountNumber'] : null,
                        'destinationAccount'    => $accuseDst === "internal" ? $value['branch'] . " - " . $value['cif'] . " - " . $value['suffix'] : $value['accountNumber'],
                        'dstExtNumber'          => "",
                        'namaDst'               => "",
                        'ccyDst'                => "",
                        'tipeDst'               => $tipeDst,
                        'accuseDst'             => $accuseDst,
                        'nominalDst'            => $value['amount'],
                        'txCodeName'            => "",
                        'status'                => $value['rcMsg'][0]['messageDesc']
                    );
                }
            } else {
                $debit[] = array(
                    'branchSrc'     => $json_string['data'][$key]['branch'],
                    'cifSrc'        => $json_string['data'][$key]['cif'],
                    'suffixSrc'     => $json_string['data'][$key]['suffix'],
                    'extSrc'        => isset($json_string['data'][$key]['accountNumber']) ? $json_string['data'][$key]['accountNumber'] : null,
                    'sourceAccount' => $request->accuseSrc == 'internal' ? $json_string['data'][$key]['branch'] . " - " . $json_string['data'][$key]['cif'] . " - " . $json_string['data'][$key]['suffix'] : $json_string['data'][$key]['accountNumber'],
                    'namaSrc'       => array_key_exists("accountName", $json_string['data'][$key]) ? $json_string['data'][$key]['accountName'] : "-",
                    'ccySrc'        => array_key_exists("currency", $json_string['data'][$key]) ? $json_string['data'][$key]['currency'] : "-",
                    'tipeSrc'       => $request->tipeSrc,
                    'accuseSrc'     => $request->accuseSrc,
                    'nominalSrc_'   => $request->nominalSrc_,
                    'nominalSrc'    => $json_string['data'][$key]['amount'],
                    'txCodeName'    => $json_string['data'][$key]['txCodeName'],
                    'status'        => $json_string['data'][$key]['rcMsg']
                );
            }
        }

        $data = array(
            'rekening_sumber'   => $debit,
            'rekening_tujuan'   => $credit,
            'reff'              => $request->reff,
            'nominal'           => $request->total,
            'narative1'         => array_key_exists("narrative1", $json_string['data'][0]) ? $json_string['data'][0]['narrative1'] : "",
            'narative2'         => array_key_exists("narrative2", $json_string['data'][0]) ? $json_string['data'][0]['narrative2'] : "",
            'narative3'         => array_key_exists("narrative3", $json_string['data'][0]) ? $json_string['data'][0]['narrative3'] : "",
            'narative4'         => array_key_exists("narrative4", $json_string['data'][0]) ? $json_string['data'][0]['narrative4'] : "",
            // 'status_transaksi'  => $json_string['responseDesc'],

            'instrumentCode'        => $request->instrumentrx,
            'instrumentOther'       => $request->instrumentrx == '99' ? $request->instrumenLainnya : null,
            'classificationCode'    => $request->klasifikasitrx,
            'classificationOther'   => $request->klasifikasitrx == '99' ? $request->klasifikasiLainnya : null,
            'purposeCode'           => $request->kepentingantrx,
            'purposeOther'          => $request->kepentingantrx == '99' ? $request->kepentinganLainnya : null,
            'sourceCode'            => $request->sumberdanatrx,
            'sourceOther'           => $request->sumberdanatrx == '9' ? $request->sumberDanaLainnya : null,
            'destinationCode'       => $request->tujuantrx,
            'destinationOther'      => $request->tujuantrx == '9' ? $request->tujuanLainnya : null,
            'remark'                => $request->beritaTrx,
        );

        // dd($data);
        return $data;
    }

    public function store(Request $request)
    {
        // dd($request);
        $data = new Transactions();
        $data->id = Str::uuid();
        $data->tipe_transaksi = 2;
        $data->reff = $request->reff;
        $data->tanggal = Carbon::now();
        $data->nominal = $request->nominal_total;
        $data->userid = auth()->user()->username;
        $data->branch = auth()->user()->profile->unit_kerja_kode;
        $data->status_override = 1;
        $data->status_transaksi = 1;
        $debit[] = array(
            'branchSrc'     => $request->branchSrc,
            'cifSrc'        => $request->cifSrc,
            'suffixSrc'     => $request->suffixSrc,
            'extSrc'        => $request->extSrc,
            'tipeSrc'       => $request->tipeSrc,
            'namaSrc'       => $request->namaSrc,
            'ccySrc'        => $request->ccySrc,
            'nominalSrc'    => $request->nominalSrc,
            'accuseSrc'     => $request->accuseSrc
        );

        foreach ($request->branchDst as $key => $value) {
            $credit[] = array(
                'branchDst'     => $request->branchDst[$key],
                'cifDst'        => $request->cifDst[$key],
                'suffixDst'     => $request->suffixDst[$key],
                'extDst'        => $request->extDst[$key],
                'tipeDst'       => $request->tipeDst[$key],
                'namaDst'       => $request->namaDst[$key],
                'ccyDst'        => $request->ccyDst[$key],
                'nominalDst'    => $request->nominalDst[$key],
                'accuseDst'     => $request->accuseDst[$key]
            );
        }

        $data->additional_info = json_encode([
            'rekening_sumber'       => $debit,
            'rekening_tujuan'       => $credit,
            'nominal'               => $request->nominal_total,
            'narative1'             => $request->narative1,
            'narative2'             => $request->narative2,
            'narative3'             => $request->narative3,
            'narative4'             => $request->narative4,
            'instrumentCode'        => $request->instrumentCode,
            'instrumentOther'       => $request->instrumentOther,
            'classificationCode'    => $request->classificationCode,
            'classificationOther'   => $request->classificationOther,
            'purposeCode'           => $request->purposeCode,
            'purposeOther'          => $request->purposeOther,
            'sourceCode'            => $request->sourceCode,
            'sourceOther'           => $request->sourceOther,
            'destinationCode'       => $request->destinationCode,
            'destinationOther'      => $request->destinationOther,
            'remark'                => $request->remark,
        ]);
        // dd($data, json_decode($data->additional_info, true));

        $message = ['key' => 'Pemindahbukuan One To Many Dengan Nomor Refference', 'value' => $request->reff];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if (auth()->user()->profile->is_transactions == true) {
            DB::beginTransaction();
            if ($request->reff == $this->generateReff()) {
                if ($data->save()) {
                    // Increase value sequence
                    $TransaksiSequence = new TransaksiSequence();
                    $incrementSeq = $TransaksiSequence::increaseCounter();

                    if ($incrementSeq == true) {
                        DB::commit();
                        $status = 'success';
                        $response = trans('message.create_success', $message);
                    } else {
                        DB::rollBack();
                        $status = 'error';
                        $response = 'Terjadi kesalahan pada saat proses generate refference. Silakan coba lagi.';
                    }
                } else {
                    DB::rollBack();
                    $status = 'error';
                    $response = 'Gagal menyimpan transaksi. Silakan coba lagi.';
                }
            } else {
                $status = 'warning';
                $response = 'Nomor Refference tidak boleh sama.';
            }
        } else {
            $status = 'error';
            $response = 'Anda tidak punya akses untuk melakukan transaksi!';

            return redirect('onetomany')->with($status, $response)->with('request', $request->all());
        }

        return redirect('onetomany')->with($status, $response)->with('request', $request->all());
    }

    public function posting(Request $request)
    {
        // dd($request);
        $data = Transactions::findOrFail($request->id);
        $additional_info = json_decode($data->additional_info, true);
        // dd($data, $additional_info);exit;

        foreach ($additional_info['rekening_sumber'] as $key => $value) {
            $except = ['sourceAccount', 'namaSrc', 'txCodeName', 'status'];
            $result = array_diff_key($value, array_flip($except));

            foreach ($result as $property => $val) {
                $data->{$property} = $val;
            }
        }

        foreach ($additional_info['rekening_tujuan'] as $key => $value) {
            $except = ['destinationAccount', 'namaDst', 'txCodeName', 'status'];
            $result = array_diff_key($value, array_flip($except));

            foreach ($result as $property => $val) {
                $dataDst[] = $property;

                foreach ($dataDst as $dtaDst => $nilai) {
                    if ($property == $dataDst[$dtaDst]) {
                        $Dst[$nilai][] = $value[$nilai];
                    } else {
                        continue;
                    }

                    break;
                }

                $data->{$property} = $Dst[$nilai];
            }
        }

        $data->narative1  = $additional_info['narative1'];
        $data->narative2  = $additional_info['narative2'];
        $data->narative3  = $additional_info['narative3'];
        $data->narative4  = $additional_info['narative4'];

        $data->instrumentCode       = $additional_info['instrumentCode'];
        $data->instrumentOther      = $additional_info['instrumentOther'];
        $data->classificationCode   = $additional_info['classificationCode'];
        $data->classificationOther  = $additional_info['classificationOther'];
        $data->purposeCode          = $additional_info['purposeCode'];
        $data->purposeOther         = $additional_info['purposeOther'];
        $data->sourceCode           = $additional_info['sourceCode'];
        $data->sourceOther          = $additional_info['sourceOther'];
        $data->destinationCode      = $additional_info['destinationCode'];
        $data->destinationOther     = $additional_info['destinationOther'];
        $data->remark               = $additional_info['remark'];
        // dd($data);

        try {
            $reffToken = ReffToken::FindTokenReff(auth()->user()->username . "-" . $request->id)->first();  //cek reference token
            if (is_null($reffToken)) {
                try {
                    $ReffToken = new ReffToken();
                    $ReffToken->token = auth()->user()->username . "-" . $request->id;
                    $ReffToken->reference = $request->reff;
                    $ReffToken->save(); //save reference token

                } catch (\Exception $e) {
                    $status = 'warning';
                    $response = 'Terjadi kesalahan pada saat: ' . $e->getMessage();

                    return redirect()->back()->with($status, $response);
                }
            } else {
                $status = 'error';
                $response = 'Reference ' . $request->reff . ' sudah pernah ditransaksikan!';

                return redirect()->back()->with($status, $response);
            }

            // Call api posting AGI
            $AGIHelper = new AGIHelper();
            $resp = $AGIHelper->agivalpostOTM($data);
            // dd($resp,$resp->status(), json_decode($resp, true));

            $del = array(
                'branchSrc',
                'cifSrc',
                'suffixSrc',
                'extSrc',
                'tipeSrc',
                'ccySrc',
                'nominalSrc',
                'nominalSrc_',
                'accuseSrc',
                'branchDst',
                'cifDst',
                'suffixDst',
                'extDst',
                'tipeDst',
                'ccyDst',
                'nominalDst',
                'accuseDst',
                'narative1',
                'narative2',
                'narative3',
                'narative4',
                'instrumentCode',
                'instrumentOther',
                'classificationCode',
                'classificationOther',
                'purposeCode',
                'purposeOther',
                'sourceCode',
                'sourceOther',
                'destinationCode',
                'destinationOther',
                'remark',
            );

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $res = $this->convJson($data, $resp);
                    // dd($res);
                    foreach ($del as $key => $value) {
                        unset($data[$value]);
                    }

                    $data->additional_info = json_encode($res);
                    $data->status_transaksi = 2;
                    $data->status_override = 2;
                    $data->response_http = $resp->status();
                    $data->user_override = auth()->user()->username;
                    $data->response_message = json_decode($resp, true);
                    $data->save();

                    return true;
                } else {
                    $status     = 'warning';
                    $response   =  $resp['responseCode'] . ' | ' . $resp['responseDesc'];

                    foreach ($del as $key => $value) {
                        unset($data[$value]);
                    }

                    $data->status_transaksi = 3;
                    $data->status_override = 2;
                    $data->response_http = $resp->status();
                    $data->user_override = auth()->user()->username;
                    $data->response_message = json_decode($resp, true);
                    $data->save();
                }
            } else if ($resp->status() == 409) {
                $status     = 'warning';
                $response   =  $resp->status() . ' | ' . $resp['responseDesc'];
            } else {
                foreach ($del as $key => $value) {
                    unset($data[$value]);
                }

                $data->status_transaksi = 3;
                $data->response_http = $respAgi->status();
                $data->response_message = json_decode($respAgi, true);
                $data->save();

                return false;
            }

            return redirect()->back()->with($status, $response);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}
