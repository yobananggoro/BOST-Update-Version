<html>
<head>
    <style>
        .table-bordered{
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 12px;
            font-family: "Times New Roman", Times, serif;
            /* margin-left: auto; */
            /* margin-right: auto; */
            width: 100%;
        } 
        .table-bordered th{
            border: 1px solid black;
            border-collapse: collapse;
            background-color: lightgrey
        }
        .table-bordered td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        
        .table-borderless{
            font-size: 12px;
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</head>
<body>
    <h5 style="text-align: center">LAPORAN TRANSAKSI PER OPERATOR<br>Per Tanggal: {{$request->startDate}} s.d {{$request->endDate}}</h5>
    
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
            <td>Mata Uang</td>
            <td>:</td>
            <td>IDR - Rupiah</td>
        </tr>
        <tr>
            <td>Dicetak</td>
            <td>:</td>
            <td>Jam {{$printDate->toTimeString()}} Tgl. {{date('d-m-Y', strtotime($printDate->toDateString()))}}</td>
        </tr>
    </table>
    <br>
    <table class="table-bordered">
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
                <th>Nominal</th>
                <th>User ID</th>
                <th>User Oto</th>
                <th>Usercode</th>
                <th>Status Trx</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $value)
            @php
            if($value['trxType'] == 'D'){
                $totalDebet[] = $value['trxAmount'];
            }
            
            if($value['trxType'] == 'C'){
                $totalCredit[] = $value['trxAmount'];
            }
            
            if($value['trxType'] == 'DC'){
                $totalDebet[] = $value['trxAmount'];
                $totalCredit[] = $value['trxAmount'];
            }
            @endphp
            <tr style="text-align: center">
                <td>{{ $key+1 }}.</td>
                <td>{{ $value['trxRef'] }}</td>
                <td>{{ $value['trxName'] }}</td>
                <td>{{ $value['trxDate'] }}</td>
                @if($value['trxType'] != 'DC')
                    <td>{{ isset($value['addtInfo']['rc']) ? $value['addtInfo']['txCode'] : '-' }}</td>
                    <td>{{ isset($value['addtInfo']['rc']) ? $value['addtInfo']['branch'].'-'.$value['addtInfo']['cif'].'-'.$value['addtInfo']['suffix'] : null }}</td>
                    <td>{{ isset($value['addtInfo']['rc']) ? $value['addtInfo']['accountName'] : null }}</td>
                    <td>{{ isset($value['addtInfo']['rc']) ? $value['addtInfo']['currency'] : null }}</td> 
                @else
                    <td>{!! isset($value['addtInfo']['responseCode']) ? $value['addtInfo']['data']['drCode'].'<br>'.$value['addtInfo']['data']['crCode'] : '-' !!}</td>
                    <td>{{ $value['trxSrcAcct'] }}<br>{{$value['trxDstAcct'] }}</td>
                    <td>{!! isset($value['addtInfo']['responseCode']) ? to_camel($value['addtInfo']['data']['sourceAccountName']).'<br>'.to_camel($value['addtInfo']['data']['destinationAccountName']) : null !!}</td>
                    <td>{!! isset($value['addtInfo']['responseCode']) ? $value['addtInfo']['data']['sourceCurrency'].'<br>'.$value['addtInfo']['data']['destinationCurrency']  : null !!}</td>
                @endif
                <td style="text-align: right">{{ number_format($value['trxAmount']) }} [<b>{{ $value['trxType'] }}</b>]</td>
                <td>{{ $value['createdBy'] }}</td>
                <td>{{ $value['overrideBy'] }}</td>
                <td>{{ $value['addtInfo']['data']['userCode1'] }} - {{ $value['addtInfo']['data']['userCode2'] }}</td>
                <td>{{ $value['isSuccess'] == true ? 'Sukses' : 'Gagal' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <table class="table-borderless" style="margin-left: 50px">
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
</p</body>
</html>