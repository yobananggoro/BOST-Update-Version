@extends('layouts.app')
@section('title', 'Notifikasi')
@section('content')
    @if(count($data))
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped datatable">
                    <thead>
                    <tr>
                        <th>{{ __('label.action') }}</th>
                        <th>Tanggal</th>
                        <th>Pesan</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>hai</td>
                            <td>{{ format_date($d->created_at) }}</td>
                            <td>
                                <a href="{{ $d->data['url'] }}">
                                    {{ $d->data['message'] }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            {!! trans('label.no_data', ['label' => 'Notifikasi']) !!}
        </div>
    @endif
@endsection
