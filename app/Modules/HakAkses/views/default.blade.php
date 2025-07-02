@extends('layouts.app')
@section('title', 'Hak Akses')
@section('content')
@include('hakakses::filter')
<div class="row">
    @if(count($data))
    <div class="col-12">
        <div class="card card-default">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            @if(hasModulePermission('hak-akses'))
                            <th style="width: 50px">{{ __('label.action') }}</th>
                            @endif
                            <th style="width: 200px">Hak Akses</th>
                            <th>Menu</th>
                            <th>Pengelolaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                        <tr>
                            @if(hasModulePermission('hak-akses'))
                            @php
                                $actions = null;
                                $actions[] = ['url' => 'hak-akses.edit', 'permission' => 'edit hak-akses', 'attributes' => ['rel' => 'action', 'title' => __('label.update_message', ['label' => $d->name])], 'label' => __('label.update_message', ['label' => $d->name])];
                            @endphp
                            <td>{!! Html::linkActions($actions, $d->id) !!}</td>
                            @endif
                            <td>{{ $d->name }}</td>
                            <td>{{ $d->modules->implode('label', ', ') }}</td>
                            <td>{{ $d->permissions->implode('name', ', ') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('hak-akses'))->links() }}
                    </div>

                    <!-- <div class="col-6 text-right" style="margin-top: 8px">
                        {!! Html::linkCreate('hak-akses') !!}
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-warning">
        <!-- {!! trans('label.no_data_with_link', ['label' => 'Hak Akses', 'uri' => route('hak-akses.create')]) !!} -->
    </div>
    @endif
</div>
@endsection