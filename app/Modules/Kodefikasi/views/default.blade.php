@extends('layouts.app')
@section('title', 'Kodefikasi APUPPT List')
@section('content')
@include('kodefikasi::filter')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <div class="btn-group float-right">
                    <a href="{{ url('kodefikasi/create') }}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Add Data</a>
                </div>
            </div>
            <div class="card-body">
                <table id="dataTable1" class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <!-- <th style="width:10px">No.</th> -->
                             <th>Key Code</th>
                            <th>Group Code</th>
                            <th>Value</th>
                            <th>Description</th>
                            <th>Is Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($data))
                        @foreach($data as $key => $d)
                        <tr>
                            
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default">Action</button>
                                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-1px, -165px, 0px);">
                                        <a href="{{ route('kodefikasi.listDetail', ['groupCode' => $d['groupCode'], 'keyCode' => $d['keyCode'], 'values' => $d['value'], 'description' => $d['description'], 'isActive' => $d['isActive'] ]) }}" rel="action" title="Detail {{ $d['value'] }}" class="dropdown-item">Detail | <b>{{ $d['value'] }}</b></a>
                                        <a href="{{ route('kodefikasi.delete', ['groupCode' => $d['groupCode'], 'keyCode' => $d['keyCode'] ]) }}" rel="action" title="Delete {{ $d['value'] }}" class="dropdown-item">Delete | <b>{{ $d['value'] }}</b></a>
                                    </div>
                                </div>
                            </td>
                            <!-- <td>{{ $key+1 }}.</td> -->
                             <td>{{ $d['keyCode'] }}</td>
                            <td>{{ $d['groupCode'] }}</td>
                            <td>{{ $d['value'] }}</td>
                            <td>{{ $d['description'] }}</td>
                            <td>{{ $d['isActive'] == true ? 'Active':'Non-Active' }}</td>
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