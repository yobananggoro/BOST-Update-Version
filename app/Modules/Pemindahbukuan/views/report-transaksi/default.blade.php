@extends('layouts.app')
@section('title', 'Report Transaksi')
@section('content')
<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <div class="btn-group">
                    <b>Filter</b>
                </div>
            </div>
            <form action="{{ url('report-transaksi/getReport') }}" method="post" id="formInput" class="form-horizontal">
                @csrf
                <div class="card-body">
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-4">
                            <div class="input-group"> 
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" id="startDate" name="startDate" value="{{@$request->startDate}}" onchange="getRequest(this)" class="form-control datepick" placeholder="Start Date">
                            </div>
                        </div> 
                        <div class="col-sm-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" id="endDate" name="endDate" value="{{@$request->endDate}}" onchange="getRequest(this)" class="form-control datepick" placeholder="End Date">
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->profile->rolename == "SUPER ADMIN")
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">User ID</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" id="userid" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{old('userid', @$request->userid)}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Branch</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select name="branch" id="branch" class="form-control select2" onchange="getRequest(this)">
                                    <option value="">- Pilih -</option>
                                    @foreach($branch as $key => $value)
                                    <option value="{{$value['kode']}}" {{$value['kode'] == $request->branch ? 'selected':'' }}>{{$value['nama']}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">User ID</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                @if(auth()->user()->profile->rolename != "USER")
                                <input type="text" id="userid" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{ old('userid', @$request->userid) }}">
                                @else
                                <input type="text" id="userid" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{ auth()->user()->username }}" readonly>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Branch</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" maxlength="4" value="{{auth()->user()->profile->unitKerja->nama}}" readonly>
                                <div style="display: none">
                                    <input type="hidden" id="branch" name="branch" class="form-control" maxlength="4" value="{{auth()->user()->profile->unit_kerja_kode}}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button type="submit" id="btnEnter" class="btn btn-sm btn-info"><i class="fas fa-search"></i> Filter</button>
                    </div>
                    <div class="btn-group">
                        <a href="{{url('report-transaksi')}}" type="button" id="btnEnter" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reset</a>
                    </div>
                    <div class="btn-group float-right">
                        @if(@$request->userid != '')
                        <button id="btnPrintPDF" class="btn btn-sm btn-success" form="formPdf"><i class="fas fa-print"></i> Export PDF</button>
                        @endif
                    </div>
                </div>
            </form>
            <form action="{{ url('report-transaksi/pdf') }}" method="post" target="_blank" id="formPdf" class="form-horizontal">
                @csrf
                <input type="hidden" id="startDate_" name="startDate" value="{{@$request->startDate}}" readonly>
                <input type="hidden" id="endDate_" name="endDate" value="{{@$request->endDate}}" readonly>
                <input type="hidden" id="userID_" name="userid" maxlength="4" value="{{ @$request->userid }}" readonly>
                @if(auth()->user()->profile->rolename == "SUPER ADMIN")
                <input type="hidden" id="branch_" name="branch" maxlength="4" value="{{@$request->branch}}" readonly>
                @else
                <input type="hidden" id="branch_" name="branch" maxlength="4" value="{{auth()->user()->profile->unit_kerja_kode}}" readonly>
                @endif

            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card card-default">
            <div class="card-body">
                <table id="dataTables" class="table table-bordered table-striped">
                    <thead>
                        <tr style="text-align: center">
                            <th style="width: 10px">No.</th>
                            <th style="width: 110px">Reff Code</th>
                            <th style="width: 120px">Trx Name</th>
                            <th style="width: 130px">Time Stamps</th>
                            <th style="width: 50px">Trans</th>
                            <th style="width: 110px">Account</th>
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
                                <td>{!! isset($value['addtInfo']['responseCode']) ? $value['addtInfo']['data']['sourceCurrency'].'<br>'.$value['addtInfo']['data']['destinationCurrency']  : null !!}</td>
                                @else
                                <td>-</td>
                                <td>{{ $value['trxSrcAcct'] }}<br>{{$value['trxDstAcct'] }}</td></td>
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
        </div>
    </div>
</div>
@endsection
