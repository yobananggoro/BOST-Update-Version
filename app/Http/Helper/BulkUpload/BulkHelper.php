<?php

namespace App\Http\Helper\BulkUpload;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use App\Entities\Token;
use App\Http\Helper\BostHelper;

class BulkHelper extends Controller
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

    public function bulkUploadAGI($request)
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/bulk/files/upload';

        $file               = request('file');
        $file_path          = $file->getPathname();
        $file_mime          = $file->getMimeType('image');
        $file_uploaded_name = $file->getClientOriginalName();

        // $nar = $request->narative3 . '|' . $request->narative4;
        $body = [
            [
                'name'        => 'file',
                'filename'    => $file_uploaded_name,
                'Mime-type'   => $file_mime,
                'contents'    => fopen($file_path, 'r'),
            ],
            [
                'name'        => 'reference',
                'contents'    => $request->reff,
            ],
            [
                'name'        => 'branch',
                'contents'    => auth()->user()->profile->unit_kerja_kode,
            ],
            [
                'name'        => 'createdBy',
                'contents'    => auth()->user()->username,
            ],
            [
                'name'        => 'bulkType',
                'contents'    => $request->trxtype,
            ],
            [
                'name'        => 'isExtAcc',
                'contents'    => $request->accuse == 'external' ? 'Y' : 'N',
            ],
            [
                'name'        => 'accountNumber',
                'contents'    => $request->accuse == 'external' ? $request->ext : $request->branch . $request->cif . $request->suffix,
            ],
            [
                'name'        => 'amount',
                'contents'    => $request->nominal,
            ],
            // [
            //     'name'        => 'narrative34',
            //     'contents'    => $nar,
            // ],
            [
                'name'        => 'nar1',
                'contents'    => '',
            ],
            [
                'name'        => 'nar2',
                'contents'    => '',
            ],
            [
                'name'        => 'nar3',
                'contents'    => $request->narative3,
            ],
            [
                'name'        => 'nar4',
                'contents'    => $request->narative4,
            ],
            [
                'name'        => 'trxName',
                'contents'    => $request->trxName,
            ],
            [
                'name'        => 'dbCode',
                'contents'    => $request->dbCode,
            ],
            [
                'name'        => 'crCode',
                'contents'    => $request->crCode,
            ],
        ];

        $message = array(
            'reference'     => $request->reff,
            'branch'        => auth()->user()->profile->unit_kerja_kode,
            'createdBy'     => auth()->user()->username,
            'bulkType'      => $request->trxtype,
            'isExtAcc'      => $request->accuse == 'external' ? 'Y' : 'N',
            'accountNumber' => $request->accuse == 'external' ? $request->ext : $request->branch . $request->cif . $request->suffix,
            'amount'        => $request->nominal,
            'filename'      => $file_uploaded_name,
            // 'narrative34'   => $nar,
            'nar1'          => '',
            'nar2'          => '',
            'nar3'          => $request->narative3,
            'nar4'          => $request->narative4,
            'trxName'       => $request->trxName,
            'dbCode'        => $request->dbCode,
            'crCode'        => $request->crCode
        );

        // **Tambahkan elemen hanya jika trxtype adalah 'OTM'**
        if ($request->trxtype == 'OTM') {
            $body[] = [
                'name'      => 'isCheque',
                'contents'  => $request->isCheque,
            ];
            $message['isCheque'] = $request->isCheque;

            if ($request->isCheque == 'Y') {
                $body[] = [
                    'name'      => 'chequeNo',
                    'contents'  => $request->chequeNo,
                ];
                $message['chequeNo'] = $request->chequeNo;
            }
        }

        // dd($message, $body);

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post($url, [
                'headers'    => ['Authorization' => 'Bearer ' . $tokens],
                'multipart'    => $body,
            ]);

            $msgRsp = $response->getBody()->getContents();
            Log::info("Upload BulkFile Request: " . json_encode($message));
            Log::info("Upload BulkFile Response: " . $msgRsp);
            // dd($response,$response->getBody(),$response->getBody()->getContents(),json_decode($response->getBody()->getContents(), true));

            return response()->json([
                'message'       => $msgRsp,
                'statusCode'    => $response->getStatusCode(),
            ], $response->getStatusCode());
        } catch (\Exception $e) {
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : null;
            // dd($e, $e->getRequest(),$e->getResponse(),$e->getMessage(),$statusCode);

            Log::error("Upload BulkFile Request: " . json_encode($message));
            Log::error("Upload BulkFile Response: " . $statusCode . '|' . $e->getMessage());

            if ($statusCode == 400) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'statusCode' => $statusCode,
                ], $statusCode);
            }
        }
    }

    public function bulkUploadAGIHO($request)
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/bulk/files/upload';

        $file               = request('file');
        $file_path          = $file->getPathname();
        $file_mime          = $file->getMimeType('image');
        $file_uploaded_name = $file->getClientOriginalName();

        $body = [
            [
                'name'        => 'file',
                'filename'    => $file_uploaded_name,
                'Mime-type'   => $file_mime,
                'contents'    => fopen($file_path, 'r'),
            ],
            [
                'name'        => 'reference',
                'contents'    => $request->reff,
            ],
            [
                'name'        => 'branch',
                'contents'    => auth()->user()->profile->unit_kerja_kode,
            ],
            [
                'name'        => 'createdBy',
                'contents'    => auth()->user()->username,
            ],
            [
                'name'        => 'bulkType',
                'contents'    => $request->trxtype,
            ],
            [
                'name'        => 'isExtAcc',
                'contents'    => $request->accuse == 'external' ? 'Y' : 'N',
            ],
            [
                'name'        => 'accountNumber',
                'contents'    => $request->accuse == 'external' ? $request->ext : $request->branch . $request->cif . $request->suffix,
            ],
            [
                'name'        => 'amount',
                'contents'    => $request->nominal,
            ],
            [
                'name'        => 'nar1',
                'contents'    => $request->narative1,
            ],
            [
                'name'        => 'nar2',
                'contents'    => $request->narative2,
            ],
            [
                'name'        => 'nar3',
                'contents'    => $request->narative3,
            ],
            [
                'name'        => 'nar4',
                'contents'    => $request->narative4,
            ],
            [
                'name'        => 'trxName',
                'contents'    => $request->trxName,
            ],
            [
                'name'        => 'dbCode',
                'contents'    => $request->dbCode,
            ],
            [
                'name'        => 'crCode',
                'contents'    => $request->crCode,
            ],
            [
                'name'        => 'isCheque',
                'contents'    => 'N',
            ],
            [
                'name'        => 'chequeNo',
                'contents'    => null,
            ],
        ];

        $message = array(
            'reference'     => $request->reff,
            'branch'        => auth()->user()->profile->unit_kerja_kode,
            'createdBy'     => auth()->user()->username,
            'bulkType'      => $request->trxtype,
            'isExtAcc'      => $request->accuse == 'external' ? 'Y' : 'N',
            'accountNumber' => $request->accuse == 'external' ? $request->ext : $request->branch . $request->cif . $request->suffix,
            'amount'        => $request->nominal,
            'filename'      => $file_uploaded_name,
            'nar1'          => $request->narative1,
            'nar2'          => $request->narative2,
            'nar3'          => $request->narative3,
            'nar4'          => $request->narative4,
            'trxName'       => $request->trxName,
            'dbCode'        => $request->dbCode,
            'crCode'        => $request->crCode
        );

        // dd($message, $body);

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post($url, [
                'headers'    => ['Authorization' => 'Bearer ' . $tokens],
                'multipart'    => $body,
            ]);

            $msgRsp = $response->getBody()->getContents();
            Log::info("Upload BulkFile Request: " . json_encode($message));
            Log::info("Upload BulkFile Response: " . $msgRsp);
            // dd($response,$response->getBody(),$response->getBody()->getContents(),json_decode($response->getBody()->getContents(), true));

            return response()->json([
                'message'       => $msgRsp,
                'statusCode'    => $response->getStatusCode(),
            ], $response->getStatusCode());
        } catch (\Exception $e) {
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : null;
            // dd($e, $e->getRequest(),$e->getResponse(),$e->getMessage(),$statusCode);

            Log::error("Upload BulkFile Request: " . json_encode($message));
            Log::error("Upload BulkFile Response: " . $statusCode . '|' . $e->getMessage());

            if ($statusCode == 400) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'statusCode' => $statusCode,
                ], $statusCode);
            }
        }
    }

    public function bulkUploadITA($request)
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/bulk/files/upload';

        $file               = request('file');
        $file_path          = $file->getPathname();
        $file_mime          = $file->getMimeType('image');
        $file_uploaded_name = $file->getClientOriginalName();

        $body = [
            [
                'name'        => 'file',
                'filename'    => $file_uploaded_name,
                'Mime-type'   => $file_mime,
                'contents'    => fopen($file_path, 'r'),
            ],
            [
                'name'        => 'reference',
                'contents'    => $request->reff,
            ],
            [
                'name'        => 'branch',
                'contents'    => auth()->user()->profile->unit_kerja_kode,
            ],
            [
                'name'        => 'createdBy',
                'contents'    => auth()->user()->username,
            ],
            [
                'name'        => 'bulkType',
                'contents'    => $request->trxtype,
            ],
            [
                'name'        => 'trxName',
                'contents'    => $request->trxName,
            ],
            [
                'name'        => 'dbCode',
                'contents'    => $request->dbCode,
            ],
            [
                'name'        => 'crCode',
                'contents'    => $request->crCode,
            ],
        ];

        $message = array(
            'reference'     => $request->reff,
            'branch'        => auth()->user()->profile->unit_kerja_kode,
            'createdBy'     => auth()->user()->username,
            'bulkType'      => $request->trxtype,
            'filename'      => $file_uploaded_name,
            'trxName'       => $request->trxName,
            'dbCode'        => $request->dbCode,
            'crCode'        => $request->crCode
        );
        // dd($request,$message);


        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post($url, [
                'headers'    => ['Authorization' => 'Bearer ' . $tokens],
                'multipart'    => $body,
            ]);

            $msgRsp = $response->getBody()->getContents();
            Log::info("Upload BulkFile Request: " . json_encode($message));
            Log::info("Upload BulkFile Response: " . $msgRsp);
            // dd($response,$response->getBody(),$response->getBody()->getContents(),json_decode($response->getBody()->getContents(), true));

            return response()->json([
                'message'       => $msgRsp,
                'statusCode'    => $response->getStatusCode(),
            ], $response->getStatusCode());
        } catch (\Exception $e) {
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : null;
            // dd($e, $e->getRequest(),$e->getResponse(),$e->getMessage(),$statusCode);

            Log::error("Upload BulkFile Request: " . json_encode($message));
            Log::error("Upload BulkFile Response: " . $statusCode . '|' . $e->getMessage());

            if ($statusCode == 400) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'statusCode' => $statusCode,
                ], $statusCode);
            }
        }
    }

    public function bulkUploadITAHO($request)
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/bulk/files/upload';

        $file               = request('file');
        $file_path          = $file->getPathname();
        $file_mime          = $file->getMimeType('image');
        $file_uploaded_name = $file->getClientOriginalName();

        $body = [
            [
                'name'        => 'file',
                'filename'    => $file_uploaded_name,
                'Mime-type'   => $file_mime,
                'contents'    => fopen($file_path, 'r'),
            ],
            [
                'name'        => 'reference',
                'contents'    => $request->reff,
            ],
            [
                'name'        => 'branch',
                'contents'    => auth()->user()->profile->unit_kerja_kode,
            ],
            [
                'name'        => 'createdBy',
                'contents'    => auth()->user()->username,
            ],
            [
                'name'        => 'bulkType',
                'contents'    => $request->trxtype,
            ],
            [
                'name'        => 'trxName',
                'contents'    => $request->trxName,
            ],
            [
                'name'        => 'dbCode',
                'contents'    => $request->dbCode,
            ],
            [
                'name'        => 'crCode',
                'contents'    => $request->crCode,
            ],
        ];

        $message = array(
            'reference'     => $request->reff,
            'branch'        => auth()->user()->profile->unit_kerja_kode,
            'createdBy'     => auth()->user()->username,
            'bulkType'      => $request->trxtype,
            'filename'      => $file_uploaded_name,
            'trxName'       => $request->trxName,
            'dbCode'        => $request->dbCode,
            'crCode'        => $request->crCode
        );
        // dd($request,$message);


        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post($url, [
                'headers'    => ['Authorization' => 'Bearer ' . $tokens],
                'multipart'    => $body,
            ]);

            $msgRsp = $response->getBody()->getContents();
            Log::info("Upload BulkFile Request: " . json_encode($message));
            Log::info("Upload BulkFile Response: " . $msgRsp);
            // dd($response,$response->getBody(),$response->getBody()->getContents(),json_decode($response->getBody()->getContents(), true));

            return response()->json([
                'message'       => $msgRsp,
                'statusCode'    => $response->getStatusCode(),
            ], $response->getStatusCode());
        } catch (\Exception $e) {
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : null;
            // dd($e, $e->getRequest(),$e->getResponse(),$e->getMessage(),$statusCode);

            Log::error("Upload BulkFile Request: " . json_encode($message));
            Log::error("Upload BulkFile Response: " . $statusCode . '|' . $e->getMessage());

            if ($statusCode == 400) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'statusCode' => $statusCode,
                ], $statusCode);
            }
        }
    }

    public function getListBulk($request)
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/bulk/files';
        $userID = $request->userid == null ? '' : $request->userid;

        // Format tanggal dari dd-MM-yyyy ke yyyy-MM-dd
        $startDate = \DateTime::createFromFormat('d-m-Y', $request->startDate);
        $endDate = \DateTime::createFromFormat('d-m-Y', $request->endDate);
        $formattedStartDate = $startDate ? $startDate->format('Y-m-d') : null;
        $formattedEndDate = $endDate ? $endDate->format('Y-m-d') : null;

        // dd($formattedStartDate, $formattedEndDate);

        $message = array(
            'userId'        => !in_array(auth()->user()->profile->rolename, ['Administrasi Dana Dan Jasa', 'Administrasi Kredit', 'Administrasi Operasional', 'Staf']) ? $userID : auth()->user()->username,
            'branch'        => auth()->user()->profile->rolename != "SUPER ADMIN" ? auth()->user()->profile->unit_kerja_kode : $request->branch,
            'fileStatus'    => $request->status_bulk == null ? '' : $request->status_bulk,
            'startDate'     => $formattedStartDate,
			'endDate'       => $formattedEndDate
        );

        // dd($message);

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->post($url, $message);
            Log::info("List Bulk Request: " . json_encode($message));
            // dd($response, json_decode($response, true));

            if ($response->status() == 200) {
                $respMsg = json_decode($response, true);

                Log::info("List Bulk Response: " . json_encode(array_diff_key($respMsg, ['data' => ''])));
            } else {
                Log::info("List Bulk Response: " . $response);
            }

            return $response;
        } catch (\Exception $e) {
            // echo $e->getMessage();
            Log::error("List Bulk Response: " . $e->getMessage());
            die();
        }
    }

    public function getListBulkOto($request)
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/bulk/files';
        $userID = $request->userid == null ? '' : $request->userid;

        $message = array(
            'userId'        => !in_array(auth()->user()->profile->rolename, ['Administrasi Dana Dan Jasa', 'Administrasi Kredit', 'Administrasi Operasional']) ? $userID : auth()->user()->username,
            'branch'        => auth()->user()->profile->rolename != "SUPER ADMIN" ? auth()->user()->profile->unit_kerja_kode : $request->branch,
            'fileStatus'    => auth()->user()->profile->rolename != "SUPER ADMIN" ? 'VERIFIED_AND_WAITING_APPROVAL' : ($request->status_bulk == null ? '' : $request->status_bulk)
        );

        // dd($message);

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->post($url, $message);
            Log::info("List Bulk Request: " . json_encode($message));
            // dd($response, json_decode($response, true));

            if ($response->status() == 200) {
                $respMsg = json_decode($response, true);

                Log::info("List Bulk Response: " . json_encode(array_diff_key($respMsg, ['data' => ''])));
            } else {
                Log::info("List Bulk Response: " . $response);
            }

            return $response;
        } catch (\Exception $e) {
            // echo $e->getMessage();
            Log::error("List Bulk Response: " . $e->getMessage());
            die();
        }
    }

    public function getDetailReport($request)
    {
        // dd($size);
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/bulk/files/' . $request->id;

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
            Log::info("List Detail Report Request: " . json_encode($url));
            // dd($response, json_decode($response, true));

            if ($response->status() == 200) {
                $respMsg = json_decode($response, true);

                Log::info("List Detail Report Response: " . json_encode(array_diff_key($respMsg, ['data' => ''])));
            } else {
                Log::info("List Detail Report Response: " . $response);
            }

            return $response;
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function getListDetail($request, $size)
    {
        // dd($size);
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/bulk/files/' . $request->id . '?page=' . $request->page . '&size=' . $size;
        // $url = config('app.backend_bo') . '/bulk/files/' . $id;

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
            Log::info("List Detail Request: " . json_encode($url));
            // dd($response, json_decode($response, true));

            if ($response->status() == 200) {
                $respMsg = json_decode($response, true);

                Log::info("List Detail Response: " . json_encode(array_diff_key($respMsg, ['data' => ''])));
            } else {
                Log::info("List Detail Response: " . $response);
            }

            return [$response, $request->page];
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function verifyBulk($request)
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/bulk/files/' . $request->id . '/verify';

        $message = array(
            'userId'        => auth()->user()->username,
            'branch'        => auth()->user()->profile->unit_kerja_kode,
            'fileStatus'    => "",
            'isCancel'      => $request->action == 'true' ? 'N' : 'Y'
        );

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->post($url, $message);
            Log::info("Verify Request: " . json_encode($message));
            Log::info("Verify Response: " . $response);
            // dd($response, json_decode($response, true));

            // if ($response->status() == 400) {
            //     if (isset($response['responseCode'])) {
            //         $this->BackEndHelper->auth();
            //         // return $this->verifyBulk($request);
            //     }
            // }

            return $response;
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function approveBulk($request)
    {
        $tokens = $this->setToken->accessToken;
        $url = config('app.backend_bo') . '/bulk/files/' . $request->idFile . '/approval';

        $message = array(
            'userId'        => "",
            'headUser'      => auth()->user()->username,
            'branch'        => auth()->user()->profile->unit_kerja_kode,
            'fileStatus'    => "",
            'isApprove'     => $request->subject == 'approve' ? 'Y' : 'N'
        );
        // dd($message,$url);
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->post($url, $message);
            Log::info("Approval Request: " . json_encode($message));
            Log::info("Approval Response: " . $response);
            // dd($response, json_decode($response, true));

            // if ($response->status() == 400) {
            //     if (isset($response['responseCode'])) {
            //         $this->BackEndHelper->auth();
            //         // return $this->approveBulk($request);
            //     }
            // }

            return $response;
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

}
