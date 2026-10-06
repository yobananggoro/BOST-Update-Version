@extends('layouts.app')
@section('title', 'List Bulk Upload')
@section('content')
@include('bulktransaksi::transaksi-list.filter')
<div class="row" id="bulkList">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header border-0">
                <div class="float-right" id="searchContainer_list"></div>
            </div>
            <div class="card-body table-responsive" style="overflow-y: scroll">
                <table id="dataTableList" class="table table-striped" style="width: 150%">
                    <thead>
                        <tr>
                            <th style="width:10px">No.</th>
                            <th style="width:70px">Aksi</th>
                            <th>Refference</th>
                            <th>Trx</th>
                            <th>File</th>
                            <th>Nominal</th>
                            <th>Maker</th>
                            <th>Approval</th>
                            <th>Status</th>
                            <th>Tanggal Buat</th>
                            <th>Tanggal Update</th>
                            @if(auth()->user()->profile->rolename == 'SUPER ADMIN')
                            <th>Kode Kantor</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if($data != '')
                            @foreach($data as $key => $d)
                            <tr>
                                <td>{{ $key+1 }}.</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default">Action</button>
                                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-1px, -165px, 0px);">
                                            <a target="_blank" href="{{ route('list-bulkupload.listDetail', ['id' => $d['id'], 'page' => 0, 'rows' => $d['totalRecords'], 'amount' => $d['totalDebit'], 'reff' => $d['reference']]) }}" class="dropdown-item">Detail | <b>{{ $d['reference'] }}</b></a>
                                            @if(in_array(auth()->user()->profile->rolename, ['Operator']))
                                                @if($d['status'] == 'WAITING_VERIFY')
                                                    <a href="{{ route('list-bulkupload.verify', ['id' => $d['id'], 'action' => 'true']) }}" class="dropdown-item" rel="action" title="Verify {{ $d['reference'] }}">Verify | <b>{{ $d['reference'] }}</b></a>
                                                    <a href="{{ route('list-bulkupload.verify', ['id' => $d['id'], 'action' => 'false']) }}" class="dropdown-item" rel="action" title="Cancel {{ $d['reference'] }}">Cancel | <b>{{ $d['reference'] }}</b></a>
                                                @endif
                                            @endif
                                            @if($d['status'] == 'EXECUTED')
                                                <a target="_blank" href="{{ route('list-bulkupload.pdf', ['id' => $d['id'], 'usermaker' => $d['createdBy'], 'useroto' => $d['updatedBy'] == null ? '' : $d['updatedBy'], 'timecreate' => $d['createdAt'], 'timeoto' => $d['approvedAt'] == null ? '' : $d['approvedAt'], 'reff' => $d['reference'], 'trxType' => $d['bulkType'], 'amount' => $d['totalDebit']]) }}" class="dropdown-item">Export PDF | <b>{{ $d['reference'] }}</b></a>
                                            @endif
                                            <a target="_blank" href="{{ route('list-bulkupload.excel', ['id' => $d['id'], 'usermaker' => $d['createdBy'], 'useroto' => $d['updatedBy'] == null ? '' : $d['updatedBy'], 'timecreate' => $d['createdAt'], 'timeoto' => $d['approvedAt'] == null ? '' : $d['approvedAt'], 'reff' => $d['reference'], 'trxType' => $d['bulkType'], 'amount' => $d['totalDebit']]) }}" class="dropdown-item">Export Excel | <b>{{ $d['reference'] }}</b></a>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $d['reference'] }}</td>
                                <td>{{ $d['bulkType'] }}</td>
                                <td>{{ $d['fileName'] }}</td>
                                <!-- <td class="text-right">{{ $d['totalRecords']-1 }}</td> -->
                                <td class="text-right">{{ number_format($d['totalDebit'], 2) }}</td>
                                <td>{{ $d['createdBy'] }}</td>
                                <td>{{ $d['updatedBy'] }}</td>
                                <td>{{ str_replace('_', ' ', $d['status']) }}</td>
                                <td>{{ $d['createdAt'] != null ? date('d M Y H:i:s', strtotime($d['createdAt'])) : '' }}</td>
                                <td>{{ $d['updatedAt'] != null ? date('d M Y H:i:s', strtotime($d['updatedAt'])) : '' }}</td>
                                @if(auth()->user()->profile->rolename == "SUPER ADMIN")
                                <td>{{ $d['branch'] }}</td>
                                @endif
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="float-right" id="pagingContainer_list"></div>
            </div>
        </div>
    </div>
</div>
@endsection