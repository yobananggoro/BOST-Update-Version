<?php

namespace App\Http\Helper\BulkUpload;

use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Http\Helper\BostHelper;

class ExportExcel implements FromGenerator, WithHeadings
{
    use Exportable;

    protected $request;

    public function __construct($request)
    {
        // dd($request);
        $BostHelper = new BostHelper();
        $this->setToken = $BostHelper->getToken();

        $this->idTrx = $request->id;
        $this->typeTrx = $request->trxType;
    }

    public function generator(): \Generator
    {
        // dd($this->idTrx, $this->typeTrx);
        $page = 0;
        $perPage = 1000;
        $tokens = $this->setToken->accessToken;

        do {
            $url = config('app.backend_bo') . '/bulk/files/' . $this->idTrx . '?page=' . $page . '&size=' . $perPage;
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
            $data = $response->json()['data'] ?? [];

            // dd($data);
            if (empty($data)) {
                break;
            }

            // Yield per baris → langsung ditulis ke Excel
            foreach ($data as $index => $row) {
                if ($this->typeTrx == 'OTO') {
                    yield [
                        ($page * $perPage) + ($index + 1),
                        $row['trxCodeDebit'] . ' (D) - ' . $row['trxCodeCredit'] . ' (C)',
                        $row['chequeNumber'] ?? '',
                        $row['srcAccountNumber'] . ' - ' . $row['dstAccountNumber'],
                        $row['accountName'] ?? '',
                        $row['accountStatus'] ?? '',
                        $row['trxAmount'] ?? '',
                        $row['trxStatus '] ?? '',
                        $row['postingDt'] ?? '',
                        $row['costCenter'] ?? '',
                    ];
                } else {
                    yield [
                        ($page * $perPage) + ($index + 1),
                        $row['trxType'] == 'c' ? $row['trxCodeCredit'] . ' (C) ' : $row['trxCodeDebit'] . ' (D) ',
                        $row['chequeNumber'] ?? '',
                        $row['trxType'] == 'c' ? $row['dstAccountNumber'] : $row['srcAccountNumber'],
                        $row['accountName'] ?? '',
                        $row['accountStatus'] ?? '',
                        $row['trxAmount'] ?? '',
                        $row['trxStatus '] ?? '',
                        $row['postingDt'] ?? '',
                        $row['costCenter'] ?? '',
                    ];
                }
            }


            $page++;
        } while (count($data) === $perPage);
    }

    public function headings(): array
    {
        return ['No', 'Trx Code', 'Cheque No', 'Account', 'Account Name', 'Account Status', 'Amount', 'Posting Status', 'Posting Date', 'Usercode'];
    }
}
