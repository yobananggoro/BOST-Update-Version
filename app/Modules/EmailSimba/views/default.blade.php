@extends('layouts.app')
@section('title', 'Email Simba List')
@section('content')
@include('EmailSimba::filter')
<div class="card card-default">
    <div class="card-body">
        <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
            <thead>
                <tr>
                    @if(hasModulePermission('email-simba'))
                    <th>{{ __('label.action') }}</th>
                    @endif
                    <th>Branch Code</th>
                    <th>Email</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @if ($data != null)
                @foreach ($data['data'] as $d)
                <tr>
                    @if(hasModulePermission('email-simba'))
                    <td>{!! Html::linkUpdateDelete('email-simba', ['id' => $d['uuid'], 'label' => $d['email']]) !!}</td>
                    @endif
                    <td>{{$d['branchCode']}}</td>
                    <td>{{$d['email']}}</td>
                    {{-- <td>
                        {!! Html::linkUpdate('email-simba', $d['uuid'], $d['email']) !!}
                        {!! Html::linkDelete('email-simba', $d['uuid'], $d['email']) !!}
                    </td> --}}
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        <div class="row">
            <div class="col-md-6">
                <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate" style="align-content: flex-end">
                    <ul class="pagination">
                        @if ((@$data['currentPage']) <= 0 )
                        <li class="paginate_button page-item previous disabled" id="example1_previous">
                            <a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
                                ‹
                            </a>
                        </li>
                        @else
                        <li class="paginate_button page-item previous" id="example1_previous">
                            <a href="/email-simba?page={{@$data['currentPage'] - 1}}" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
                                ‹
                            </a>
                        </li>
                        @endif
                        
                        <li class="paginate_button page-item next" id="example1_next">
                            <a href="/email-simba?page=0" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                                First
                            </a>
                        </li>
                        @for ($i = 0; $i < @$data['totalPages']; $i++)
                        @php
                        $startpage = $data['currentPage'] - 2;
                        $endpage   = $data['currentPage'] + 2;
                        @endphp
                        @if ($i >= $startpage && $i <=$endpage)
                        
                        @if ($i == @$data['currentPage'])
                        <li class="paginate_button page-item active">
                            <a href="/email-simba?page={{$i}}" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
                                {{$i + 1}}
                            </a>
                        </li>  
                        @else
                        <li class="paginate_button page-item">
                            <a href="/email-simba?page={{$i}}" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
                                {{$i + 1}}
                            </a>
                        </li>    
                        @endif
                        
                        @endif
                        @endfor
                        <li class="paginate_button page-item next" id="example1_next">
                            <a href="/email-simba?page={{@$data['totalPages'] -1}}" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                                Last
                            </a>
                        </li>
                        @if ((@$data['currentPage'] + 1) >= @$data['totalPages'])
                        <li class="paginate_button page-item disabled" id="example1_next">
                            <a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                                ›
                            </a>
                        </li>
                        @else
                        <li class="paginate_button page-item next" id="example1_next">
                            <a href="/email-simba?page={{@$data['currentPage'] + 1}}" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                                ›
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-6 text-right">
                {!! Html::linkCreate('email-simba') !!}
            </div>
        </div>

        <div class="col-md-6">
            <p>Total Data {{@$data['totalItems']}} Page  {{@$data['currentPage'] + 1}} Total Page {{@$data['totalPages']}}</p>
        </div>
    </div>
</div>
@endsection