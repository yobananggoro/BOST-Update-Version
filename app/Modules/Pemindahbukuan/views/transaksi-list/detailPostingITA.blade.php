@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('content')
    <div class="col-sm-6">
        <div class="card card-default">
            <div class="card-header text-center" style="font-size: 18px; font-weight: bold">Detail Transaksi</div>
            <div class="card-body">
                <div class="col-sm-12" style="font-size: 17px">
                    <table cellspacing="0" cellpadding="1" style="width: 700px">
                        <tbody>
                            @foreach ($additional_info['rekening_sumber'] as $key => $dbt)
                                <tr>
                                    <td style="width: 200px; font-weight: bold">Rekening Sumber
                                        {{ $key == 0 ? '' : $key + 1 }}</td>
                                    <td style="width: 25px"> :</td>
                                    <td style="width: 500px">
                                        <b>
                                            @if (@$dbt['accuseSrc'] == 'external')
                                                {{ @$dbt['extSrc'] }}
                                            @else
                                                {{ @$dbt['branchSrc'] }} - {{ @$dbt['cifSrc'] }} - {{ @$dbt['suffixSrc'] }}
                                            @endif
                                        </b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nama</td>
                                    <td> :</td>
                                    <td>{{ @$dbt['namaSrc'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Tipe Rekening</td>
                                    <td> :</td>
                                    <td>{{ @$dbt['tipeSrc'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Mata Uang</td>
                                    <td> :</td>
                                    <td>{{ @$dbt['ccySrc'] }}</td>
                                </tr>
                                @if (!empty(@$dbt['nominalSrc']))
                                    <tr>
                                        <td style="font-weight: bold">Nominal</td>
                                        <td> :</td>
                                        <td style="font-weight: bold; text-align: right">{{ number_format(@$dbt['nominalSrc'], 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold">Terbilang</td>
                                        <td> :</td>
                                        <td><i>{{ terbilang(@$dbt['nominalSrc'], null, null, @$dbt['ccySrc']) }}</i></td>
                                    </tr>

                                    <!-- @if (!is_null($response_message))
                                        <tr>
                                            <td style="font-weight: bold">Status DB</td>
                                            <td> :</td>
                                            <td>{{ @$dbt['status'] }}</td>
                                        </tr>
                                    @endif -->
                                @endif
                            @endforeach
                            <tr>
                                <td>
                                    <hr>
                                </td>
                                <td>
                                    <hr>
                                </td>
                                <td>
                                    <hr>
                                </td>
                            </tr>
                            @foreach ($additional_info['rekening_tujuan'] as $key => $cr)
                                <tr style="">
                                    <td style="font-weight: bold">Rekening Tujuan {{ $key == 0 ? '' : $key + 1 }}</td>
                                    <td> :</td>
                                    <td><b>
                                            @if (@$cr['accuseDst'] == 'external')
                                                {{ @$cr['extDst'] }}
                                            @else
                                                {{ @$cr['branchDst'] }} - {{ @$cr['cifDst'] }} - {{ @$cr['suffixDst'] }}
                                            @endif
                                        </b></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nama</td>
                                    <td> :</td>
                                    <td>{{ @$cr['namaDst'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Tipe Rekening</td>
                                    <td> :</td>
                                    <td>{{ @$cr['tipeDst'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Mata Uang</td>
                                    <td> :</td>
                                    <td>{{ @$cr['ccyDst'] }}</td>
                                </tr>
                                @if (!empty(@$cr['nominalDst']))
                                    <tr>
                                        <td style="font-weight: bold">Nominal</td>
                                        <td> :</td>
                                        <td style="font-weight: bold; text-align: right">{{ number_format(@$cr['nominalDst'], 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold">Terbilang</td>
                                        <td> :</td>
                                        <td><i>{{ terbilang(@$cr['nominalDst'], null, null, @$cr['ccyDst']) }}</i></td>
                                    </tr>
                                    <!-- @if (!is_null($response_message))
                                        <tr>
                                            <td style="font-weight: bold">Status KR</td>
                                            <td> :</td>
                                            <td>{{ @$cr['status'] }}</td>
                                        </tr>
                                    @endif -->
                                @endif
                                <tr>
                                    <td>
                                        <hr>
                                    </td>
                                    <td>
                                        <hr>
                                    </td>
                                    <td>
                                        <hr>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td style="font-weight: bold">Refference</td>
                                <td> :</td>
                                <td>{{ @$data['reff'] }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Nominal Total</td>
                                <td> :</td>
                                <td style="font-weight: bold; text-align: right">{{ number_format(@$data['nominal'], 2, '.', ',') }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Terbilang</td>
                                <td> :</td>
                                <td><i>{{ terbilang(@$data['nominal'], null, null, @$dbt['ccySrc']) }}</i></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Keterangan</td>
                                <td> :</td>
                                <td>{{ @$additional_info['narative1'] }}</td><br>
                            </tr>
                            <tr>
                                <td></td>
                                <td> :</td>
                                <td>{{ @$additional_info['narative2'] }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td> :</td>
                                <td>{{ @$additional_info['narative3'] }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td> :</td>
                                <td>{{ @$additional_info['narative4'] }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Status Transaksi</td>
                                <td> :</td>
                                <td>{{ $status_validasi_posting[$data->status_transaksi] }}</td>
                            </tr>
                            @if (@$data->status_transaksi == 3)
                                @if (@$data->response_http == 200)
                                    @if ($response_message['responseCode'] == '00')
                                        <tr>
                                            <td style="font-weight: bold">Informasi Transaksi</td>
                                            <td> :</td>
                                            <td><span class="badge bg-success">{{ @json_decode(@$data->response_message, true)['responseDesc'] }}</span></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td style="font-weight: bold">Informasi Transaksi</td>
                                            <td> :</td>
                                            <td><span class="badge bg-danger">{{ $response_data['0']['messageDesc'] }}</span></td>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <td style="font-weight: bold">Informasi Transaksi</td>
                                        <td> :</td>
                                        <td><span class="badge bg-danger">{{ @json_decode(@$data->response_message, true)['error'] }}</span></td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td style="font-weight: bold">Informasi Transaksi</td>
                                    <td> :</td>
                                    <td><span class="badge bg-success">{{ @$data->response_message != null ? json_decode(@$data->response_message, true)['responseDesc'] : @$data->response_message }}</span></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ url('transaksi-list') }}" type="button" class="btn btn-sm btn-default float-left"
                    style="width: 80px">Kembali</a>
            </div>
        </div>
    </div>
@endsection
