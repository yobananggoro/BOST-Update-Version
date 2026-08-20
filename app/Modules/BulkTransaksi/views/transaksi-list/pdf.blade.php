<html>

<head>
    <style>
        .table-bordered {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 12px;
            font-family: "Times New Roman", Times, serif;
            width: 100%;
        }
 
        .table-bordered th {
            border: 1px solid black;
            border-collapse: collapse;
            background-color: lightgrey
        }

        .table-bordered td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        .table-borderless {
            font-size: 12px;
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</head>

<body>
    <h5 style="text-align: center">LAPORAN TRANSAKSI BULK UPLOAD REFF [{{ $reff }}]</h5>
    <table class="table-borderless">
        <tr>
            <td style="width: 80px">Nama Kantor</td>
            <td>:</td>
            <td>{{$user->profile->unitKerja->nama}}</td>
        </tr>
        <tr>
            <td>Operator</td>
            <td>:</td>
            <td>{{$user->username}} | {{$user->profile->nip}} | {{$user->profile->nama}}</td>
        </tr>
        <tr>
            <td>Penyelia</td>
            <td>:</td>
            <td>{{$useroto == null ? '':$useroto->username}} | {{$useroto == null ? '':$useroto->profile->nip}} | {{$useroto == null ? '':$useroto->profile->nama}} </td>
        </tr>
        <tr>
            <td style="width: 80px">Modul Transaksi</td>
            <td>:</td>
            <td>{{$trxType}}</td>
        </tr>
        <tr>
            <td style="width: 80px">Tanggal Buat</td>
            <td>:</td>
            <td>{{$timecreate}}</td>
        </tr>
        <tr>
            <td style="width: 80px">Tanggal Approve</td>
            <td>:</td>
            <td>{{$timeoto}}</td>
        </tr>
        <tr>
            <td>Dokumen Dicetak</td>
            <td>:</td>
            <!-- <td>Jam {{$printDate->toTimeString()}} Tgl {{date('d-m-Y', strtotime($printDate->toDateString()))}}</td> -->
             <td>{{date('d-m-Y', strtotime($printDate->toDateString()))}} {{$printDate->toTimeString()}}</td>
        </tr>
    </table><br>

    <table class="table-bordered">
        <thead>
            <tr>
                <th style="width:10px">No.</th>
                <th style="width:40px">Kode Trx</th>
                <th style="width:70px">No Warkat</th>
                <th style="width:50px">Rekening</th>
                <th>Nama Akun</th>
                <th>Status Akun</th>
                <th>Nominal</th>
                <th>UserKode</th>
                <th>Status Posting</th>
                <th>Tanggal Posting</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $d)
            @php
            $postdt = null;
            preg_match('/^(\d{4}-\d{2}-\d{2})-(\d{2})\.(\d{2})\.(\d{2})\.(\d{6})$/', $d['postingDt'], $matches);
            if ($matches) {
            $tanggal = $matches[1]; // 2025-04-29
            $jam = $matches[2]; // 10
            $menit = $matches[3]; // 18
            $detik = $matches[4]; // 10

            $postdt = DateTime::createFromFormat('Y-m-d H:i:s', "$tanggal $jam:$menit:$detik");
            }
            @endphp
            <tr>
                @if($d['trxType'] != 'dc')
                <td>{{ $key+1 }}</td>
                <td>{{ $d['trxType'] == 'd' ? $d['trxCodeDebit'].' (D) ' : $d['trxCodeCredit'].' (C) '}}</td>
                <td>{{ $d['chequeNumber'] }}</td>
                <td>{{ $d['trxType'] == 'd' ? $d['srcAccountNumber'] : $d['dstAccountNumber'] }}</td>
                <td>{{ $d['accountName'] }}</td>
                <td>{{ $d['accountStatus'] }}</td>
                <td style="text-align: right">{{ number_format($d['trxAmount'],2) }}</td>
                <td>{{ $d['costCenter'] }}</td>
                <td>{{ $d['trxStatus'] }}</td>
                <td>{{ $postdt ? $postdt->format('d-m-Y H:i:s') : '-' }}</td>
                @else
                <td>{{ $key+1 }}</td>
                <td>{{ $d['trxCodeDebit'].' (D) '}}<br>{{$d['trxCodeCredit'].' (C) '}}</td>
                <td></td>
                <td>{{ $d['srcAccountNumber'] }}<br>{{ $d['dstAccountNumber'] }}</td>
                <td>{{ $d['accountName'] }}</td>
                <td>{{ $d['accountStatus'] }}</td>
                <td style="text-align: right">{{ number_format($d['trxAmount'],2) }}</td>
                <td>{{ $d['costCenter'] }}</td>
                <td>{{ $d['trxStatus'] }}</td>
                <td>{{ $postdt ? $postdt->format('d-m-Y H:i:s') : '-' }}</td>
                @endif
            </tr>
            @endforeach
            <tr>
                <td colspan="6" style="background-color: lightgrey; text-align: right">Sub Total Debit</td>
                <td style="background-color: lightgrey; text-align: right"><b>{{ number_format($amount, 2) }}</b></td>
            </tr>
            <tr>
                <td colspan="6" style="background-color: lightgrey; text-align: right">Sub Total Credit</td>
                <td style="background-color: lightgrey; text-align: right"><b>{{ number_format($amount, 2) }}</b></td>
            </tr>
        </tbody>
    </table>
    <table class="table-borderless" style="width: 100%">
        <tr>
            <td style="text-align: center; height: 100px">Petugas</td>
            <td style="text-align: center; height: 100px">Supervisor / Manager Operasional</td>
        </tr>
        <tr>
            <td style="text-align: center">(...................................)</td>
            <td style="text-align: center">(...................................)</td>
        </tr>
    </table>
</body>