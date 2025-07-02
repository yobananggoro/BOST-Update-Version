@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'users.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['users.update', $data->id]; }
@endphp
@extends('layouts.app')
@section('title', 'Edit Profile User')
@section('content')
<div class="col-6">
    <div class="card card-default">
        <div class="card-header">
            <table cellspacing="0" cellpadding="0" style="font-weight: bold">
                <tbody>
                    <tr>
                        <td style="width:100px">Nama</td>
                        <td style="width:10px">:</td>
                        <td>{{$data->profile->nama}}</td>
                    </tr>
                    <tr>
                        <td>User</td>
                        <td>:</td>
                        <td>{{$data->username}}</td>
                    </tr>
                    <tr>
                        <td>Unit Kerja</td>
                        <td>:</td>
                        <td>{{$data->profile->unitKerja->nama}} ({{$data->profile->rolename}})</td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        @csrf
        <input type="hidden" name="username" value="{{ $data->username }}" readonly>
        <div class="card-body">
            <div class="col-12">
                <div class="form-group col-12 row">
                    <label class="col-sm-2 col-form-label">Limit Debet</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" name="limit_debet" class="form-control currency text-right" value="{{number_format($data->profile->limit_debet)}}">
                        </div>
                    </div>
                </div>
                <div class="form-group col-12 row">
                    <label class="col-sm-2 col-form-label">Limit Kredit</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" name="limit_kredit" class="form-control currency text-right" value="{{number_format($data->profile->limit_kredit)}}">
                        </div>
                    </div>
                </div>
                <div class="form-group col-12 row">
                    <label class="col-sm-2 col-form-label">Fingerprint</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <select class="form-control" name="isFinger">
                                <option value="true" {{$data->profile->isFinger == true ? "selected":""}}>True</option>
                                <option value="false" {{$data->profile->isFinger == false ? "selected":""}}>False</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="btn-group">
                <button type="submit" class="btn btn-sm btn-primary" style="width: 80px">Submit</button>
            </div>
            <div class="btn-group">
                <a href="{{url('users')}}" type="button" class="btn btn-sm btn-warning" style="width: 80px">Kembali</a>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@endsection 