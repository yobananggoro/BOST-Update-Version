@extends('layouts.app')
@section('title', 'Form Edit Kodefikasi APUPPT')
@section('content')
<div class="row">
    <div class="col-5">
        <div class="card card-default">
            <div class="card-header">
            </div>
            <form action="{{ route('kodefikasi.update') }}" method="post" role="form" class="form-horizontal">
                @csrf
                <div class="card-body">
                    <div style="display: none">
                        <div class="col-12 form-group">
                            <label>Group Code</label>
                            <select name="groupCode" class="form-control">
                                @foreach($kodefikasi_group_code as $key => $value)
                                <option value="{{$key}}" {{$key == @$request->groupCode ? 'selected':'' }}>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 form-group">
                            <label>Key Code</label>
                            <input type="text" name="keyCode" id="keyCode" class="form-control number" value="{{ @$request->keyCode }}">
                        </div>
                    </div>
                    <div class="col-12 form-group">
                        <label>Group Code</label>
                        <select class="form-control" disabled>
                            @foreach($kodefikasi_group_code as $key => $value)
                            <option value="{{$key}}" {{$key == @$request->groupCode ? 'selected':'' }}>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label>Key Code</label>
                        <input type="text" class="form-control" value="{{ @$request->keyCode }}" disabled>
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
                            @foreach($bool_decision as $key => $value)
                            <option value="{{$key}}" {{$key == @$request->isActive ? 'selected':'' }}>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-primary"><i class="fas fa-check"></i> Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection