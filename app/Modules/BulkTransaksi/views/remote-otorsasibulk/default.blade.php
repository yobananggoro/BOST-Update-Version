@extends('layouts.app')
@section('title', 'Remote Otorisasi Bulk')
@section('content')
@include('bulktransaksi::remote-otorsasibulk.filter')
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
                            <!-- <th>Total</th> -->
                            <th>Amount</th>
                            <th>Maker</th>
                            <th>Approval</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
                            @if(auth()->user()->profile->rolename == 'SUPER ADMIN')
                            <th>Cabang</th>
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
                                        <div class="dropdown-menu" role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-1px, -165px, 0px);">
                                            <a href="{{ route('remote-otorisasibulk.listDetail', ['id' => $d['id'], 'page' => 0, 'rows' => $d['totalRecords'], 'amount' => $d['totalDebit'], 'reff' => $d['reference']]) }}" rel="action" title="Detail {{ $d['reference'] }}" class="dropdown-item">Detail | <b>{{ $d['reference'] }}</a>
                                        </div>
                                    </button>
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