@extends('layouts.app')
@section('title', 'Jenis Transaksi List')
@section('content')
<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <div class="btn-group">
                    <a href="{{ url('jenis-transaksi-kode') }}" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> List Data</a>
                </div>
                <div class="btn-group">
                    <a href="{{ url('jenis-transaksi/reload') }}" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reload Data</a>
                </div>
            </div>
            <div class="card-body">
                <table id="dataTable1" class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:10px">No.</th>
                            <th>Nama Transaksi</th>
                            <th>Trx Debet</th>
                            <th>Trx Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($data))
                        @foreach($data as $key => $d)
                            <tr>
                                <td>{{ $key+1 }}.</td>
                                <td>{{ $d['trxName'] }}</td>
                                <td>{{ $d['dbCode'] }}</td>
                                <td>{{ $d['crCode'] }}</td>
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