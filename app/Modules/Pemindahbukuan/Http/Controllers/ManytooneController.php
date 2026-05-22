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


class ManytooneController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $rek = to_dropdown(Rekening::get(), 'id', 'nama');
        $TransaksiSequence = new TransaksiSequence();
        $reff = $TransaksiSequence::generateReff();
        $accuseSrc1 = "internal";
        $accuseDst = "internal";

        \Assets::addJs('custom/apuppt.js');
        \Assets::addJs('custom/prompt/prompt_dynamic.js');
        \Assets::addJs('custom/pemindahbukuan/manytoone.js');
        return view('pemindahbukuan::manytoone.default', compact('rek', 'reff', 'accuseSrc1', 'accuseDst'));
    }

    public function validasi(Request $request)
    {
        // dd($request);
        $amountSumber = (int)$request->total;
        $amountTujuan = (int)$request->nominalDst;

        if ($amountSumber == $amountTujuan) { //Validasi Nominal Sumber dan Tujuan 
            $AGIHelper = new AGIHelper();
            $resp = $AGIHelper->agivalMTO($request);
            // dd($resp, json_decode($resp, true), $resp->status());

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $data = $this->convJson($request, $resp);

                    return view('pemindahbukuan::manytoone.validate', compact('data'));
                } else if ($resp['responseCode'] == '10') {
                    $res = json_decode($resp, true);

                    foreach ($res['data'] as $key => $value) {
                        if ($value['rc'] == '99') {
                            $acc     = $value['branch'] . '-' . $value['cif'] . '-' . $value['suffix'];
                            $msg     = isset($value['rcMsg'][0]['messageDesc']) ? $value['rcMsg'][0]['messageDesc'] : $value['rcMsg'];
                            $errDesc[] = $acc . ' | ' . $msg;
                        }
                    }

                    $code       = 'Error code ' . $res['responseCode'];
                    $desc       = $res['responseDesc'];
                    $status     = 'error';
                    $response   = $code . ' | ' . $desc . '<br>' . implode('<br>', $errDesc);

                    return redirect('manytoone')->with($status, $response, $errDesc);
                } else {
                    $res        = json_decode($resp, true);
                    $code       = $res['responseCode'];

                    foreach ($res['data'] as $key => $value) {
                        if ($value['rc'] == '99') {
                            $acc     = $value['branch'] . '-' . $value['cif'] . '-' . $value['suffix'];
                            $msg     = isset($value['rcMsg'][0]['messageDesc']) ? $value['rcMsg'][0]['messageDesc'] : $value['rcMsg'];
                            $errDesc[] = $acc . ' | ' . $msg;
                        }
                    }

                    $desc       = $res['responseDesc'];
                    $status     = 'error';
                    $response   = $code . ' | ' . $desc . '<br>' . implode('<br>', $errDesc);
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
            } else {
                $status = 'error';
                $response   = 'Terjadi Gangguan Sistem!<br>' . $resp->status() . ' | ' . $resp->getReasonPhrase();
            }
        } else {
            $status = 'error';
            $response   = 'Validasi Gagal!<br> Silahkan periksa kembali inputan anda.';
        }

        return redirect('manytoone')->with($status, $response);
    }

    private function convJson($request, $respAgi)
    {
        $json_string = json_decode($respAgi, true);
        // dd($request, $respAgi, $json_string,);
        foreach ($json_string['data'] as $key => $value) {
            foreach ($request->tipeSrc as $key1 => $value1) {
                if ($key1 === $key) {
                    $tipeSrc = $value1;
                }
            }

            foreach ($request->accuseSrc as $key2 => $value2) {
                if ($key2 === $key) {
                    $accuseSrc = $value2;
                }
            }

            // dd($tipeSrc,$accuseSrc);

            if ($value['isDebits'] == true) {
                if ($value['rc'] == '00') {
                    // dd($key,$tipeSrc,$accuseSrc);
                    $debit[] = array(
                        'branchSrc'                 => $value['branch'],
                        'cifSrc'                    => $value['cif'],
                        'suffixSrc'                 => $value['suffix'],
                        'extSrc'                    => $value['accountNumber'],
                        'sourceAccount'             => $accuseSrc == 'internal' ? $value['branch'] . " - " . $value['cif'] . " - " . $value['suffix'] : $value['accountNumber'],
                        'namaSrc'                   => $value['accountName'],
                        'ccySrc'                    => $value['currency'],
                        'tipeSrc'                   => $tipeSrc,
                        'accuseSrc'                 => $accuseSrc,
                        'nominalSrc'                => $value['amount'],
                        'txCodeName'                => $value['txCodeName'],
                        'status'                    => $value['rcMsg']
                    );
                } else {
                    $debit[] = array(
                        'branchSrc'                 => $value['branch'],
                        'cifSrc'                    => $value['cif'],
                        'suffixSrc'                 => $value['suffix'],
                        'extSrc'                    => $value['accountNumber'],
                        'sourceAccount'             => $accuseSrc == 'internal' ? $value['branch'] . " - " . $value['cif'] . " - " . $value['suffix'] : $value['accountNumber'],
                        'dstExtNumber'              => "",
                        'namaSrc'                   => "",
                        'ccySrc'                    => "",
                        'tipeSrc'                   => $tipeSrc,
                        'accuseSrc'                 => $accuseSrc,
                        'nominalSrc'                => $value['amount'],
                        'txCodeName'                => "",
                        'status'                    => $value['rcMsg'][0]['messageDesc']
                    );
                }
            } else {
                $credit[] = array(
                    'branchDst'             => $json_string['data'][$key]['branch'],
                    'cifDst'                => $json_string['data'][$key]['cif'],
                    'suffixDst'             => $json_string['data'][$key]['suffix'],
                    'extDst'                => $json_string['data'][$key]['accountNumber'],
                    'destinationAccount'    => $request->accuseDst == 'internal' ? $json_string['data'][$key]['branch'] . " - " . $json_string['data'][$key]['cif'] . " - " . $json_string['data'][$key]['suffix'] : $json_string['data'][$key]['accountNumber'],
                    'namaDst'               => array_key_exists("accountName", $json_string['data'][$key]) ? $json_string['data'][$key]['accountName'] : "-",
                    'ccyDst'                => array_key_exists("currency", $json_string['data'][$key]) ? $json_string['data'][$key]['currency'] : "-",
                    'tipeDst'               => $request->tipeDst,
                    'accuseDst'             => $request->accuseDst,
                    'nominalDst'            => $json_string['data'][$key]['amount'],
                    'nominalDst_'           => $request->nominalDst_,
                    'txCodeName'            => $json_string['data'][$key]['txCodeName'],
                    'status'                => $json_string['data'][$key]['rcMsg']
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
        $data = new Transactions();
        $data->id = Str::uuid();
        $data->tipe_transaksi = 3;
        $data->reff = $request->reff;
        $data->tanggal = Carbon::now();
        $data->nominal = $request->nominal_total;
        $data->userid = auth()->user()->username;
        $data->branch = auth()->user()->profile->unit_kerja_kode;
        $data->status_override = 1;
        $data->status_transaksi = 1;

        foreach ($request->branchSrc as $key => $value) {
            $debit[] = array(
                'branchSrc'     => $request->branchSrc[$key],
                'cifSrc'        => $request->cifSrc[$key],
                'suffixSrc'     => $request->suffixSrc[$key],
                'extSrc'        => $request->extSrc[$key],
                'tipeSrc'       => $request->tipeSrc[$key],
                'namaSrc'       => $request->namaSrc[$key],
                'ccySrc'        => $request->ccySrc[$key],
                'nominalSrc'    => $request->nominalSrc[$key],
                'accuseSrc'     => $request->accuseSrc[$key]
            );
        }

        $credit[] = array(
            'branchDst'     => $request->branchDst,
            'cifDst'        => $request->cifDst,
            'suffixDst'     => $request->suffixDst,
            'extDst'        => $request->extDst,
            'tipeDst'       => $request->tipeDst,
            'namaDst'       => $request->namaDst,
            'ccyDst'        => $request->ccyDst,
            'nominalDst'    => $request->nominalDst,
            'accuseDst'     => $request->accuseDst
        );

        $data->additional_info = json_encode([
            'rekening_sumber'       => $debit,
            'rekening_tujuan'       => $credit,
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

        $message = ['key' => 'Pemindahbukuan Many To One Dengan Nomor Refference', 'value' => $request->reff];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if (auth()->user()->profile->is_transactions == true) {
            if ($data->save()) {
                $TransaksiSequence = new TransaksiSequence();
                $incrementSeq = $TransaksiSequence::increaseCounter();

                if ($incrementSeq == true) {
                    $status = 'success';
                    $response = trans('message.create_success', $message);
                } else {
                    $status = 'error';
                    $response = 'Terjadi kesalahan pada saat proses generate refference.';
                }
            }
        } else {
            $status = 'error';
            $response = 'Anda tidak punya akses untuk melakukan transaksi!';
        }

        return redirect('manytoone')->with($status, $response)->with('request', $request->all());
    }

    public function posting(Request $request)
    {
        $data = Transactions::findOrFail($request->id);
        $additional_info = json_decode($data->additional_info, true);
        // dd($data, $additional_info);exit;

        foreach ($additional_info['rekening_sumber'] as $key => $value) {
            $except = ['sourceAccount', 'namaSrc', 'txCodeName', 'status'];
            $result = array_diff_key($value, array_flip($except));

            foreach ($result as $property => $val) {
                $dataSrc[] = $property;

                foreach ($dataSrc as $dtaSrc => $nilai) {
                    if ($property == $dataSrc[$dtaSrc]) {
                        $Src[$nilai][] = $value[$nilai];
                    } else {
                        continue;
                    }

                    break;
                }

                $data->{$property} = $Src[$nilai];
            }
        }

        foreach ($additional_info['rekening_tujuan'] as $key => $value) {
            $except = ['destinationAccount', 'namaDst', 'txCodeName', 'status'];
            $result = array_diff_key($value, array_flip($except));

            foreach ($result as $property => $val) {
                $data->{$property} = $val;
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
            $resp = $AGIHelper->agivalpostMTO($data);
            // dd($respAgi, json_decode($respAgi, true));
            $del = array(
                'branchSrc',
                'cifSrc',
                'suffixSrc',
                'extSrc',
                'tipeSrc',
                'ccySrc',
                'nominalSrc',
                'accuseSrc',
                'branchDst',
                'cifDst',
                'suffixDst',
                'extDst',
                'tipeDst',
                'ccyDst',
                'nominalDst',
                'nominalDst_',
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
