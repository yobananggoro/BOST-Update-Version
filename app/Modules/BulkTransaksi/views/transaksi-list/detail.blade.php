@extends('layouts.app')
@section('title', 'Detail Upload File')
@section('content')
<div class="row">
    <div class="col-4">
        <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fas fa-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Posted</span>
                <span class="info-box-number">
                    @php
                    if(preg_match('/SUCCESS:\s*(\d+)/', $addtInfo, $matches))
                    {
                    $success = (int) $matches[1];
                    echo number_format($success, 0, '', '.');
                    }
                    @endphp
                </span><hr>
                <span class="info-box-text">Verified</span>
                <span class="info-box-number">
                    @php
                    if(preg_match('/VERIFY_SUCCESS:\s*(\d+)/', $addtInfo, $matches))
                    {
                    $success = (int) $matches[1];
                    echo number_format($success, 0, '', '.');
                    }
                    @endphp
                </span>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hourglass-half"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Posting on Progress</span>
                <span class="info-box-number">
                    @php
                    if(preg_match('/IN_PROGRESS:\s*(\d+)/', $addtInfo, $matches))
                    {
                    $inprogress = (int) $matches[1];
                    echo number_format($inprogress, 0, '', '.');
                    }
                    @endphp
                </span><hr>
                <span class="info-box-text">Verify on Progress</span>
                <span class="info-box-number">
                    @php
                    if(preg_match('/VERIFY_IN_PROGRESS:\s*(\d+)/', $addtInfo, $matches))
                    {
                    $inprogress = (int) $matches[1];
                    echo number_format($inprogress, 0, '', '.');
                    }
                    @endphp
                </span>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Posting Failed</span>
                <span class="info-box-number">
                    @php
                    if(preg_match('/FAILED:\s*(\d+)/', $addtInfo, $matches))
                    {
                    $failed = (int) $matches[1];
                    echo number_format($failed, 0, '', '.');
                    }
                    @endphp
                </span><hr>
                <span class="info-box-text">Not Verified</span>
                <span class="info-box-number">
                    @php
                    if(preg_match('/VERIFY_FAILED:\s*(\d+)/', $addtInfo, $matches))
                    {
                    $failed = (int) $matches[1];
                    echo number_format($failed, 0, '', '.');
                    }
                    @endphp
                </span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header border-0">
                <div class="float-right" id="searchContainer"></div>
                <table class="float-left" cellspacing="0" cellpadding="0" style="font-weight: bold; font-size: 15px">
                    <tbody>
                        <tr>
                            <td style="width: 150px; text-align: left">Page</td>
                            <td style="width: 15px; text-align: left">:</td>
                            <td style="width: 180px; text-align: left">{{$page}}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left">Max Rows per Page</td>
                            <td style="text-align: left">:</td>
                            <!-- <td style="text-align: left">{{number_format(count($data), 0, '', '.')}} rows</td> -->
                            <td style="text-align: left">{{number_format($size, 0, '', '.')}} rows</td>
                        </tr>
                        <tr>
                            <td style="text-align: left">Total Rows</td>
                            <td style="text-align: left">:</td>
                            <td style="text-align: left">{{number_format($request->rows, 0, '', '.')}} rows</td>
                        </tr>
                        <tr>
                            <td style="text-align: left">Total Debit</td>
                            <td style="text-align: left">:</td>
                            <td style="text-align: left">{{ number_format($request->amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left">Total Credit</td>
                            <td style="text-align: left">:</td>
                            <td style="text-align: left">{{ number_format($request->amount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-body table-responsive" style="max-height: 650px; overflow-y: scroll">
                <!-- <table class="table table-striped table-head-fixed" style="width: 150%"> -->
                <table id="dataTableDetailUpload" class="table table-striped" style="width: 170%">

                    <thead>
                        <tr>
                            <!-- <th style="width:10px">No.</th> -->
                            <th style="width:100px">Kode Trx</th>
                            <th>No Cheque</th>
                            <th>No Akun</th>
                            <th>Nama Akun</th>
                            <th>Status Akun</th>
                            <th>Ccy</th>
                            <th>Nominal</th>
                            <th>Narative 1</th>
                            <th>Narative 2</th>
                            <th>Narative 3</th>
                            <th>Narative 4</th>
                            <th>Status Trx</th>
                            <th>Tanggal Posting</th>
                            <th>Tanggal Buat</th>
                            <th>Tanggal Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $d)
                        <tr>
                            @if($d['trxType'] != 'dc')
                            <!-- <td>{{ $key+1 }}.</td> -->
                            <td>{{ $d['trxType'] == 'd' ? $d['trxCodeDebit'].' (D) ' : $d['trxCodeCredit'].' (C) '}}</td>
                            <td>{{ $d['chequeNumber'] }}</td>
                            <td>{{ $d['trxType'] == 'd' ? $d['srcAccountNumber'] : $d['dstAccountNumber'] }}</td>
                            <td>{{ $d['accountName'] }}</td>
                            <td>{{ $d['accountStatus'] }}</td>
                            <td>{{ $d['trxType'] == 'd' ? $d['srcCcy'] : $d['dstCcy'] }}</td>
                            <td class="text-right">{{ number_format($d['trxAmount'],2) }}</td>
                            <td>{{ $d['trxType'] == 'd' ? $d['nar1'] : $d['nar5'] }}</td>
                            <td>{{ $d['trxType'] == 'd' ? $d['nar2'] : $d['nar6'] }}</td>
                            <td>{{ $d['trxType'] == 'd' ? $d['nar3'] : $d['nar7'] }}</td>
                            <td>{{ $d['trxType'] == 'd' ? $d['nar4'] : $d['nar8'] }}</td>
                            <td>{{ $d['trxStatus'] }}</td>
                            <!-- <td>{{ $d['postingDt'] != null ? date('d M Y H:i:s', strtotime($d['postingDt'])) : '' }}</td> -->
                            <td>{{ $d['postingDt'] != null ? \Carbon\Carbon::createFromFormat('Y-m-d-H.i.s.u', $d['postingDt'])->addMinute()->startOfMinute()->format('d M Y H:i:s') : '' }}</td>
                            <td>{{ $d['createdAt'] != null ? date('d M Y H:i:s', strtotime($d['createdAt'])) : '' }}</td>
                            <td>{{ $d['updatedAt'] != null ? date('d M Y H:i:s', strtotime($d['updatedAt'])) : '' }}</td>
                            @else
                            <!-- <td>{{ $key+1 }}.</td> -->
                            <td>{{ $d['trxCodeDebit'].' (D) '}}<br>{{$d['trxCodeCredit'].' (C) '}}</td>
                            <td>{{ $d['chequeNumber'] }}</td>
                            <td>{{ $d['srcAccountNumber'] }}<br>{{ $d['dstAccountNumber'] }}</td>
                            <td>{{ $d['accountName'] }}</td>
                            <td>{{ $d['accountStatus'] }}</td>
                            <td>{{ $d['trxType'] == 'd' ? $d['srcCcy'] : $d['dstCcy'] }}</td>
                            <td class="text-right">{{ number_format($d['trxAmount'],2) }}</td>
                            <td>{!! $d['trxType'] == 'd' ? $d['nar1'] : $d['nar1']."<br>".$d['nar5'] !!}</td>
                            <td>{!! $d['trxType'] == 'd' ? $d['nar2'] : $d['nar2']."<br>".$d['nar6'] !!}</td>
                            <td>{!! $d['trxType'] == 'd' ? $d['nar3'] : $d['nar3']."<br>".$d['nar7'] !!}</td>
                            <td>{!! $d['trxType'] == 'd' ? $d['nar4'] : $d['nar4']."<br>".$d['nar8'] !!}</td>
                            <td>{{ $d['trxStatus'] }}</td>
                            <!-- <td>{{ $d['postingDt'] != null ? date('d M Y H:i:s', strtotime($d['postingDt'])) : '' }}</td> -->
                            <td>{{ $d['postingDt'] != null ? \Carbon\Carbon::createFromFormat('Y-m-d-H.i.s.u', $d['postingDt'])->addMinute()->startOfMinute()->format('d M Y H:i:s') : '' }}</td>
                            <td>{{ $d['createdAt'] != null ? date('d M Y H:i:s', strtotime($d['createdAt'])) : '' }}</td>
                            <td>{{ $d['updatedAt'] != null ? date('d M Y H:i:s', strtotime($d['updatedAt'])) : '' }}</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        <!-- <h8><b>Total rows: {{number_format($request->rows, 0, '', '.')}}</b></h8> -->
                    </div>
                    <div class="col-6">
                        <div class="btn-group float-right">
                            <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate" style="align-content: flex-end">
                                <ul class="pagination">
                                    @if($page <= 0 )
                                        <li class="paginate_button page-item previous disabled" id="example1_previous">
                                        <a type="button" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
                                            ‹
                                        </a>
                                        </li>
                                        @else
                                        <li class="paginate_button page-item previous" id="example1_previous">
                                            <a href="{{ route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $page-1, 'rows' => $request->rows, 'amount' => $request->amount]) }}" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
                                                ‹
                                            </a>
                                        </li>
                                        @endif

                                        <li class="paginate_button page-item next" id="example1_next">
                                            <a href="{{ route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => 0, 'rows' => $request->rows, 'amount' => $request->amount]) }}" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                                                First
                                            </a>
                                        </li>
                                        @for ($i = 0; $i <= ceil($request->rows/$size)-1; $i++)
                                            @php
                                            $startpage=$page - 2;
                                            $endpage=$page + 2;
                                            @endphp
                                            @if ($i >= $startpage && $i <= $endpage)
                                                @if ($i==$page)
                                                <li class="paginate_button page-item active">
                                                <a href="{{ route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $page, 'rows' => $request->rows, 'amount' => $request->amount]) }}" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
                                                    {{$i}}
                                                </a>
                                                </li>
                                                @else
                                                <li class="paginate_button page-item">
                                                    <a href="{{ route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $i, 'rows' => $request->rows, 'amount' => $request->amount]) }}" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
                                                        {{$i}}
                                                    </a>
                                                </li>
                                                @endif
                                                @endif
                                                @endfor
                                                <li class="paginate_button page-item next" id="example1_next">
                                                    <a href="{{ route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => ceil($request->rows/$size)-1, 'rows' => $request->rows, 'amount' => $request->amount]) }}" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                                                        Last
                                                    </a>
                                                </li>
                                                @if ((@$page) >= ceil($request->rows/$size)-1)
                                                <li class="paginate_button page-item disabled" id="example1_next">
                                                    <a type="button" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                                                        ›
                                                    </a>
                                                </li>
                                                @else
                                                <li class="paginate_button page-item next" id="example1_next">
                                                    <a href="{{ route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $page+1, 'rows' => $request->rows, 'amount' => $request->amount]) }}" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                                                        ›
                                                    </a>
                                                </li>
                                                @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection