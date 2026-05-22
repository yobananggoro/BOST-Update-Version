<?php

namespace App\Http\Helper\Pemindahbukuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use App\Entities\Token;
use App\Http\Helper\BostHelper;

class AGIHelper extends Controller
{
    protected $clientId;
    protected $setToken;

    public function __construct()
    {
        $this->clientId = env('CLIENTID');
        $BostHelper = new BostHelper();
        $getToken = $BostHelper->getToken();

        $this->setToken = $getToken;
    }

    public function agivalOTM($request)
    {
        // $getToken = Token::FindToken($this->clientId)->first();
        // $this->BackEndHelper = new BostHelper();
        // if (is_null($getToken)) {
        //     $this->BackEndHelper->auth();
        // }

        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/transactions/transfer-interbank-agi';

        foreach ($request->branchDst as $key1 => $value) {
            $branchDst = $value;

            foreach ($request->cifDst as $key2 => $value) {
                if ($key1 === $key2) {
                    $cifDst = $value;
                }
            }
            foreach ($request->suffixDst as $key3 => $value) {
                if ($key1 === $key3) {
                    $suffixDst = $value;
                }
            }
            foreach ($request->nominalDst as $key4 => $value) {
                if ($key1 === $key4) {
                    $nominalDst = $value;
                }
            }
            foreach ($request->ccyDst as $key5 => $value) {
                if ($key1 === $key5) {
                    $ccyDst = $value;
                }
            }

            $credit[] = array(
                'branch'    => $branchDst,
                'cif'       => $cifDst,
                'suffix'    => $suffixDst,
                'amount'    => $nominalDst,
                'currency'  => $ccyDst
            );
        }

        $debit[] = array(
            'branch'        => $request->branchSrc,
            'cif'           => $request->cifSrc,
            'suffix'        => $request->suffixSrc,
            'amount'        => $request->nominalSrc,
            'currency'      => $request->ccySrc
        );

        $addInfo = array(
            'instrumentCode'        => $request->instrumentrx,
            'instrumentOther'       => $request->instrumentOther,
            'classificationCode'    => $request->klasifikasitrx,
            'classificationOther'   => $request->klasifikasiLainnya,
            'purposeCode'           => $request->kepentingantrx,
            'purposeOther'          => $request->kepentinganLainnya,
            'sourceCode'            => $request->sumberdanatrx,
            'sourceOther'           => $request->sumberDanaLainnya,
            'destinationCode'       => $request->tujuantrx,
            'destinationOther'      => $request->tujuanLainnya,
            'remark'                => $request->beritaTrx,
        );

        $message = array(
            'debits'        => $debit,
            'credits'       => $credit,
            'isValidate'    => "Y",
            'ref'           => $request->reff,
            'userId'        => auth()->user()->username,
            'branchUser'    => auth()->user()->profile->unit_kerja_kode,
            'narrative1'    => $request->narative1,
            'narrative2'    => $request->narative2,
            'narrative3'    => $request->narative3,
            'narrative4'    => $request->narative4,
            'trxInfoReq'    => $addInfo
        );

        try {

            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->post($url, $message);
            Log::info("ASI Validation Request: " . json_encode($message));
            Log::info("ASI Validation Response: " . $response);
            // dd($response->status(), $response->getBody()->getContents(), json_decode($response, true)); 

            if ($response->status() == 400) {
                $this->BackEndHelper->auth();
                return $this->agivalOTM($request);
            }

            return $response;
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function agivalMTO($request)
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/transactions/transfer-interbank-agi';

        foreach ($request->branchSrc as $key1 => $value) {
            $branchSrc = $value;

            foreach ($request->cifSrc as $key2 => $value) {
                if ($key1 === $key2) {
                    $cifSrc = $value;
                }
            }
            foreach ($request->suffixSrc as $key3 => $value) {
                if ($key1 === $key3) {
                    $suffixSrc = $value;
                }
            }
            foreach ($request->nominalSrc as $key4 => $value) {
                if ($key1 === $key4) {
                    $nominalSrc = $value;
                }
            }
            foreach ($request->ccySrc as $key5 => $value) {
                if ($key1 === $key5) {
                    $ccySrc = $value;
                }
            }

            $debit[] = array(
                'branch'    => $branchSrc,
                'cif'       => $cifSrc,
                'suffix'    => $suffixSrc,
                'amount'    => $nominalSrc,
                'currency'  => $ccySrc
            );
        }

        $credit[] = array(
            'branch'        => $request->branchDst,
            'cif'           => $request->cifDst,
            'suffix'        => $request->suffixDst,
            'amount'        => $request->nominalDst,
            'currency'      => $request->ccyDst
        );

        $addInfo = array(
            'instrumentCode'        => $request->instrumentrx,
            'instrumentOther'       => $request->instrumentOther,
            'classificationCode'    => $request->klasifikasitrx,
            'classificationOther'   => $request->klasifikasiLainnya,
            'purposeCode'           => $request->kepentingantrx,
            'purposeOther'          => $request->kepentinganLainnya,
            'sourceCode'            => $request->sumberdanatrx,
            'sourceOther'           => $request->sumberDanaLainnya,
            'destinationCode'       => $request->tujuantrx,
            'destinationOther'      => $request->tujuanLainnya,
            'remark'                => $request->beritaTrx,
        );

        $message = array(
            'debits'        => $debit,
            'credits'       => $credit,
            'isValidate'    => "Y",
            'ref'           => $request->reff,
            'userId'        => auth()->user()->username,
            'branchUser'    => auth()->user()->profile->unit_kerja_kode,
            'narrative1'    => $request->narative1,
            'narrative2'    => $request->narative2,
            'narrative3'    => $request->narative3,
            'narrative4'    => $request->narative4,
            'trxInfoReq'    => $addInfo
        );

        // dd($message);
        try {

            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->post($url, $message);
            Log::info("ASI Validation Request: " . json_encode($message));
            Log::info("ASI Validation Response: " . $response);
            // dd($response->status(), $response->getBody()->getContents(), json_decode($response, true));

            if ($response->status() == 400) {
                $this->BackEndHelper->auth();
                return $this->agivalMTO($request);
            }

            return $response;
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function agivalpostOTM($request) //special condition
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/transactions/transfer-interbank-agi';

        foreach ($request->branchDst as $key1 => $value) {
            $branchDst = $value;

            foreach ($request->cifDst as $key2 => $value) {
                if ($key1 === $key2) {
                    $cifDst = $value;
                }
            }
            foreach ($request->suffixDst as $key3 => $value) {
                if ($key1 === $key3) {
                    $suffixDst = $value;
                }
            }
            foreach ($request->nominalDst as $key4 => $value) {
                if ($key1 === $key4) {
                    $nominalDst = $value;
                }
            }
            foreach ($request->ccyDst as $key5 => $value) {
                if ($key1 === $key5) {
                    $ccyDst = $value;
                }
            }

            $credit[] = array(
                'branch'    => $branchDst,
                'cif'       => $cifDst,
                'suffix'    => $suffixDst,
                'amount'    => $nominalDst,
                'currency'  => $ccyDst
            );
        }

        $debit[] = array(
            'branch'        => $request->branchSrc,
            'cif'           => $request->cifSrc,
            'suffix'        => $request->suffixSrc,
            'amount'        => $request->nominal,
            'currency'      => $request->ccySrc
        );

        $addInfo = array(
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
        );

        $message = array(
            'debits'        => $debit,
            'credits'       => $credit,
            'isValidate'    => "Y",
            'ref'           => $request->reff,
            'userId'        => $request->userid,
            'headUser'      => auth()->user()->username,
            'branchUser'    => auth()->user()->profile->unit_kerja_kode,
            'narrative1'    => $request->narative1,
            'narrative2'    => $request->narative2,
            'narrative3'    => $request->narative3,
            'narrative4'    => $request->narative4,
            'trxInfoReq'    => $addInfo
        );

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->post($url, $message);
            Log::info("ASI Validation Request: " . json_encode($message));
            Log::info("ASI Validation Response: " . $response);
            // dd($response, $response->getBody()->getContents(), json_decode($response, true));

            if ($response->status() == 200) {
                if ($response['responseCode'] == '00') {
                    $response = $this->agipostOTM($request);
                }

                return $response;
            } else if ($response->status() == 400) {
                $this->BackEndHelper->auth();
                return $this->agivalpostOTM($request);
            } else {
                return $response;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function agivalpostMTO($request) //special condition
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/transactions/transfer-interbank-agi';

        foreach ($request->branchSrc as $key1 => $value) {
            $branchSrc = $value;

            foreach ($request->cifSrc as $key2 => $value) {
                if ($key1 === $key2) {
                    $cifSrc = $value;
                }
            }
            foreach ($request->suffixSrc as $key3 => $value) {
                if ($key1 === $key3) {
                    $suffixSrc = $value;
                }
            }
            foreach ($request->nominalSrc as $key4 => $value) {
                if ($key1 === $key4) {
                    $nominalSrc = $value;
                }
            }
            foreach ($request->ccySrc as $key5 => $value) {
                if ($key1 === $key5) {
                    $ccySrc = $value;
                }
            }

            $debit[] = array(
                'branch'    => $branchSrc,
                'cif'       => $cifSrc,
                'suffix'    => $suffixSrc,
                'amount'    => $nominalSrc,
                'currency'  => $ccySrc
            );
        }

        $credit[] = array(
            'branch'        => $request->branchDst,
            'cif'           => $request->cifDst,
            'suffix'        => $request->suffixDst,
            'amount'        => $request->nominal,
            'currency'      => $request->ccyDst
        );

        $addInfo = array(
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
        );

        $message = array(
            'debits'        => $debit,
            'credits'       => $credit,
            'isValidate'    => "Y",
            'ref'           => $request->reff,
            'userId'        => $request->userid,
            'headUser'      => auth()->user()->username,
            'branchUser'    => auth()->user()->profile->unit_kerja_kode,
            'narrative1'    => $request->narative1,
            'narrative2'    => $request->narative2,
            'narrative3'    => $request->narative3,
            'narrative4'    => $request->narative4,
            'trxInfoReq'    => $addInfo
        );

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->post($url, $message);
            Log::info("ASI Validation Request: " . json_encode($message));
            Log::info("ASI Validation Response: " . $response);
            // dd($response, $response->getBody()->getContents(), json_decode($response, true));

            if ($response->status() == 200) {
                if ($response['responseCode'] == '00') {
                    $response = $this->agipostMTO($request);
                }

                return $response;
            } else if ($response->status() == 400) {
                $this->BackEndHelper->auth();
                return $this->agivalpostMTO($request);
            } else {
                return $response;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function agipostOTM($request)
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/transactions/transfer-interbank-agi';

        foreach ($request->branchDst as $key1 => $value) {
            $branchDst = $value;

            foreach ($request->cifDst as $key2 => $value) {
                if ($key1 === $key2) {
                    $cifDst = $value;
                }
            }
            foreach ($request->suffixDst as $key3 => $value) {
                if ($key1 === $key3) {
                    $suffixDst = $value;
                }
            }
            foreach ($request->nominalDst as $key4 => $value) {
                if ($key1 === $key4) {
                    $nominalDst = $value;
                }
            }
            foreach ($request->ccyDst as $key5 => $value) {
                if ($key1 === $key5) {
                    $ccyDst = $value;
                }
            }

            $credit[] = array(
                'branch'    => $branchDst,
                'cif'       => $cifDst,
                'suffix'    => $suffixDst,
                'amount'    => $nominalDst,
                'currency'  => $ccyDst
            );
        }

        $debit[] = array(
            'branch'        => $request->branchSrc,
            'cif'           => $request->cifSrc,
            'suffix'        => $request->suffixSrc,
            'amount'        => $request->nominal,
            'currency'      => $request->ccySrc
        );

        $addInfo = array(
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
        );

        $message = array(
            'debits'        => $debit,
            'credits'       => $credit,
            'isValidate'    => "N",
            'ref'           => $request->reff,
            'userId'        => $request->userid,
            'headUser'      => auth()->user()->username,
            'branchUser'    => auth()->user()->profile->unit_kerja_kode,
            'narrative1'    => $request->narative1,
            'narrative2'    => $request->narative2,
            'narrative3'    => $request->narative3,
            'narrative4'    => $request->narative4,
            'trxInfoReq'    => $addInfo
        );

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->post($url, $message);
            Log::info("ASI Posting Request: " . json_encode($message));
            Log::info("ASI Posting Response: " . $response);
            // dd($response->getBody()->getContents(), json_decode($response, true)); 

            if ($response->status() == 400) {
                $this->BackEndHelper->auth();
                return $this->agipostOTM($request);
            }

            return $response;
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function agipostMTO($request)
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/transactions/transfer-interbank-agi';

        foreach ($request->branchSrc as $key1 => $value) {
            $branchSrc = $value;

            foreach ($request->cifSrc as $key2 => $value) {
                if ($key1 === $key2) {
                    $cifSrc = $value;
                }
            }
            foreach ($request->suffixSrc as $key3 => $value) {
                if ($key1 === $key3) {
                    $suffixSrc = $value;
                }
            }
            foreach ($request->nominalSrc as $key4 => $value) {
                if ($key1 === $key4) {
                    $nominalSrc = $value;
                }
            }
            foreach ($request->ccySrc as $key5 => $value) {
                if ($key1 === $key5) {
                    $ccySrc = $value;
                }
            }

            $debit[] = array(
                'branch'    => $branchSrc,
                'cif'       => $cifSrc,
                'suffix'    => $suffixSrc,
                'amount'    => $nominalSrc,
                'currency'  => $ccySrc
            );
        }

        $credit[] = array(
            'branch'        => $request->branchDst,
            'cif'           => $request->cifDst,
            'suffix'        => $request->suffixDst,
            'amount'        => $request->nominal,
            'currency'      => $request->ccyDst
        );

        $addInfo = array(
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
        );

        $message = array(
            'debits'        => $debit,
            'credits'       => $credit,
            'isValidate'    => "N",
            'ref'           => $request->reff,
            'userId'        => $request->userid,
            'headUser'      => auth()->user()->username,
            'branchUser'    => auth()->user()->profile->unit_kerja_kode,
            'narrative1'    => $request->narative1,
            'narrative2'    => $request->narative2,
            'narrative3'    => $request->narative3,
            'narrative4'    => $request->narative4,
            'trxInfoReq'    => $addInfo
        );

        // dd($message);exit;
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json'])->post($url, $message);
            Log::info("ASI Posting Request: " . json_encode($message));
            Log::info("ASI Posting Response: " . $response);
            // dd($response->getBody()->getContents(), json_decode($response, true)); 

            if ($response->status() == 400) {
                $this->BackEndHelper->auth();
                // return $this->agipostMTO($request);
            }

            return $response;
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}
