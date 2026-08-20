<html>

<head>
    <style>
        .table-bordered {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 12px;
            font-family: "Times New Roman", Times, serif;
            /* margin-left: auto; */
            /* margin-right: auto; */
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
        }

        .table-borderless {
            font-size: 12px;
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</head>

<body>
    <h5 style="text-align: center">LAPORAN TRANSAKSI BULK UPLOAD PER OPERATOR<br>Periode Tanggal: {{$request->startDate}} s.d {{$request->endDate}}</h5>

    <table class="table-borderless">
        <tr>
            <td style="width: 80px">Nama Kantor</td>
            <td>:</td>
            <td>{{$maker->profile->unitKerja->nama}}</td>
        </tr>
        <tr>
            <td>Operator</td>
            <td>:</td>
            <td>{{$maker->username}} | {{$maker->profile->nip}} | {{$maker->profile->nama}}</td>
        </tr>
        <tr>
            <td>Operator</td>
            <td>:</td>
            <td>{{$approver->username}} | {{$approver->profile->nip}} | {{$approver->profile->nama}}</td>
        </tr>
        <tr>
            <td>Dokumen Dicetak</td>
            <td>:</td>
            <!-- <td>Jam <b>{{$printDate->toTimeString()}}</b> Tgl. <b>{{date('d-m-Y', strtotime($printDate->toDateString()))}}</b></td> -->
            <td>{{date('d-m-Y', strtotime($printDate->toDateString()))}} {{$printDate->toTimeString()}}</td>
        </tr>
    </table>
    <br>
    <table class="table-bordered">
        <thead>
            <tr style="text-align: center">
                <th>No.</th>
                <th style="width:100px">Reff</th>
                <th style="width:80px">Bulk Type</th>
                <th style="width:150px">Jenis Trx</th>
                <th style="width:50px">Kode Trx</th>
                <th>Warkat</th>
                <th style="width:100px">No Akun</th>
                <th>Nama Akun</th>
                <th>Nominal</th>
                <th>Status Trx</th>
                <th>Tanggal Upload</th>
                <th>Tanggal Approve</th>
            </tr>
        </thead>
        <tbody>
            @if($data != '')
            @foreach($data as $key => $d)
            <tr style="text-align: center">
                <td>{{ $key+1 }}.</td>
                @if($d['trxType'] != 'dc')
                <td>{{ $d['fileReference'] }}</td>
                <td>{{ $d['fileBulkType'] }}</td>
                <td>{{ $d['fileTrxName'] }}</td>
                <td>{{ $d['trxType'] == 'd' ? $d['trxCodeDebit'].' (D) ' : $d['trxCodeCredit'].' (C) '}}</td>
                <td>{{ $d['chequeNumber'] }}</td>
                <td>{{ $d['trxType'] == 'd' ? $d['srcAccountNumber'] : $d['dstAccountNumber'] }}</td>
                <td>{{ $d['accountName'] }}</td>
                <td style="text-align: right">{{ number_format($d['trxAmount'],2) }}</td>
                <td>{{ $d['trxStatus'] }}</td>
                <td>{{ $d['fileCreatedAt'] != null ? date('d M Y H:i:s', strtotime($d['fileCreatedAt'])) : '' }}</td>
                <td>{{ $d['fileApprovedAt'] != null ? date('d M Y H:i:s', strtotime($d['fileApprovedAt'])) : '' }}</td>
                @else
                <td>{{ $d['fileReference'] }}</td>
                <td>{{ $d['fileBulkType'] }}</td>
                <td>{{ $d['fileTrxName'] }}</td>
                <td>{{ $d['trxCodeDebit'].' (D) '}}<br>{{$d['trxCodeCredit'].' (C) '}}</td>
                <td>{{ $d['chequeNumber'] }}</td>
                <td>{{ $d['srcAccountNumber'] }}<br>{{ $d['dstAccountNumber'] }}</td>
                <td>{{ $d['accountName'] }}</td>
                <td style="text-align: right">{{ number_format($d['trxAmount'],2) }}</td>
                <td>{{ $d['trxStatus'] }}</td>
                <td>{{ $d['fileCreatedAt'] != null ? date('d M Y H:i:s', strtotime($d['fileCreatedAt'])) : '' }}</td>
                <td>{{ $d['fileApprovedAt'] != null ? date('d M Y H:i:s', strtotime($d['fileApprovedAt'])) : '' }}</td>
                @endif
            </tr>
            @endforeach
            @endif
            <tr>
                <td colspan="7" style="background-color: lightgrey; text-align: right">Sub Total Debit</td>
                <td style="background-color: lightgrey; text-align: right; font-weight: bold">
                    @php
                    if(preg_match('/TOTAL_DEBIT:\s*(\d+)/', @$addtInfo, $matches))
                    {
                    $total_debit = (int) $matches[1];
                    echo number_format($total_debit, 0, '', '.');
                    }
                    @endphp
                </td>
            </tr>
            <tr>
                <td colspan="7" style="background-color: lightgrey; text-align: right">Sub Total Credit</td>
                <td style="background-color: lightgrey; text-align: right; font-weight: bold">
                    @php
                    if(preg_match('/TOTAL_CREDIT:\s*(\d+)/', @$addtInfo, $matches))
                    {
                    $total_credit = (int) $matches[1];
                    echo number_format($total_credit, 0, '', '.');
                    }
                    @endphp
                </td>
            </tr>
        </tbody>
    </table>
    <br>
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
    </p< /body>

</html>