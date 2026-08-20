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
        // $page = 0;
        // $perPage = 1000;
        $tokens = $this->setToken->accessToken;

        // do {
            // $url = config('app.backend_bo') . '/bulk/files/' . $this->idTrx . '?page=' . $page . '&size=' . $perPage;
            $url = config('app.backend_bo') . '/bulk/files/' . $this->idTrx;
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $tokens, 'Content-Type' => 'application/json',])->get($url);
            // $data = $response->json()['data'] ?? [];
            $data = collect($response->json()['data'] ?? [])
                ->sortBy('id')
                ->values()
                ->toArray();

            // dd($response->json()['data'], $data);
            // if (empty($data)) {
            //     break;
            // }

            // dd($data);

            // Yield per baris → langsung ditulis ke Excel
            foreach ($data as $index => $row) {
                if ($this->typeTrx == 'OTO') {
                    yield [
                        // ($page * $perPage) + ($index + 1),
                        ($index + 1),
                        $row['trxCodeDebit'] . ' (D) - ' . $row['trxCodeCredit'] . ' (C)',
                        $row['chequeNumber'] ?? '',
                        $row['srcAccountNumber'] . ' - ' . $row['dstAccountNumber'],
                        $row['accountName'] ?? '',
                        $row['accountStatus'] ?? '',
                        $row['trxAmount'] ?? '',
                        $row['nar1'] ?? '',
                        $row['nar2'] ?? '',
                        $row['nar3'] ?? '',
                        $row['nar4'] ?? '',
                        $row['nar5'] ?? '',
                        $row['nar6'] ?? '',
                        $row['nar7'] ?? '',
                        $row['nar8'] ?? '',
                        $row['trxStatus'] ?? '',
                        $row['postingDt'] ?? '',
                        $row['costCenter'] ?? '',
                    ];
                } else {
                    yield [
                        // ($page * $perPage) + ($index + 1),
                        ($index + 1),
                        $row['trxType'] == 'c' ? $row['trxCodeCredit'] . ' (C) ' : $row['trxCodeDebit'] . ' (D) ',
                        $row['chequeNumber'] ?? '',
                        $row['trxType'] == 'c' ? $row['dstAccountNumber'] : $row['srcAccountNumber'],
                        $row['accountName'] ?? '',
                        $row['accountStatus'] ?? '',
                        $row['trxAmount'] ?? '',
                        $row['trxType'] == 'd' ? $row['nar1'] : $row['nar5'],
                        $row['trxType'] == 'd' ? $row['nar2'] : $row['nar6'],
                        $row['trxType'] == 'd' ? $row['nar3'] : $row['nar7'],
                        $row['trxType'] == 'd' ? $row['nar4'] : $row['nar8'],
                        $row['trxStatus'] ?? '',
                        $row['postingDt'] ?? '',
                        $row['costCenter'] ?? '',
                    ];
                }
            }


        //     $page++;
        // } while (count($data) === $perPage);
    }

    public function headings(): array
    {
        if ($this->typeTrx == 'OTO') {
            return ['No', 'Trx Code', 'Cheque No', 'Account', 'Account Name', 'Account Status', 'Amount', 'NarDb1', 'NarDb2', 'NarDb3', 'NarDb4', 'NarCr1', 'NarCr2', 'NarCr3', 'NarCr4', 'Posting Status', 'Posting Date', 'Usercode'];
        } else {
            return ['No', 'Trx Code', 'Cheque No', 'Account', 'Account Name', 'Account Status', 'Amount', 'Nar1', 'Nar2', 'Nar3', 'Nar4', 'Posting Status', 'Posting Date', 'Usercode'];
        }
    }
}
