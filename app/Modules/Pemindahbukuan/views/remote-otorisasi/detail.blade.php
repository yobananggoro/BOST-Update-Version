@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('content')
<div class="col-sm-6">
    <div class="card card-default"> 
        <form action="{{ url('remote-otorisasi/approval') }}" method="post" role="form" class="form-horizontal">
            @csrf
            <div class="card-header text-center" style="font-size: 18px; font-weight: bold">Detail Data Transaksi</div>
            <div class="card-body">
                <div class="col-sm-12" style="font-size: 17px">
                    <div class="form-group" style="display: none">
                        <input type="hidden" name="id" value="{{@$data->id}}" readonly>
                        <input type="hidden" name="reff" value="{{@$data['reff']}}" readonly>
                        <input type="hidden" name="tipe_transaksi" value="{{@$data->tipe_transaksi}}" readonly>
                        <input type="hidden" name="total_nominal" value="{{@$data['nominal']}}" readonly>
                        
                    </div>
                    <table cellspacing="0" cellpadding="1" style="width: 100%">
                        <tbody>
                            @foreach($additional_info['rekening_sumber'] as $key => $dbt)
                            <tr>
                                <td style="width: 200px; font-weight: bold">Rekening Sumber {{ $key == 0 ? "" : $key+1 }}</td>
                                <td style="width: 25px"> :</td>
                                <td style="width: 500px"><b>@if(@$dbt['accuseSrc'] == 'external') {{@$dbt['extSrc']}}  @else {{@$dbt['branchSrc']}} - {{@$dbt['cifSrc']}} - {{@$dbt['suffixSrc']}} @endif</b></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Nama</td>
                                <td> :</td>
                                <td>{{@$dbt['namaSrc']}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Tipe Rekening</td>
                                <td> :</td>
                                <td>{{@$dbt['tipeSrc']}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Mata Uang</td>
                                <td> :</td>
                                <td>{{@$dbt['ccySrc']}}</td>
                            </tr>
                            @if(!empty(@$dbt['nominalSrc']))
                            <tr>
                                <td style="font-weight: bold">Nominal</td>
                                <td> :</td>
                                <td style="font-weight: bold; text-align: right">{{number_format(@$dbt['nominalSrc'], 2, '.', ',')}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Terbilang</td>
                                <td> :</td>
                                <td><i>{{ terbilang(@$dbt['nominalSrc'], null, null, @$dbt['ccySrc']) }}</i></td>
                            </tr>
                            @endif
                            <tr>
                                <td><hr></td>
                                <td><hr></td>
                                <td><hr></td>
                            </tr>
                            @endforeach

                            @foreach($additional_info['rekening_tujuan'] as $key => $cr)
                            <tr>
                                <td style="font-weight: bold">Rekening Tujuan {{ $key == 0 ? "" : $key+1 }}</td>
                                <td> :</td>
                                <td><b>@if(@$cr['accuseDst'] == 'external') {{@$cr['extDst']}} @else {{@$cr['branchDst']}} - {{@$cr['cifDst']}} - {{@$cr['suffixDst']}} @endif</b></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Nama</td>
                                <td> :</td>
                                <td>{{@$cr['namaDst']}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Tipe Rekening</td>
                                <td> :</td>
                                <td>{{@$cr['tipeDst']}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Mata Uang</td>
                                <td> :</td>
                                <td>{{@$cr['ccyDst']}}</td>
                            </tr>
                            @if(!empty(@$cr['nominalDst']))
                            <tr>
                                <td style="font-weight: bold">Nominal</td>
                                <td> :</td>
                                <td style="font-weight: bold; text-align: right">{{number_format(@$cr['nominalDst'], 2, '.', ',')}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Terbilang</td>
                                <td> :</td>
                                <td><i>{{ terbilang(@$cr['nominalDst'], null, null, @$cr['ccyDst']) }}</i></td>
                            </tr>
                            @endif
                            <tr>
                                <td><hr></td>
                                <td><hr></td>
                                <td><hr></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td style="font-weight: bold">Nominal Total</td>
                                <td> :</td>
                                <td style="font-weight: bold; text-align: right">{{number_format(@$data['nominal'], 2, '.', ',')}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Refference</td>
                                <td> :</td>
                                <td>{{@$data['reff']}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Terbilang</td>
                                <td> :</td>
                                <td><i>{{terbilang(@$data['nominal'])}}</i></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Keterangan</td>
                                <td> :</td>
                                <td>{{@$additional_info['narative1']}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{@$additional_info['narative2']}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{@$additional_info['narative3']}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{@$additional_info['narative4']}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <span class="metadata" id="isFinger" title="{{ auth()->user()->profile->isFinger == true ? '1':'0' }}"></span>
                @if((hasModulePermission('remote-otorisasi')) && ($data->status_override == 1))
                    @if(auth()->user()->profile->isFinger == true)
                        @include('fingerstatus::otoFinger')
                    @endif
                
                    <div class="btn-group">
                        <button type="button" id="btnApprove" class="btn btn-sm btn-primary col-sm-12" style="width: 80px">Setujui</button>
                        <button type="submit" id="approveBTN" class="btn btn-sm btn-default col-sm-12" name="subject" value="approve" style="display: none"></button>
                    </div>
                    <div class="btn-group">
                        <button type="button" id="btnReject" class="btn btn-sm btn-danger col-sm-12" style="width: 80px">Tolak</button>
                        <button type="submit" id="rejectBTN" class="btn btn-sm btn-default col-sm-12" name="subject" value="reject" style="display: none"></button>
                    </div>
                @endif
                <a href="{{url('remote-otorisasi')}}" type="button" class="btn btn-sm btn-warning float-right" style="width: 80px">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection