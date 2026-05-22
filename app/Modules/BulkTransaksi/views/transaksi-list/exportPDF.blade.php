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
            <td>{{$user->profile->unitKerja->nama}}</td>
        </tr>
        <tr>
            <td>User</td>
            <td>:</td>
            <td>{{$user->username}} | {{$user->profile->nip}} | {{$user->profile->nama}}</td>
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
                <th style="width: 10px">No.</th>
                <th style="width: 120px">Kode Reff</th>
                <th style="width: 80px">Transaksi</th>
                <th style="width: 80px">Jenis Transaksi</th>
                <th>Nominal</th>
                <th style="width: 50px">Maker</th>
                <th style="width: 50px">Approval</th>
                <th style="width: 150px">Status</th>
                <th style="width: 120px">Tgl Buat</th>
                <th style="width: 120px">Tgl Approve</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $value)
            @php
            $totalDebet[] = $value['totalDebit'];
            $totalCredit[] = $value['totalCredit'];
            @endphp
            <tr style="text-align: center">
                <td>{{ $key+1 }}.</td>
                <td>{{ $value['reference'] }}</td>
                <td>{{ $value['bulkType'] }}</td>
                <td>{{ $value['trxName'] }}</td>
                <td style="text-align: right">{{ number_format($value['totalDebit']) }}</td>
                <td>{{ $value['createdBy'] }}</td>
                <td>{{ $value['updatedBy'] }}</td>
                <td>{{ str_replace('_', ' ', $value['status']) }}</td>
                <td>{{ $value['createdAt'] != null ? date('d-m-Y H:i:s', strtotime($value['createdAt'])) : '' }}</td>
                <td>{{ $value['approvedAt'] != null ? date('d-m-Y H:i:s', strtotime($value['approvedAt'])) : '' }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" style="background-color: lightgrey; text-align: right">Sub Total Debit</td>
                <td style="background-color: lightgrey; text-align: right; font-weight: bold">{{ number_format(array_sum($totalDebet)) }}</td>
            </tr>
            <tr>
                <td colspan="4" style="background-color: lightgrey; text-align: right">Sub Total Credit</td>
                <td style="background-color: lightgrey; text-align: right; font-weight: bold">{{ number_format(array_sum($totalCredit)) }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <!-- <table class="table-borderless" style="margin-left: 50px">
        <tr>
            <td style="width: 80px">Subtotal Debet</td>
            <td>:</td>
            <td style="font-weight: bold">Rp. {{ number_format(array_sum($totalDebet)) }}</td>
        </tr>
        <tr>
            <td>Subtotal Kredit</td>
            <td>:</td>
            <td style="font-weight: bold">Rp. {{ number_format(array_sum($totalCredit)) }}</td>
        </tr>
    </table> -->
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