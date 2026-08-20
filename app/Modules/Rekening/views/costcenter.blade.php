@extends('layouts.app')
@section('title', 'Rekening Costcenter')
@section('content')
<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <div class="btn-group">
                    <a href="{{ url('rekening-costcenter/list') }}" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> List Data</a>
                </div>
                <div class="btn-group">
                    <a href="{{ url('rekening-costcenter/reload') }}" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reload Data</a>
                </div>
            </div>
            <div class="card-body">
                <table id="dataTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:10px">No.</th>
                            <th>Account</th>
                            <th>Desc</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($data))
                        @foreach($data as $key => $d)
                            <tr>
                                <td>{{ $key+1 }}.</td>
                                <td>{{ $d['account'] }}</td>
                                <td>{{ $d['description'] }}</td>
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