@extends('layouts.app')
@section('title', 'Rekening List')
@section('content')
@include('rekening::filter')
@if(count($data))
<div class="card card-default">
    <div class="card-body">
        <table class="table table-striped tablesaw">
            <thead>
                <tr>
                    @if(hasModulePermission('rekening'))
                    <th>{{ __('label.action') }}</th>
                    @endif
                    <th>No Rek Internal </th>
                    <th>No Rek Eksternal</th>
                    <th>Nama Rekening</th>
                    <th>Tipe Rekening</th>
                    <th>Tipe Currency</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr>
                    @if(hasModulePermission('rekening'))
                    <td>{!! Html::linkUpdateDelete('rekening', ['id' => $d->id, 'label' => $d->nama]) !!}</td>
                    @endif
                    <td>{{$d->branch}} - {{$d->cif}} - {{$d->suffix}}</td>
                    <td>{{$d->externalNum}}</td>
                    <td>{{$d->nama}}</td>
                    <td>{{$d->tipe_rek}}</td>
                    <td>{{$d->tipe_ccy}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        <div class="row">
            <div class="col-6">
                {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('rekening'))->links() }}
            </div>
            <div class="col-6 text-right" style="margin-top: 8px">
                {!! Html::linkCreate('rekening') !!}
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning">
    {!! trans('label.no_data_with_link', ['label' => 'Rekening', 'uri' => route('rekening.create')]) !!}
</div>
@endif
@endsection