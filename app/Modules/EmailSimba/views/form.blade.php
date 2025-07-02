@php
    $segment = request()->segment(2);
    $title = 'create'; $method = 'post'; $action = 'email-simba.store';
    if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['email-simba.update', $data->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Email Simba Form')
@section('content')
    {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body">
                {{ Form::fgText('Email', 'email', @$data->email, ['class' => 'form-control', 'placeholder' => 'email'], null, 'text', true) }}
                @if(is_numeric(auth()->user()->profile->unit_kerja_kode))
                    {{ Form::fgText('Branch', 'branch', @$data->branch, ['class' => 'form-control', 'placeholder' => 'Branch' , 'readonly' => 'true' ], null, 'text', true) }}
                @else 
                    {{ Form::fgText('Branch', 'branch', @$data->branch, ['class' => 'form-control', 'placeholder' => 'Branch' ], null, 'text', true) }}
                @endif
                {{-- @if($segment !== 'create') --}}
                {{-- {{ Form::fgText('Id', 'id', @$data->id, ['class' => 'form-control', 'placeholder' => 'Id', 'readonly' => 'true'], null, 'text', true) }} --}}
                {{-- @else  --}}
                {{-- {{ Form::fgText('Id', 'id', @$data->id, ['class' => 'form-control', 'placeholder' => 'id'], null, 'text', true) }} --}}
                {{-- @endif --}}
            </div>
            <div class="card-footer clearfix"> 
                {{ Form::fgFormButton('email-simba', $segment) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection