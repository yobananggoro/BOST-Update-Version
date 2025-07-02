@extends('layouts.app')
@section('title', 'Validasi One To One')
@section('content')
{{-- {{$data[0]}}  --}}
<div class="col-sm-6">
    <div class="card card-default">
        <form action="{{route('onetoone.store')}}" method="post" role="form" class="form-horizontal">
            @csrf
            <div class="card-header text-center" style="font-size: 18px; font-weight: bold">Verifikasi Transaksi</div>
            <div class="card-body">
                <div class="form-group" style="display: none">
                    <input type="text" name="branchSrc" value="{{@$data[0]['branchSrc']}}" maxlength="4" readonly>
                    <input type="text" name="cifSrc" value="{{@$data[0]['cifSrc']}}" maxlength="6" readonly>
                    <input type="text" name="suffixSrc" value="{{@$data[0]['suffixSrc']}}" maxlength="3" readonly>
                    <input type="text" name="extSrc" value="{{@$data[0]['extSrc']}}" readonly>
                    <input type="text" name="tipeSrc" value="{{@$data[0]['tipeSrc']}}" maxlength="2" readonly>
                    <input type="text" name="namaSrc" value="{{@$data[0]['sourceAccountName']}}" readonly>
                    <input type="text" name="ccySrc" value="{{@$data[0]['ccySrc']}}" readonly>
                    <input type="text" name="accuseSrc" value="{{@$data[0]['accuseSrc']}}" readonly>

                    <input type="text" name="branchDst" value="{{@$data[0]['branchDst']}}" maxlength="4" readonly>
                    <input type="text" name="cifDst" value="{{@$data[0]['cifDst']}}" maxlength="6" readonly>
                    <input type="text" name="suffixDst" value="{{@$data[0]['suffixDst']}}" maxlength="3" readonly>
                    <input type="text" name="extDst" value="{{@$data[0]['extDst']}}" maxlength="3" readonly>
                    <input type="text" name="tipeDst" value="{{@$data[0]['tipeDst']}}" maxlength="2" readonly>
                    <input type="text" name="namaDst" value="{{@$data[0]['destinationAccountName']}}" readonly>
                    <input type="text" name="ccyDst" value="{{@$data[0]['ccyDst']}}" readonly>
                    <input type="text" name="accuseDst" value="{{@$data[0]['accuseDst']}}" readonly>

                    <input type="text" name="reff" value="{{@$data[0]['reff']}}" id="reff" readonly>
                    <input type="text" name="nominal_" value="{{@$data[0]['nominal_']}}" id="nominal" readonly>
                    <input type="text" name="nominal" value="{{@$data[0]['nominal']}}" id="nominal" readonly>
                    <input type="text" name="narative1" value="{{@$data[0]['narative1']}}" readonly>
                    <input type="text" name="narative2" value="{{@$data[0]['narative2']}}" readonly>
                    <input type="text" name="narative3" value="{{@$data[0]['narative3']}}" readonly>
                    <input type="text" name="narative4" value="{{@$data[0]['narative4']}}" readonly>
                </div>   
                <div class="row" style="font-size: 17px">
                    <div class="col-sm-12">
                        <table cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td style="width: 160px; font-weight: bold">Rekening Sumber</td>
                                    <td style="width: 25px"> :</td>
                                    <td style="width: 500px"><b>{{@$data[0]['sourceAccount']}}</b></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nama</td>
                                    <td> :</td>
                                    <td>{{@$data[0]['sourceAccountName']}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Tipe Rekening</td>
                                    <td> :</td>
                                    <td>{{@$data[0]['tipeSrc']}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Mata Uang</td>
                                    <td> :</td>
                                    <td>{{@$data[0]['ccySrc']}}</td>
                                </tr>
                                <tr>
                                    <td><hr></td>
                                    <td><hr></td>
                                    <td><hr></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Rekening Tujuan</td>
                                    <td> :</td>
                                    <td><b>{{@$data[0]['destinationAccount']}}</b></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nama</td>
                                    <td> :</td>
                                    <td>{{@$data[0]['destinationAccountName']}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Tipe Rekening</td>
                                    <td> :</td>
                                    <td>{{@$data[0]['tipeDst']}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Mata Uang</td>
                                    <td> :</td>
                                    <td>{{@$data[0]['ccyDst']}}</td>
                                </tr>
                                <tr>
                                    <td><hr></td>
                                    <td><hr></td>
                                    <td><hr></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Refference</td>
                                    <td> :</td>
                                    <td>{{@$data[0]['reff']}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nominal</td>
                                    <td> :</td>
                                    <td>{{number_format(@$data[0]['nominal'])}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Terbilang</td>
                                    <td> :</td>
                                    <td><i>{{ terbilang(@$data[0]['nominal'], null, null, @$data[0]['ccyDst']) }}</i></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Keterangan</td>
                                    <td> :</td>
                                    <td>{{is_null(@$data[0]['narative1']) ? '-':@$data[0]['narative1']}}</td><br>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{is_null(@$data[0]['narative2']) ? '-':@$data[0]['narative2']}}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{is_null(@$data[0]['narative3']) ? '-':@$data[0]['narative3']}}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{is_null(@$data[0]['narative4']) ? '-':@$data[0]['narative4']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer clearfix">
                <div class="btn-group">
                    <button type="submit" class="btn btn-sm btn-primary" style="width: 80px">Submit</button>
                </div>
                <div class="btn-group">
                    <a href="{{url('onetoone')}}" type="button" class="btn btn-sm btn-warning" style="width: 80px">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection