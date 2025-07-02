@extends('layouts.app')
@section('title', 'Menu List')
@section('content')
@include('menu::filter')
@if(count($data))
<div class="card card-success">
    <div class="card-body">
        <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
            <thead>
                <tr>
                    @if(hasModulePermission('menu'))
                    <th>{{ __('label.action') }}</th>
                    @endif
                    <th>Label Menu</th>
                    <th>Url</th>
                    <th>Icon</th>
                    <th>Parent</th>
                    <th>visible</th>
                    <th>Sequence</th>
                </tr>
            </thead> 
            <tbody>
                @foreach ($data as $d)
                <tr>
                    @if(hasModulePermission('menu'))
                    <td>{!! Html::linkUpdateDelete('menu', ['id' => $d->id, 'label' => $d->label]) !!}</td>
                    @endif
                    <td>{{ $d->label }}</td>
                    <td>{{ $d->uri }}</td>
                    <td>{{ $d->icon }}</td>
                    <td>{{ $d->parents->label ?? '' }}</td>
                    <td>{{ $d->visible == 't' ? 'on':'off'}}</td>
                    <td>{{ $d->sequence }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix"> 
        <div class="row">
            <div class="col-6">
                {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('menu'))->links() }}
            </div>
            
            <div class="col-6 text-right" style="margin-top: 8px">
                {!! Html::linkCreate('menu') !!}
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning">
    {!! trans('label.no_data_with_link', ['label' => 'Menu', 'uri' => route('menu.create')]) !!}
</div>
@endif
@endsection