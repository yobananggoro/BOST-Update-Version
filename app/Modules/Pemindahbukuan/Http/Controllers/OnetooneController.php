<?php

namespace Modules\Pemindahbukuan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use App\Entities\Token;
use App\Entities\ReffToken;
use App\Entities\TransactionSeq;
use App\Entities\Log;
use Modules\Pemindahbukuan\Entities\Transactions;
use Modules\Rekening\Entities\Rekening;
use Modules\Account\Entities\TipeRekening;
use App\Http\Helper\Pemindahbukuan\ITAHelper;
use App\Http\Helper\Transaksi\TransaksiSequence;

class OnetooneController extends \App\Http\Controllers\Controller
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
        $accuseDst = "internal";
        // dd($reff);

        \Assets::addJs('custom/apuppt.js');
        \Assets::addJs('custom/costcenter.js');
        \Assets::addJs('custom/prompt/prompt.js');
        \Assets::addJs('custom/pemindahbukuan/onetoone.js');
        return view('pemindahbukuan::onetoone.default', compact('rek', 'reff', 'accuseSrc', 'accuseDst'));
    }

    public function validasi(Request $request)
    {
        // dd($request);
        try {
            $ITAHelper = new ITAHelper();
            $resp = $ITAHelper->itaval($request);
            // dd($resp, json_decode($resp, true));

            if ($resp->status() == 200) {
                if ($resp['responseCode'] == '00') {
                    $data = $this->val($request, $resp);
                    // dd($data);

                    return view('pemindahbukuan::onetoone.validate', compact('data'));
                } else {
                    $res        = json_decode($resp, true);
                    $code       = $res['responseCode'];
                    $desc       = $res['data'][0]['message'];
                    // $desc       = $res['data'][0]['messageDesc'];
                    $status     = 'error';
                    $response   = $desc . ' | ' . $code;

                    return redirect('onetoone')->with($status, $response);
                }
            } else if ($resp->status() == 500) {
                $status     = 'error';
                $response   = 'Terjadi Gangguan Sistem!<br>' . $resp->status() . ' | ' . $resp->getReasonPhrase();

                return redirect('onetoone')->with($status, $response);
            } else if ($resp->status() == 400) {
                if (isset($resp['responseCode'])) {
                    if ($resp['responseCode'] == 401) {
                        $status     = 'error';
                        $response   = 'Terjadi Gangguan Sistem!<br>' . $resp['responseCode'] . ' | ' . $resp['responseDesc'];
                    }
                } else {
                    $status     = 'error';
                    $response   = $resp->status() . ' | ' . $resp['message'];
                }

                return redirect('onetoone')->with($status, $response);
            } else {
                $status     = 'error';
                $response   = 'Terjadi Gangguan Sistem!<br>' . $resp->status() . ' | ' . $resp->getReasonPhrase();

                return redirect('onetoone')->with($status, $response);
            }
            $status     = 'error';
            $response   = 'Terjadi Gangguan Sistem!<br>' . $resp->status() . ' | ' . $resp->getReasonPhrase();
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function val($request, $resp)
    {
        $json_string = json_decode($resp, true);
        $data = array([
            'branchSrc'                 => @$json_string['data']['branchSrc'],
            'cifSrc'                    => @$json_string['data']['cifSrc'],
            'suffixSrc'                 => @$json_string['data']['suffixSrc'],
            'extSrc'                    => @$json_string['data']['sourceAccount'],
            'sourceAccount'             => @$request->accuseSrc == 'internal' ? @$json_string['data']['branchSrc'] . " - " . @$json_string['data']['cifSrc'] . " - " . @$json_string['data']['suffixSrc'] : @$json_string['data']['sourceAccount'],
            'sourceAccountName'         => array_key_exists("sourceAccountName", @$json_string['data']) ? @$json_string['data']['sourceAccountName'] : "-",
            'ccySrc'                    => array_key_exists("sourceCurrency", @$json_string['data']) ? @$json_string['data']['sourceCurrency'] : "-",
            'tipeSrc'                   => @$request->tipeSrc,
            'accuseSrc'                 => @$request->accuseSrc,
            'codeSrc'                   => @$json_string['data']['drCode'],
            'amountSrc'                 => isset($json_string['data']['drAmount']) ? number_format((float) str_replace(',', '', $json_string['data']['drAmount']), 2, '.', '') : '0.00',

            'branchDst'                 => @$json_string['data']['branchDst'],
            'cifDst'                    => @$json_string['data']['cifDst'],
            'suffixDst'                 => @$json_string['data']['suffixDst'],
            'extDst'                    => @$json_string['data']['destinationAccount'],
            'destinationAccount'        => @$request->accuseDst == 'internal' ? @$json_string['data']['branchDst'] . " - " . @$json_string['data']['cifDst'] . " - " . @$json_string['data']['suffixDst'] : @$json_string['data']['destinationAccount'],
            'destinationAccountName'    => array_key_exists("destinationAccountName", @$json_string['data']) ? @$json_string['data']['destinationAccountName'] : "-",
            'ccyDst'                    => array_key_exists("destinationCurrency", @$json_string['data']) ? @$json_string['data']['destinationCurrency'] : "-",
            'tipeDst'                   => @$request->tipeDst,
            'accuseDst'                 => @$request->accuseDst,
            'codeDst'                   => @$json_string['data']['crCode'],
            'amountDst'                 => isset($json_string['data']['crAmount']) ? number_format((float) str_replace(',', '', $json_string['data']['crAmount']), 2, '.', '') : '0.00',

            'nominal_'                  => $request->nominal_,
            'nominal'                   => @$json_string['data']['amount'],
            'exchangeRate'              => $request->exchangeRate,
            'reff'                      => @$json_string['data']['ref'],
            'narative1'                 => array_key_exists("narrative1", @$json_string['data']) ? @$json_string['data']['narrative1'] : "",
            'narative2'                 => array_key_exists("narrative2", @$json_string['data']) ? @$json_string['data']['narrative2'] : "",
            'narative3'                 => array_key_exists("narrative3", @$json_string['data']) ? @$json_string['data']['narrative3'] : "",
            'narative4'                 => array_key_exists("narrative4", @$json_string['data']) ? @$json_string['data']['narrative4'] : "",

            'instrumentCode'            => $request->instrumentrx,
            'instrumentOther'           => $request->instrumentrx == '99' ? $request->instrumenLainnya : null,
            'classificationCode'        => $request->klasifikasitrx,
            'classificationOther'       => $request->klasifikasitrx == '99' ? $request->klasifikasiLainnya : null,
            'purposeCode'               => $request->kepentingantrx,
            'purposeOther'              => $request->kepentingantrx == '99' ? $request->kepentinganLainnya : null,
            'sourceCode'                => $request->sumberdanatrx,
            'sourceOther'               => $request->sumberdanatrx == '9' ? $request->sumberDanaLainnya : null,
            'destinationCode'           => $request->tujuantrx,
            'destinationOther'          => $request->tujuantrx == '9' ? $request->tujuanLainnya : null,
            'remark'                    => $request->beritaTrx,

            'userCode1'                 => $request->userCode1,
            'userCode2'                 => $request->userCode2,
            'json_validate'             => json_encode($json_string)
        ]);

        // dd($data);
        return $data;
    }

    public function store(Request $request)
    {
        // dd($request);
        $data = new Transactions();
        $data->id = Str::uuid();
        $data->tipe_transaksi = 1;
        $data->reff = $request->reff;
        $data->tanggal = Carbon::now();
        $data->nominal = $request->nominal;
        $data->userid = auth()->user()->username;
        $data->branch = auth()->user()->profile->unit_kerja_kode;
        $data->status_override = 1;
        $data->status_transaksi = 1;
        $data->response_validate = $request->json_validate;
        $debit[] = array(
            'seq_debit'     => 0,
            'branchSrc'     => $request->branchSrc,
            'cifSrc'        => $request->cifSrc,
            'suffixSrc'     => $request->suffixSrc,
            'extSrc'        => $request->extSrc,
            'tipeSrc'       => $request->tipeSrc,
            'namaSrc'       => $request->namaSrc,
            'ccySrc'        => $request->ccySrc,
            'accuseSrc'     => $request->accuseSrc,
            'codeSrc'       => $request->codeSrc,
            'nominalSrc'    => $request->nominalSrc,
        );

        $credit[] = array(
            'seq_credit'    => 0,
            'branchDst'     => $request->branchDst,
            'cifDst'        => $request->cifDst,
            'suffixDst'     => $request->suffixDst,
            'extDst'        => $request->extDst,
            'tipeDst'       => $request->tipeDst,
            'namaDst'       => $request->namaDst,
            'ccyDst'        => $request->ccyDst,
            'accuseDst'     => $request->accuseDst,
            'codeDst'       => $request->codeDst,
            'nominalDst'    => $request->nominalDst,
        );

        $data->additional_info = json_encode([
            'rekening_sumber'       => $debit,
            'rekening_tujuan'       => $credit,
            'exchangeRate'          => $request->exchangeRate,
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
            'exchangeRate'          => $request->exchangeRate,
            'userCode1'             => $request->userCode1,
            'userCode2'             => $request->userCode2,
        ]);

        // dd($data, $this->generateReff());
        $message = ['key' => 'Pemindahbukuan One To One Dengan Nomor Refference', 'value' => $request->reff];
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

            return redirect('onetoone')->with($status, $response)->with('request', $request->all());
        }

        return redirect('onetoone')->with($status, $response);
    }

    public function posting($request)
    {
        // dd($request);
        $data = Transactions::findOrFail($request->id);
        $additional_info = json_decode($data->additional_info, true);

        foreach ($additional_info['rekening_sumber'] as $key => $value) {
            $data->branchSrc = $value['branchSrc'];
            $data->cifSrc = $value['cifSrc'];
            $data->suffixSrc = $value['suffixSrc'];
            $data->ccySrc = $value['ccySrc'];
        }

        foreach ($additional_info['rekening_tujuan'] as $key => $value) {
            $data->branchDst = $value['branchDst'];
            $data->cifDst = $value['cifDst'];
            $data->suffixDst = $value['suffixDst'];
            $data->ccyDst = $value['ccyDst'];
        }

        $data->exchangeRate         = $additional_info['exchangeRate'];
        $data->narative1            = $additional_info['narative1'];
        $data->narative2            = $additional_info['narative2'];
        $data->narative3            = $additional_info['narative3'];
        $data->narative4            = $additional_info['narative4'];
        $data->userCode1            = $additional_info['userCode1'];
        $data->userCode2            = $additional_info['userCode2'];

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

        // dd($data, json_decode($data->response_validate, true));
        // Call api posting ITA
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
                $response = 'Nomor Reference ' . $request->reff . ' sudah pernah ditransaksikan!';

                return redirect()->back()->with($status, $response);
            }

            // Call api posting ITA
            $ITAHelper = new ITAHelper();
            $resp = $ITAHelper->itapost($data);
            // dd($resp, json_decode($resp, true));
            $del = array(
                'branchSrc',
                'cifSrc',
                'suffixSrc',
                'tipeSrc',
                'ccySrc',
                'branchDst',
                'cifDst',
                'suffixDst',
                'tipeDst',
                'ccyDst',
                'nominalDst',
                'exchangeRate',
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
                'userCode1',
                'userCode2',
            );

            // dd($resp->status(),$resp['responseCode'],$resp['data']['0']['messageDesc']);
            if ($resp->status() == 200) {
                foreach ($del as $key => $value) {
                    unset($data[$value]); //delete key yg tidak digunakan
                }

                if ($resp['responseCode'] == '00') {
                    $data->response_http = $resp->status();
                    $data->response_message = $resp;
                    // $data->status_transaksi = $resp['responseCode'] == '00' ? 2 : 3;
                    $data->status_transaksi = 2;
                    $data->status_override = 2;
                    $data->user_override = auth()->user()->username;
                    $data->save();

                    return true;
                } else {
                    $status     = 'warning';
                    $response   =  $resp->status() . ' | ' . $resp['data']['0']['message'];

                    $data->response_http = $resp->status();
                    $data->response_message = json_decode($resp, true);
                    $data->status_transaksi = 3;
                    $data->status_override = 2;
                    $data->user_override = auth()->user()->username;
                    $data->save();
                }
            } else if ($resp->status() == 409) {
                $status     = 'warning';
                $response   =  $resp->status() . ' | ' . $resp['responseDesc'];
            } else if ($resp->status() == 400) {
                $status     = 'warning';
                $response   =  $resp->status() . ' | ' . $resp['responseDesc'];
            } else {

                return false;
            }

            return redirect()->back()->with($status, $response);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}
