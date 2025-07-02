@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'rekening.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['rekening.update', $data->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Rekening Form')
@section('content')
<div class="row toastrDefaultInfo"></div>
<div class="row toastrDefaultError"></div>
<div class="col-sm-6">
    <div class="card card-default">  
        <div class="card-header" @if($title !== 'create') style="display:none" @endif>
            <div class="form-group">
                <div class="row"> 
                    <div class="col-sm-3">
                        <input type="text" id="branch" name="branch" class="form-control numeric" maxlength="4" placeholder="Branch">
                    </div>
                    <div class="col-sm-6">
                        <input type="text" id="cif" name="cif" class="form-control ucase" maxlength="6" placeholder="Cif">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" id="suffix" name="suffix" class="form-control numeric" maxlength="3" placeholder="Suffix">
                    </div>
                </div>
                <br>
                <button class="btn btn-sm btn-info col-sm-12" onclick="cekGI33();">Detail</button>
            </div>
        </div>
        {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    {{-- <input type="text" id="branch1" class="form-control numeric" name="branch" value="{{old('branch')}}" maxlength="4" readonly> --}}
                    {{ Form::fgText('No Rek Internal', 'branch', $data->branch, ['class' => 'form-control numeric', 'id' => 'branch_', 'maxlength' => '4','readonly'], null, 'text', true) }}
                </div>
                <div class="col-sm-6">
                    {{-- <input type="text" id="cif1" class="form-control ucase" name="cif" value="{{old('cif')}}" maxlength="6" readonly> --}}
                    {{ Form::fgText('.', 'cif', $data->cif, ['class' => 'form-control ucase', 'id' => 'cif_', 'maxlength' => '6','readonly'], null, 'text', true) }}
                </div>
                <div class="col-sm-3">
                    {{-- <input type="text" id="suffix1" class="form-control numeric" name="suffix" value="{{old('suffix')}}" maxlength="3" readonly> --}}
                    {{ Form::fgText('.', 'suffix', $data->suffix, ['class' => 'form-control numeric', 'id' => 'suffix_', 'maxlength' => '3','readonly'], null, 'text', true) }}
                </div>
            </div>
            {{ Form::fgText('No Rek Eksternal', 'externalNum', $data->nama, ['class' => 'form-control', 'id' => 'externalNum', 'readonly'], null, 'text', true) }}
            {{ Form::fgText('Nama Rekening', 'nama', $data->nama, ['class' => 'form-control', 'id' => 'nama', 'readonly'], null, 'text', true) }}
            {{ Form::fgText('Tipe Rekening', 'tipe_rek', $data->tipe_rek, ['class' => 'form-control ucase', 'id' => 'tipe_rek', 'readonly'], null, 'text', true) }}
            {{ Form::fgText('Currency', 'tipe_ccy', $data->tipe_ccy, ['class' => 'form-control', 'id' => 'tipe_ccy', 'readonly'], null, 'text', true) }}
        </div>
        <div class="card-footer clearfix">
            {{ Form::fgFormButton('rekening', $segment) }} 
        </div>
        {{ Form::close() }}
    </div>
</div>
@endsection