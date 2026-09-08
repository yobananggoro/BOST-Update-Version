@extends('layouts.app')
@section('title', 'Jenis Transaksi List')
@section('content')
<div class="row toastrDefaultInfo"></div>
<div class="row toastrDefaultError"></div>
<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <div class="btn-group">
                    <a href="{{ url('jenis-transaksi-list') }}" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> List Data</a>
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
                            <th>Kode Trx Debet</th>
                            <th>Kode Trx Credit</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($data))
                            @foreach($data as $key => $d)
                            <tr>
                                <td>{{ $d['id'] }}.</td>
                                <td>{{ $d['trxName'] }}</td>
                                <td>{{ $d['dbCode'] }}</td>
                                <td>{{ $d['crCode'] }}</td>
                                <td>
                                    <p style="display: none;">{{ $d['active'] }}</p>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox"
                                                class="custom-control-input"
                                                id="customSwitch{{ $d['id'] }}"
                                                onchange="handleSwitch(this, '{{ $d['id'] }}')"
                                                {{ $d['active'] ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customSwitch{{ $d['id'] }}"></label>
                                        </div>
                                    </div>
                                </td>
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