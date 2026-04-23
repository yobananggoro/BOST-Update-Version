@extends('layouts.app')
@section('title', 'User Code List')
@section('content')
<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <div class="btn-group">
                    <a href="{{ url('user-code-list') }}" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> List Data</a>
                </div>
                <div class="btn-group">
                    <a href="{{ url('user-code/reload') }}" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reload Data</a>
                </div>
            </div>
            <div class="card-body">
                <table id="dataTable1" class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:10px">No.</th>
                            <th>Nama User Kode</th>
                            <th>User Kode 1</th>
                            <th>User Kode 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($data))
                        @foreach($data as $key => $d)
                            <tr>
                                <td>{{ $key+1 }}.</td>
                                <td>{{ $d['description'] }}</td>
                                <td>{{ $d['userCode1'] }}</td>
                                <td>{{ $d['userCode2'] }}</td>
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