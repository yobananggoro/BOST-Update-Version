@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('content')
<div class="row toastrDefaultInfo"></div>
<div class="row toastrDefaultError"></div>
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
                                {{ $key == 0 ? '' : $key + 1 }}
                            </td>
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
                        <tr>
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
                            <td id="kolom_status_trx_">{{ $status_validasi_posting[$data->status_transaksi] }}</td>
                            <td id="kolom_status_trx" style="display: none">Posting <span id="sttsTrx"></span></td>
                        </tr>
                        <!-- Bagian yang muncul saat halaman pertama kali dimuat (Sisi Server) -->
                        <tr id="kolom_informasi_trx_">
                            <td style="font-weight: bold">Informasi Transaksi</td>
                            <td> :</td>
                            <td>
                                @if (@$data->status_transaksi == 3)
                                    @if (@$data->response_http == 200)
                                        @if (isset($response_message['responseCode']) && $response_message['responseCode'] == '00')
                                        <span class="badge bg-success" id="badge_server_success">
                                            {{ @json_decode($data->response_message, true)['responseDesc'] }}
                                        </span>
                                        @else
                                        <span class="badge bg-danger">
                                            {{ $response_data['0']['message'] ?? 'Failed Transaksi' }}
                                        </span>
                                        @endif
                                    @else
                                    <span class="badge bg-danger">
                                        {{ @json_decode($data->response_message, true)['error'] ?? 'HTTP Error' }}
                                    </span>
                                    @endif
                                @else
                                <span class="badge bg-success" id="badge_server_default">
                                    {{ @$data->response_message != null ? json_decode($data->response_message, true)['responseDesc'] : $data->response_message }}
                                </span>
                                @endif
                            </td>
                        </tr>

                        <!-- Bagian Tiruan/Dummy untuk kebutuhan AJAX (Awalnya disembunyikan menggunakan style tabel yang benar) -->
                        <tr id="kolom_informasi_trx" style="display: none;">
                            <td style="font-weight: bold">Informasi Transaksi</td>
                            <td> :</td>
                            <td>
                                <!-- Tambahkan id pada badge agar warnanya (hijau/merah) bisa kita ubah secara dinamis via JS -->
                                <span id="informasi_trx"></span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="btn-group">
                <a href=" {{ url('transaksi-list') }}" type="button" class="btn btn-sm btn-warning float-left"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="btn-group">
                @if(strtolower(@$response_message['data'][0]['message']) === 'timeout backend' && in_array(auth()->user()->profile->rolename,["Operator","SUPER ADMIN"]))
                <button id="btnStatus" class="btn btn-sm btn-info" onclick="cek()"><i class="fas fa-search"></i> Cek Status</button>
                
                <!-- <form action="{{ url('cek-status-transaksi') }}" method="post" id="formCekstatus">
                    @csrf -->
                    <!-- <button class="btn btn-sm btn-info" onclick="cek()"><i class="fas fa-search"></i> Cek Status</button> -->
                    <input type="hidden" name="numbreff" id="numbreff" value="{{ @$data['reff'] }}">
                    <input type="hidden" name="msgStatus" id="msgStatus">
                    <input type="hidden" name="rcStatus" id="rcStatus">
                <!-- </form> -->
                @endif
            </div>
        </div>
    </div>
</div>
@endsection