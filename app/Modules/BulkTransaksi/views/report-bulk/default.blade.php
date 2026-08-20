@extends('layouts.app')
@section('title', 'Report Transaksi Bulk')
@section('content')
@include('bulktransaksi::report-bulk.filter')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header border-0">
                <div class="float-right" id="searchContainer_report"></div>
                <table class="float-left" cellspacing="0" cellpadding="0" style="font-weight: bold; font-size: 15px">
                    <tbody>
                        <tr>
                            <td style="width: 150px; text-align: left">Operator</td>
                            <td style="width: 15px; text-align: left">:</td>
                            <td style="width: 180px; text-align: left">{{$request->createdBy}}</td>
                        </tr>
                        <tr>
                            <td style="width: 150px; text-align: left">Penyelia</td>
                            <td style="width: 15px; text-align: left">:</td>
                            <td style="width: 180px; text-align: left">{{auth()->user()->profile->rolename != "SUPER ADMIN" ? auth()->user()->username : $request->updatedBy}}</td>
                        </tr>
                        <tr>
                            <td style="width: 150px; text-align: left">Sukses Posting</td>
                            <td style="width: 15px; text-align: left">:</td>
                            <td style="width: 180px; text-align: left">
                                @php
                                if(preg_match('/SUCCESS:\s*(\d+)/', @$addtInfo, $matches))
                                {
                                $success = (int) $matches[1];
                                echo number_format($success, 0, '', '.');
                                }
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px; text-align: left">Gagal Posting</td>
                            <td style="width: 15px; text-align: left">:</td>
                            <td style="width: 180px; text-align: left">
                                @php
                                if(preg_match('/FAILED:\s*(\d+)/', @$addtInfo, $matches))
                                {
                                $failed = (int) $matches[1];
                                echo number_format($failed, 0, '', '.');
                                }
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left">Total Debit</td>
                            <td style="text-align: left">:</td>
                            <td style="text-align: left">
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
                            <td style="text-align: left">Total Credit</td>
                            <td style="text-align: left">:</td>
                            <td style="text-align: left">
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
            </div>
            <div class="card-body table-responsive" style="max-height: 650px; overflow-y: scroll">
                <table id="dataTableReportBulk" class="table table-striped" style="width: 150%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th style="width:10px">Reff</th>
                            <th style="width:100px">Bulk Type</th>
                            <th>Jenis Trx</th>
                            <th style="width:100px">Kode Trx</th>
                            <th>Warkat</th>
                            <th>No Akun</th>
                            <th>Nama Akun</th>
                            <th>Nominal</th>
                            <th style="width:100px">Status Trx</th>
                            <th>Tanggal Upload</th>
                            <th>Tanggal Approve</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($data != '')
                            @foreach($data as $key => $d)
                            <tr>
                                <td>{{ $key+1 }}.</td>
                                @if($d['trxType'] != 'dc')
                                <td>{{ $d['fileReference'] }}</td>
                                <td>{{ $d['fileBulkType'] }}</td>
                                <td>{{ $d['fileTrxName'] }}</td>
                                <td>{{ $d['trxType'] == 'd' ? $d['trxCodeDebit'].' (D) ' : $d['trxCodeCredit'].' (C) '}}</td>
                                <td>{{ $d['chequeNumber'] }}</td>
                                <td>{{ $d['trxType'] == 'd' ? $d['srcAccountNumber'] : $d['dstAccountNumber'] }}</td>
                                <td>{{ $d['accountName'] }}</td>
                                <td class="text-right">{{ number_format($d['trxAmount'],2) }}</td>
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
                                <td class="text-right">{{ number_format($d['trxAmount'],2) }}</td>
                                <td>{{ $d['trxStatus'] }}</td>
                                <td>{{ $d['fileCreatedAt'] != null ? date('d M Y H:i:s', strtotime($d['fileCreatedAt'])) : '' }}</td>
                                <td>{{ $d['fileApprovedAt'] != null ? date('d M Y H:i:s', strtotime($d['fileApprovedAt'])) : '' }}</td>
                                @endif
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="float-right" id="pagingContainer_listreport"></div>
            </div>
        </div>
    </div>
</div>
@endsection