<html>

<head>
    <style>
        .table {
            font-size: 12px;
            width: 100%;
        }

        .table-bordered {
            border: 1px solid black;
            border-collapse: collapse;
            font-family: "Times New Roman", Times, serif;
            /* margin-left: auto; */
            /* margin-right: auto; */
            
        }

        .table-bordered th {
            border: 1px solid black;
            border-collapse: collapse;
            background-color: lightgrey
        }

        .table-bordered td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .table-borderless {
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</head>

<body>
    <h5 style="text-align: center">LAPORAN TRANSAKSI PER OPERATOR<br>Per Tanggal: {{$request->startDate}} s.d {{$request->endDate}}</h5>

    <table class=" table table-borderless">
        <tr>
            <td style="width: 80px">Nama Kantor</td>
            <td>:</td>
            <td>{{$user->profile->unitKerja->nama}}</td>
        </tr>
        <tr>
            <td>User</td>
            <td>:</td>
            <td>{{$user->username}} | {{$user->profile->nip}} | {{$user->profile->nama}}</td>
        </tr>
        <!-- <tr>
            <td>Mata Uang</td>
            <td>:</td>
            <td>IDR - Rupiah</td>
        </tr> -->
        <tr>
            <td>Dicetak</td>
            <td>:</td>
            <td>Jam {{$printDate->toTimeString()}} Tgl. {{date('d-m-Y', strtotime($printDate->toDateString()))}}</td>
        </tr>
    </table>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr style="text-align: center">
                <th style="width: 10px">No.</th>
                <th style="width: 120px">Kode Reff</th>
                <th style="width: 120px">Nama Trx</th>
                <th style="width: 130px">Tanggal</th>
                <th style="width: 30px">Kode</th>
                <th style="width: 110px">Akun</th>
                <th>Nama Akun</th>
                <th style="width: 30px">Ccy</th>
                <th>User Kode</th>
                <th>Nominal</th>
                <th>Maker</th>
                <th>Approver</th>
                <th>Status Trx</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalDebet = [];
                $totalKredit = [];

                // Set nilai awal 0 untuk semua mata uang yang ada di daftar
                foreach ($currCodes as $code) {
                    $totalDebet[$code] = 0;
                    $totalKredit[$code] = 0;
                }
            @endphp
            @foreach($data as $key => $value)
            @php
                $currencyDebet = isset($value['addtInfo']['data']['sourceCurrency']) ? $value['addtInfo']['data']['sourceCurrency'] : 'IDR';
                $currencyKredit = $value['addtInfo']['data']['destinationCurrency'] ?? 'IDR';

                $trxType = $value['trxType'];
                $rawDebet = 0;
                $rawKredit = 0;

                if ($trxType === 'DC') {
                    $rawDebet = $value['addtInfo']['data']['drAmount'] ?? '0';
                    $rawKredit = $value['addtInfo']['data']['crAmount'] ?? '0';
                } else if($trxType === 'D') {
                    $rawDebet = $value['trxAmount'] ?? '0';
                } else if($trxType === 'C') {
                    $rawKredit = $value['trxAmount'] ?? '0';
                }

                $cleanDebet = floatval(str_replace(',', '', $rawDebet));
                $cleanKredit = floatval(str_replace(',', '', $rawKredit));

                if (in_array($currencyDebet, $currCodes)) {
                    $totalDebet[$currencyDebet] += $cleanDebet;
                }

                if (in_array($currencyKredit, $currCodes)) {
                    $totalKredit[$currencyKredit] += $cleanKredit;
                }
            @endphp
            <tr style="text-align: center">
                <td>{{ $key+1 }}.</td>
                <td>{{ $value['trxRef'] }}</td>
                <td>{{ $value['trxName'] }}</td>
                <td>{{ $value['trxDate'] }}</td>
                @if($value['trxType'] != 'DC')
                <td>{{ isset($value['addtInfo']['rc']) ? $value['addtInfo']['txCode'] : '-' }}</td>
                <td>{{ isset($value['addtInfo']['rc']) ? (isset($value['addtInfo']['accountNumber']) ? $value['addtInfo']['accountNumber'] : null).' | '.$value['addtInfo']['branch'].'-'.$value['addtInfo']['cif'].'-'.$value['addtInfo']['suffix'] : null }}</td>
                <td>{{ isset($value['addtInfo']['rc']) ? $value['addtInfo']['accountName'] : null }}</td>
                <td>{{ isset($value['addtInfo']['rc']) ? $value['addtInfo']['currency'] : null }}</td>
                <td>-</td>
                <td style="text-align: right">{{ number_format($value['trxAmount'],2) }} [<b>{{ $value['trxType'] }}</b>]</td>
                @else
                <td>{!! isset($value['addtInfo']['responseCode']) ? $value['addtInfo']['data']['drCode'].'<br>'.$value['addtInfo']['data']['crCode'] : '-' !!}</td>
                <!-- <td>{{ $value['trxSrcAcct'] }}<br>{{$value['trxDstAcct'] }}</td> -->
                <td>
                    {{ isset($value['addtInfo']['data']) ? (isset($value['addtInfo']['data']['sourceAccount']) ? $value['addtInfo']['data']['sourceAccount'] : null).' | '.$value['addtInfo']['data']['branchSrc'].'-'.$value['addtInfo']['data']['cifSrc'].'-'.$value['addtInfo']['data']['suffixSrc'] : null }}
                    <br>
                    {{ isset($value['addtInfo']['data']) ? (isset($value['addtInfo']['data']['destinationAccount']) ? $value['addtInfo']['data']['destinationAccount'] : null).' | '.$value['addtInfo']['data']['branchDst'].'-'.$value['addtInfo']['data']['cifDst'].'-'.$value['addtInfo']['data']['suffixDst'] : null }}
                </td>
                <td>{!! isset($value['addtInfo']['responseCode']) ? to_camel($value['addtInfo']['data']['sourceAccountName']).'<br>'.to_camel($value['addtInfo']['data']['destinationAccountName']) : null !!}</td>
                <td>{!! isset($value['addtInfo']['responseCode']) ? $value['addtInfo']['data']['sourceCurrency'].'<br>'.$value['addtInfo']['data']['destinationCurrency'] : null !!}</td>
                <td>{{ isset($value['addtInfo']['data']['userCode1']) ? $value['addtInfo']['data']['userCode1'] . ' - ' . (isset($value['addtInfo']['data']['userCode2']) ? $value['addtInfo']['data']['userCode2'] : '-') : '-' }}</td>
                <td style="text-align: right">{{ $value['addtInfo']['data']['drAmount'],2 }} [<b>D</b>]<br>{{ $value['addtInfo']['data']['crAmount'] }} [<b>C</b>]</td>
                @endif

                <td>{{ $value['createdBy'] }}</td>
                <td>{{ $value['overrideBy'] }}</td>
                <td>{{ $value['isSuccess'] == true ? 'Sukses' : 'Gagal' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>

    <table class="table table-borderless" style="width: 30%; background-color: lightgray">
        @foreach($currCodes as $code)
            @if($totalDebet[$code] > 0 || $totalKredit[$code] > 0)
            <tr>
                <td style="vertical-align: top; padding: 3px;">
                    <table class="table table-borderless" style="width: 100%; font-size: 15px;">
                        <tr>
                            <!-- Label Debet [D] -->
                            <td style="width: 100px;">Total {{ $code }} [<b>D</b>]</td>
                            <td style="width: 10px;">:</td>
                            <td style="font-weight: bold; text-align: right;">
                                {{ number_format($totalDebet[$code], in_array($code, ['IDR', 'JPY']) ? 0 : 2, '.', ',') }}
                            </td>
                        </tr>
                        <tr>
                            <!-- Label Kredit [C] -->
                            <td>Total {{ $code }} [<b>C</b>]</td>
                            <td>:</td>
                            <td style="font-weight: bold; text-align: right;">
                                {{ number_format($totalKredit[$code], in_array($code, ['IDR', 'JPY']) ? 0 : 2, '.', ',') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            @endif
        @endforeach

    </table>
    <table class="table table-borderless" style="width: 100%">
        <tr>
            <td style="text-align: center; height: 100px">Petugas</td>
            <td style="text-align: center; height: 100px">Supervisor / Manager Operasional</td>
        </tr>
        <tr>
            <td style="text-align: center">(...................................)</td>
            <td style="text-align: center">(...................................)</td>
        </tr>
    </table>
    </p< /body>

</html>