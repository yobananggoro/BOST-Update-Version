@php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'hak-akses.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['hak-akses.update', $permission->id]; }
@endphp
@extends('layouts.app')
@section('title', __('label.' . $title) . ' Hak Akses')
@section('content')
{{ Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off']) }}
<div class="card card-success">
    <div class="card-body">
        @if($segment !== 'create')
        {{ Form::hidden('id', $permission->id) }}
        @endif
        {{ Form::fgText('Hak Akses', 'name', $permission->name, ['class' => 'form-control ucase'], null, 'text', true) }}
        {{ Form::fgSelect('Akses Transaksi', 'is_transactions', to_dropdown($akses_transaksi), $permission->is_transactions == "true" ? "t":"f", ['class' => 'form-control'], null, true) }}

        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Menu & Pengelolaan</label>
            <div class="col-md-10">
                <div class="row">
                    @foreach($modules as $module)
                    {{-- @php echo $module @endphp --}}
                    <div @if($module->uri != '#' && !empty($module->parent_id)) class="col-md-12 mb-2 bg-danger ml-auto" @else class="col-md-12 mb-2 bg-primary" @endif>
                        <div class="checkbox-inline">
                            <label for="{{ $module->label }}">
                                @php($checked = $permission->modules && $permission->modules->where('id', $module->id)->count())
                                {{ Form::checkbox('modules[]', $module->id, $checked, ['class' => 'access access' . $loop->index]) }}
                                {{ $module->label }}
                            </label>
                            <label for="{{ $module->label }}" class="float-right">
                                [ 
                                    @if(empty($module->parent_id))
                                        Parent
                                    @else
                                        Child of 
                                        {{ 
                                            optional(
                                                $modules->firstWhere('id', $module->parent_id)
                                            )->label 
                                        }}
                                    @endif
                                ]
                            </label>
                        </div>
                        @if(isset($permissions[$module->uri]))
                        <div class="col-md-12 mb-2 bg-warning">
                            <div class="row">
                                @foreach($permissions[$module->uri] as $perm)
                                <div class="col-md-3">
                                    <div class="checkbox-inline mt-2">
                                        <label for="{{ $perm }}">
                                            @php($checked = $permission->permissions && $permission->permissions->where('name', $perm)->count())
                                            {{ Form::checkbox('permissions[]', $perm, $checked, ['class' => 'access-child' . $loop->parent->index . ' access-child' . $loop->parent->index . '-' . $loop->index]) }}
                                            {{ \Illuminate\Support\Str::title(str_replace('-', ' ', $perm)) }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer clearfix">
        {{ Form::fgFormButton('hak-akses', $segment) }}
    </div>
</div>
{{ Form::close() }}
@endsection