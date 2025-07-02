@extends('layouts.app')
@section('title', 'Sistem Monitoring Balance ATM')
@section('content')
@include('simba::filter')
<div class="card card-default">
    <div class="card-header">
            @if (@$data['errorMessage'] != null || @$data['errorMessage'])
            <p style="text-align: right; font-size: 15pt;">
                Error : {{@$data['errorMessage']}}
            </p> 
            @endif
            <p style="text-align: right; font-size: 15pt;">
                Balance Minimum Limit : {{number_format(@$data['balanceMin'],2)}}
            </p>
    </div>
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Lokasi ATM</th>
                    <th>Id ATM</th>
                    <th>Branch Code</th>
                    <th>Balance</th>
                    <th>Last Update</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if (@$data != null)
                @foreach (@$data['data'] as $d)
                <tr>
                    <td>{{$d['description']}}</td>
                    <td>{{$d['idAtm']}}</td>
                    <td>{{$d['branchCode']}}</td>
                    <td>{{number_format($d['balance'])}}</td>
                    <td>{{$d['updatedAt']}}</td>
                    @if ($d['balance'] > $data['balanceMin'])
                    <td style="color: white; background-color: green">
                        AMAN
                    </td>
                    @else
                    <td style="color: white; background-color: red">
                        RENDAH
                    </td>
                    @endif
                </tr>
                @endforeach
                @endif
                
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        @if ($data != null)
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
                        <a href="/simba?page={{@$data['currentPage'] - 1}}" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
                            ‹
                        </a>
                    </li>
                    @endif
                    
                    <li class="paginate_button page-item next" id="example1_next">
                        <a href="/simba?page=0" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
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
                        <a href="/simba?page={{$i}}" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
                            {{$i + 1}}
                        </a>
                    </li>  
                    @else
                    <li class="paginate_button page-item">
                        <a href="/simba?page={{$i}}" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
                            {{$i + 1}}
                        </a>
                    </li>    
                    @endif
                    
                    @endif
                    @endfor
                    <li class="paginate_button page-item next" id="example1_next">
                        <a href="/simba?page={{@$data['totalPages'] -1}}" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
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
                        <a href="/simba?page={{@$data['currentPage'] + 1}}" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                            ›
                        </a>
                    </li>
                    @endif
                    
                </ul>
            </div>
        </div>
        <div class="col-md-6" style="text-align: left">
            <p>Total Data {{@$data['totalItems']}} Page  {{@$data['currentPage'] + 1}} Total Page {{@$data['totalPages']}}</p>
        </div>
        @endif
    </div>
</div>
@endsection