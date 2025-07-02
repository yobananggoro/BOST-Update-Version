@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('content')
<div class="col-sm-6">
    <div class="card card-default">
        <div class="card-header text-center" style="font-size: 18px; font-weight: bold">Detail Transaksi</div>
        <div class="card-body">
            <div class="col-sm-12" style="font-size: 18px">
                <table cellspacing="0" cellpadding="0">
                    <tbody>
                        @foreach ($response_data as $keySrc => $value)
                            @if ($value['isDebits'] == true)
                                <tr>
                                    <td style="width: 200px; font-weight: bold">
                                        Rekening Sumber
                                    </td>
                                    <td style="width: 25px"> :</td>
                                    <td style="width: 500px">
                                        <b>
                                            @if ($value['rc'] == '00')
                                                {{ @$value['accountNumber'] }}
                                            @else
                                                {{ @$value['branch'] }} - {{ @$value['cif'] }} - {{ @$value['suffix'] }}
                                            @endif
                                        </b>
                                    </td>
                                </tr>
                                @if ($value['rc'] == '00')
                                    <tr>
                                        <td style="font-weight: bold">Nama</td>
                                        <td> :</td>
                                        <td>{{ @$value['accountName'] }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="font-weight: bold">Mata Uang</td>
                                    <td> :</td>
                                    <td>{{ @$value['currency'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nominal</td>
                                    <td> :</td>
                                    <td>{{ number_format(@$value['amount']) }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Terbilang</td>
                                    <td> :</td>
                                    <td><i>{{ terbilang(@$value['amount'], null, null, @$value['currency']) }}</i></td>
                                </tr>
                                @if ($value['rc'] == '00')
                                    <tr>
                                        <td style="font-weight: bold">Status Debit</td>
                                        <td> :</td>
                                        <td>{{ @$value['rcMsg'] }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td style="font-weight: bold">Status Debit</td>
                                        <td> :</td>
                                        <td>{{ @$value['rcMsg'][0]['messageDesc'] }}</td>
                                    </tr>
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
                            @endif
                        @endforeach
                        <!-- <tr>
                            <td>
                                <hr>
                            </td>
                            <td>
                                <hr>
                            </td>
                            <td>
                                <hr>
                            </td>
                        </tr> -->
                        @foreach ($response_data as $keyDst => $value)
                        @if ($value['isDebits'] == false)
                        <tr>
                            <td style="width: 200px; font-weight: bold">
                                Rekening Tujuan
                            </td>
                            <td style="width: 25px"> :</td>
                            <td style="width: 500px">
                                <b>
                                    @if ($value['isDebits'] == '00')
                                    {{ @$value['accountNumber'] }} /
                                    @endif
                                    {{ @$value['branch'] }} - {{ @$value['cif'] }} - {{ @$value['suffix'] }}
                                </b>
                            </td>
                        </tr>
                        @if ($value['rc'] == '00')
                        <tr>
                            <td style="font-weight: bold">Nama</td>
                            <td> :</td>
                            <td>{{ @$value['accountName'] }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td style="font-weight: bold">Mata Uang</td>
                            <td> :</td>
                            <td>{{ @$value['currency'] }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Nominal</td>
                            <td> :</td>
                            <td>{{ number_format(@$value['amount']) }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Terbilang</td>
                            <td> :</td>
                            <td><i>{{ terbilang(@$value['amount'], null, null, @$value['currency']) }}</i></td>
                        </tr>
                        @if ($value['rc'] == '00')
                        <tr>
                            <td style="font-weight: bold">Status Kredit</td>
                            <td> :</td>
                            <td>{{ @$value['rcMsg'] }}</td>
                        </tr>
                        @else
                        <tr>
                            <td style="font-weight: bold">Status Kredit</td>
                            <td> :</td>
                            <td style="color: red">{{ @$value['rcMsg'][0]['messageDesc'] }}</td>
                        </tr>
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
                        @endif
                        @endforeach
                        <tr>
                            <td style="font-weight: bold">Refference</td>
                            <td> :</td>
                            <td>{{ @$data['reff'] }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Nominal Total</td>
                            <td> :</td>
                            <td>{{ number_format(@$data['nominal']) }}</td>
                        </tr>
                        <!-- <tr>
                            <td style="font-weight: bold">Terbilang</td>
                            <td> :</td>
                            <td><i>{{ terbilang(@$data['nominal']) }}</i></td>
                        </tr> -->
                        <tr>
                            <td style="font-weight: bold">Keterangan</td>
                            <td> :</td>
                            <td>{{ @$additional_info['narative1'] }}</td><br>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ @$additional_info['narative2'] }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ @$additional_info['narative3'] }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ @$additional_info['narative4'] }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Status Transaksi</td>
                            <td> :</td>
                            <td>{{ $status_validasi_posting[$data->status_transaksi] }}</td>
                        </tr>
                        @if (@$data->status_transaksi == 3)
                        @if (@$data->response_http == 200)
                        <tr>
                            <td style="font-weight: bold">Informasi Transaksi</td>
                            <td> :</td>
                            <td>{{ @json_decode(@$data->response_message, true)['responseDesc'] }}</td>
                        </tr>
                        @else
                        <tr>
                            <td style="font-weight: bold">Informasi Transaksi</td>
                            <td> :</td>
                            <td>{{ @json_decode(@$data->response_message, true)['error'] }}</td>
                        </tr>
                        @endif
                        @else
                        <tr>
                            <td style="font-weight: bold">Informasi Transaksi</td>
                            <td> :</td>
                            <td>{{ @$data->response_message != null ? json_decode(@$data->response_message, true)['responseDesc'] : @$data->response_message }}
                            </td>
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