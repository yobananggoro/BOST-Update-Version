@extends('layouts.app')
@section('title', 'Setting')
@section('content')
{{ Form::open(['route' => 'setting.update', 'method' => 'post', 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true]) }}
@php(\Illuminate\Support\Arr::forget($display_per_page, 'All'))
@foreach($data as $key => $values)
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ to_upper($key) }}</h3>
    </div>
    <div class="card-body">
        @foreach ($values as $d)
        @if($d['key'] === 'display_per_page')
        {{ Form::fgSelect($d['shortdesc'], $d['key'], to_dropdown($display_per_page), $d['value'], ['class' => 'form-control'], null, true) }}
        @elseif($d['key'] === 'auth_method')
        {{ Form::fgSelect($d['shortdesc'], $d['key'], to_dropdown($auth_method), $d['value'], ['class' => 'form-control'], null, true) }}
        @elseif(in_array($d['key'], ['force_local', 'notif_via_email', 'push_notif', 'bypass_cutoff']))
        {{ Form::fgSelect($d['shortdesc'], $d['key'], ['' => __('label.choose_one'), 'true' => __('label.yes'), 'false' => __('label.no')], $d['value'], ['class' => 'form-control'], null, true) }}
        @elseif($d['key'] === 'logo')
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">{{ $d['shortdesc'] }}</label>
            @isset($d['value'])
            <div class="col-md-2 text-center mt-5">
                <img src="{{ asset('img/' . $d['value']) }}" alt="logo" width="140" height="100">
            </div>
            @endisset
            <div class="col-md-{{ isset($d['value']) ? '8' : '10' }}">
                {!! Form::file($d['key'], ['class' => 'dropify']) !!}
            </div>
        </div>
        @elseif(in_array($d['key'], ['motd', 'disclaimer']))
        {{ Form::fgText($d['shortdesc'], $d['key'], $d['value'], ['class' => 'form-control'], null, 'textarea', true) }}
        @else
        {{ Form::fgText($d['shortdesc'], $d['key'], $d['value'], ['class' => 'form-control ' . ($d['key'] === 'ftp_rdn' ? 'ipport' : '')], null, 'text', true) }}
        @endif
        @endforeach
    </div>
</div>
@endforeach

<div class="card">
    <div class="card-footer">
        <div class="row col-12 clearfix">
            <button class="btn btn-success btn-sm save">
                <i class="fa fa-save"></i> {{ __('button.save') }}
            </button>&nbsp;
            <button type="reset" class="btn btn-warning btn-sm reset">
                <i class="fa fa-refresh"></i> {{ __('button.reset') }}
            </button>&nbsp;
        </div>
    </div>
</div>
{{ Form::close() }}
@endsection