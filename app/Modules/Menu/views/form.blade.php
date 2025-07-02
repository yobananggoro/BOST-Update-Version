@php
    $segment = request()->segment(2);
    $title = 'create'; $method = 'post'; $action = 'menu.store';
    if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['menu.update', $data->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Menu Form')
@section('content')
    {{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
        <div class="card card-success">
            <div class="card-body"> 
                {{-- {{$data}} --}}
                {{ Form::fgSelect('Parent', 'parent_module', to_dropdown($prnt), $data->parent_module, ['class' => 'form-control'], null, true) }}
                {{ Form::fgText('Label', 'label', $data->label, ['class' => 'form-control', 'placeholder' => 'Label'], null, 'text', true) }}
                {{ Form::fgText('Url', 'uri', $data->uri, ['class' => 'form-control', 'placeholder' => 'Uri'], null, 'text', true) }}
                {{ Form::fgText('Icon', 'icon', $data->icon, ['class' => 'form-control', 'placeholder' => 'fa fa-icon'], null, 'text', true) }}
                @if($segment !== 'create')
                {{ Form::fgText('Sequence', 'sequence', $data->sequence, ['class' => 'form-control', 'placeholder' => 'Sequence', 'readonly' => 'true'], null, 'text', true) }}
                @else 
                {{ Form::fgText('Sequence', 'sequence', $data->sequence, ['class' => 'form-control', 'placeholder' => 'Sequence'], null, 'text', true) }}
                @endif
                {{ Form::fgOption('Visibility', 'visible', $visibility, $data->visible, null, 'radio', true) }}
            </div>
            <div class="card-footer clearfix"> 
                {{ Form::fgFormButton('menu', $segment) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection