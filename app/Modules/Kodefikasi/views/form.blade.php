@php
    $segment = request()->segment(2);
    $title = 'create'; $method = 'post'; $action = 'kodefikasi.store';
    if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['kodefikasi.update', $kodefikasi->id]; }
@endphp
@extends('layouts.app')
@section('title', 'Form Kodefikasi APUPPT')
@section('content')
<div class="row">
    <div class="col-5">
        <div class="card card-default">
            <div class="card-header">
            </div>
            {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
                <div class="card-body">
                    <div class="col-12 form-group">
                        <label>Group Code</label>
                        <select name="groupCode" class="form-control">
                            <option value="">- Pilih -</option>
                            @foreach($kodefikasi_group_code as $key => $value)
                            <option value="{{$key}}" {{$key == @$request->groupCode ? 'selected':'' }}>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label>Key Code</label>
                        <input type="text" name="keyCode" id="keyCode" class="form-control number" value="{{ @$request->keyCode }}">
                    </div>
                    <div class="col-12 form-group">
                        <label>Value</label>
                        <input type="text" name="values" id="values" class="form-control" value="{{ @$request->values }}">
                    </div>
                    <div class="col-12 form-group">
                        <label>Description</label>
                        <input type="text" name="description" id="description" class="form-control" value="{{ @$request->description }}">
                    </div>
                    <div class="col-12 form-group">
                        <label>Is Active</label>
                        <select name="isActive" class="form-control">
                            <option value="">- Pilih -</option>
                            @foreach($bool_decision as $key => $value)
                            <option value="{{$key}}" {{$key == @$request->isActive ? 'selected':'' }}>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-primary"><i class="fas fa-check"></i> Submit</button>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection