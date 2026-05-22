@extends('layouts.app')
@section('title', 'Validasi One To Many')
@section('content')
{{-- {{$data}}  --}}
<div class="col-sm-6">
    <div class="card card-default">
        <form action="{{ route('onetomany.store') }}" method="post" role="form" class="form-horizontal">
            @csrf
            <div class="card-header text-center" style="font-size: 18px; font-weight: bold">Verifikasi Transaksi</div>
            <div class="card-body">
                <div class="form-group" style="display: none">
                    @foreach($data['rekening_sumber'] as $key => $dbt)
                    <input type="text" name="branchSrc" value="{{ @$data['rekening_sumber'][$key]['branchSrc'] }}" maxlength="4" readonly>
                    <input type="text" name="cifSrc" value="{{ @$data['rekening_sumber'][$key]['cifSrc'] }}" maxlength="6" readonly>
                    <input type="text" name="suffixSrc" value="{{ @$data['rekening_sumber'][$key]['suffixSrc'] }}" maxlength="3" readonly>
                    <input type="text" name="extSrc" value="{{ @$data['rekening_sumber'][$key]['extSrc'] }}" readonly>
                    <input type="text" name="tipeSrc" value="{{ @$data['rekening_sumber'][$key]['tipeSrc'] }}" maxlength="2" readonly>
                    <input type="text" name="namaSrc" value="{{ @$data['rekening_sumber'][$key]['namaSrc'] }}" readonly>
                    <input type="text" name="ccySrc" value="{{ @$data['rekening_sumber'][$key]['ccySrc'] }}" readonly>
                    <input type="text" name="nominalSrc" value="{{ @$data['rekening_sumber'][$key]['nominalSrc'] }}" readonly>
                    <input type="text" name="nominalSrc_" value="{{ @$data['rekening_sumber'][$key]['nominalSrc_'] }}" readonly>
                    <input type="text" name="accuseSrc" value="{{ @$data['rekening_sumber'][$key]['accuseSrc'] }}" readonly>
                    @endforeach
                    <hr>

                    @foreach($data['rekening_tujuan'] as $key => $cr)
                    <input type="text" name="branchDst[]" value="{{ @$data['rekening_tujuan'][$key]['branchDst'] }}" maxlength="4" readonly>
                    <input type="text" name="cifDst[]" value="{{ @$data['rekening_tujuan'][$key]['cifDst'] }}" maxlength="6" readonly>
                    <input type="text" name="suffixDst[]" value="{{ @$data['rekening_tujuan'][$key]['suffixDst'] }}" maxlength="3" readonly>
                    <input type="text" name="extDst[]" value="{{ @$data['rekening_tujuan'][$key]['extDst'] }}" readonly>
                    <input type="text" name="tipeDst[]" value="{{ @$data['rekening_tujuan'][$key]['tipeDst'] }}" maxlength="2" readonly>
                    <input type="text" name="namaDst[]" value="{{ @$data['rekening_tujuan'][$key]['namaDst'] }}" readonly>
                    <input type="text" name="ccyDst[]" value="{{ @$data['rekening_tujuan'][$key]['ccyDst'] }}" readonly>
                    <input type="text" name="nominalDst[]" value="{{ @$data['rekening_tujuan'][$key]['nominalDst'] }}" readonly>
                    <input type="text" name="accuseDst[]" value="{{ @$data['rekening_tujuan'][$key]['accuseDst'] }}" readonly>
                    <hr>
                    @endforeach
                    
                    <!-- <input type="text" name="limit" value="{{ auth()->user()->profile->limit_kredit }}" readonly> -->
                    <input type="text" name="reff" value="{{ @$data['reff'] }}" readonly>
                    <input type="text" name="nominal_total" value="{{ @$data['nominal'] }}" readonly>
                    <input type="text" name="narative1" value="{{ @$data['narative1'] }}" readonly>
                    <input type="text" name="narative2" value="{{ @$data['narative2'] }}" readonly>
                    <input type="text" name="narative3" value="{{ @$data['narative3'] }}" readonly>
                    <input type="text" name="narative4" value="{{ @$data['narative4'] }}" readonly>

                    <input type="text" name="instrumentCode" value="{{@$data['instrumentCode']}}" readonly> 
                    <input type="text" name="instrumentOther" value="{{@$data['instrumentOther']}}" readonly> 
                    <input type="text" name="classificationCode" value="{{@$data['classificationCode']}}" readonly> 
                    <input type="text" name="classificationOther" value="{{@$data['classificationOther']}}" readonly> 
                    <input type="text" name="purposeCode" value="{{@$data['purposeCode']}}" readonly>
                    <input type="text" name="purposeOther" value="{{@$data['purposeOther']}}" readonly>
                    <input type="text" name="sourceCode" value="{{@$data['sourceCode']}}" readonly>
                    <input type="text" name="sourceOther" value="{{@$data['sourceOther']}}" readonly>
                    <input type="text" name="destinationCode" value="{{@$data['destinationCode']}}" readonly>
                    <input type="text" name="destinationOther" value="{{@$data['destinationOther']}}" readonly>
                    <input type="text" name="remark" value="{{@$data['remark']}}" readonly>
                </div>
                <div class="col-sm-12" style="font-size: 17px">
                    <table cellspacing="0" cellpadding="0">
                        <tbody>
                            @foreach($data['rekening_sumber'] as $key => $dbt)
                                <tr>
                                    <td style="width: 200px; font-weight: bold">Rekening Sumber</td>
                                    <td style="width: 25px"> :</td>
                                    <td style="width: 500px"><b>{{@$data['rekening_sumber'][$key]['sourceAccount']}}</b></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nama</td>
                                    <td> :</td>
                                    <td>{{@$data['rekening_sumber'][$key]['namaSrc']}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Tipe Rekening</td>
                                    <td> :</td>
                                    <td>{{@$data['rekening_sumber'][$key]['tipeSrc']}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Mata Uang</td>
                                    <td> :</td>
                                    <td>{{@$data['rekening_sumber'][$key]['ccySrc']}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nominal</td>
                                    <td> :</td>
                                    <td style="font-weight: bold; text-align: right">{{number_format(@$data['rekening_sumber'][$key]['nominalSrc'], 2, '.', ',')}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Terbilang</td>
                                    <td> :</td>
                                    <td><i>{{ terbilang(@$data['rekening_sumber'][$key]['nominalSrc'], null, null, @$data['rekening_sumber'][$key]['ccySrc']) }}</i></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td><hr></td>
                                <td><hr></td>
                                <td><hr></td>
                            </tr>
                            @foreach($data['rekening_tujuan'] as $key => $cr)
                                <tr>
                                    <td style="font-weight: bold">Rekening Tujuan {{ $key == 0 ? "" : $key+1 }}</td>
                                    <td> :</td>
                                    <td><b>{{@$data['rekening_tujuan'][$key]['destinationAccount']}}</b></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nama</td>
                                    <td> :</td>
                                    <td>{{@$data['rekening_tujuan'][$key]['namaDst']}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Tipe Rekening</td>
                                    <td> :</td>
                                    <td>{{@$data['rekening_tujuan'][$key]['tipeDst']}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Mata Uang</td>
                                    <td> :</td>
                                    <td>{{@$data['rekening_tujuan'][$key]['ccyDst']}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nominal</td>
                                    <td> :</td>
                                    <td style="font-weight: bold; text-align: right">{{number_format(@$data['rekening_tujuan'][$key]['nominalDst'], 2, '.', ',')}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Terbilang</td>
                                    <td> :</td>
                                    <td><i>{{ terbilang(@$data['rekening_tujuan'][$key]['nominalDst'], null, null, @$data['rekening_tujuan'][$key]['ccyDst']) }}</i></td>
                                </tr>
                                <!-- <tr>
                                    <td style="font-weight: bold">Status Validate</td>
                                    <td> :</td>
                                    <td>{{@$data['rekening_tujuan'][$key]['status']}}</td>
                                </tr> -->
                                <tr>
                                    <td><hr></td>
                                    <td><hr></td>
                                    <td><hr></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td style="font-weight: bold">Refference</td>
                                <td> :</td>
                                <td>{{@$data['reff']}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Nominal Total</td>
                                <td> :</td>
                                <td style="font-weight: bold; text-align: right">{{number_format(@$data['nominal'], 2, '.', ',')}}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Terbilang</td>
                                <td> :</td>
                                <td><i>{{ terbilang(@$data['nominal'], null, null, @$data['rekening_sumber'][0]['ccySrc']) }}</i></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Keterangan</td>
                                <td> :</td>
                                <td>{{@$data['narative1']}}</td><br>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{@$data['narative2']}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{@$data['narative3']}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{@$data['narative4']}}</td> 
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn-group">
                    <button type="submit" class="btn btn-sm btn-primary" style="width: 80px">Submit</button>
                </div>
                <div class="btn-group">
                    <a href="{{url('onetomany')}}" type="button" class="btn btn-sm btn-warning" style="width: 80px">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection