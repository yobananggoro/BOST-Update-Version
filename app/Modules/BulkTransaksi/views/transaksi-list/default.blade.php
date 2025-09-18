@extends('layouts.app')
@section('title', 'List Bulk Upload')
@section('content')
@include('bulktransaksi::transaksi-list.filter')
<div class="row" id="bulkList" style="display: ">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-body">
                <table id="dataTable1" class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:10px">No.</th>
                            <th style="width:70px">Aksi</th>
                            <th>Refference</th>
                            <th>Trx</th>
                            <th>Filename</th>
                            <!-- <th>Rows</th> -->
                            <th>Amount</th>
                            <th>Maker</th>
                            <th>Approval</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
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
                                        <a href="{{ route('list-bulkupload.listDetail', ['id' => $d['id'], 'page' => 0, 'rows' => $d['totalRecords'] ]) }}" rel="action" title="Detail {{ $d['reference'] }}" class="dropdown-item">Detail | <b>{{ $d['reference'] }}</b></a>
                                        @if(in_array(auth()->user()->profile->rolename, ['Administrasi Dana Dan Jasa', 'Administrasi Kredit', 'Administrasi Operasional', 'SUPER ADMIN', 'Staf']))
                                            @if($d['status'] == 'WAITING_VERIFY')
                                            <a href="{{ route('list-bulkupload.verify', ['id' => $d['id'], 'action' => 'true']) }}" class="dropdown-item" rel="action" title="Verify {{ $d['reference'] }}">Verify | <b>{{ $d['reference'] }}</b></a>
                                            <a href="{{ route('list-bulkupload.verify', ['id' => $d['id'], 'action' => 'false']) }}" class="dropdown-item" rel="action" title="Cancel {{ $d['reference'] }}">Cancel | <b>{{ $d['reference'] }}</b></a>
                                            @endif
                                        @endif
                                        @if($d['status'] == 'EXECUTED')
                                            <a target="_blank" href="{{ route('list-bulkupload.pdf', ['id' => $d['id'], 'usermaker' => $d['createdBy'], 'useroto' => $d['updatedBy'], 'timeoto' => $d['approvedAt'] == null ? '' : $d['approvedAt'], 'reff' => $d['reference']]) }}" class="dropdown-item">PDF | <b>{{ $d['reference'] }}</b></a>
                                        @endif
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
                            <td>{{ $d['status'] }}</td>
                            <td>{{ $d['createdAt'] }}</td>
                            <td>{{ $d['updatedAt'] }}</td>
                            @if(auth()->user()->profile->rolename == "SUPER ADMIN")
                            <td>{{ $d['branch'] }}</td>
                            @endif
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