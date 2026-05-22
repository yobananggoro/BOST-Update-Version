@extends('layouts.app')
@section('title', 'Report Transaksi')
@section('content')
@include('pemindahbukuan::report-transaksi.filter')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header border-0">
                <div class="float-right" id="searchContainer"></div>
            </div>
            <div class="card-body table-responsive" style="overflow-y: scroll">
                <table id="tableReport" class="table table-striped" style="width: 150%">
                    <thead>
                        <tr style="text-align: center">
                            <th style="width: 10px">No.</th>
                            <th style="width: 110px">Reff Code</th>
                            <th style="width: 120px">Trx Name</th>
                            <th style="width: 130px">Time Stamps</th>
                            <th style="width: 50px">Trans</th>
                            <th>Account</th>
                            <th>Short Name</th>
                            <th style="width: 30px">Ccy</th>
                            <th>Posting Amount</th>
                            <th>User ID</th>
                            <th>User Oto</th>
                            <th>Status Trx</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($data != '')
                        @foreach($data as $key => $value)
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
                            @if($value['addtInfo']['responseCode'] == '00')
                            <td>{!! isset($value['addtInfo']['responseCode']) ? $value['addtInfo']['data']['drCode'].'<br>'.$value['addtInfo']['data']['crCode'] : '-' !!}</td>
                            <td>{{ $value['trxSrcAcct'] }}<br>{{$value['trxDstAcct'] }}</td>
                            <td>{!! isset($value['addtInfo']['responseCode']) ? to_camel($value['addtInfo']['data']['sourceAccountName']).'<br>'.to_camel($value['addtInfo']['data']['destinationAccountName']) : null !!}</td>
                            <td>{!! isset($value['addtInfo']['responseCode']) ? $value['addtInfo']['data']['sourceCurrency'].'<br>'.$value['addtInfo']['data']['destinationCurrency'] : null !!}</td>
                            @else
                            <td>-</td>
                            <td>{{ $value['trxSrcAcct'] }}<br>{{$value['trxDstAcct'] }}</td>
                            </td>
                            <td>-</td>
                            <td>-</td>
                            @endif
                            @endif

                            <td style="text-align: right">{{ number_format($value['trxAmount']) }} [<b>{{ $value['trxType'] }}</b>]</td>
                            <td>{{ $value['createdBy'] }}</td>
                            <td>{{ $value['overrideBy'] }}</td>
                            <td>{{ $value['isSuccess'] == true ? 'Sukses' : 'Gagal' }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="float-right" id="pagingContainer"></div>
            </div>
        </div>
    </div>
    @endsection