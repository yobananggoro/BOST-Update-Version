@extends('layouts.app')
@section('title', 'Profile')
@section('content')
{{-- <div class="col-6">
    <div class="card card-success">
        <div class="card-body">
            {{ Form::fgText('Hak Akses', '', $data->roles->pluck('name')->first(), ['class' => 'form-control', 'readonly' => true], null, 'text', true) }}
            {{ Form::fgText('Username', 'username', $data->username, ['class' => 'form-control', 'readonly' => true], null, 'text', true) }}
            {{ Form::fgText('Nama', 'nama', $data->profile->nama, ['class' => 'form-control', 'readonly' => true], null, 'text', true) }}
            {{ Form::fgText('NIP', 'nip', $data->profile->nip, ['class' => 'form-control', 'readonly' => true], null, 'text', true) }}
            {{ Form::fgText('Email', 'email', $data->email, ['class' => 'form-control', 'readonly' => true], null, 'text', true) }}
            {{ Form::fgText('Unit Kerja', 'unit_kerja_kode', $data->profile->unitKerja->nama, ['class' => 'form-control', 'readonly' => true], null, 'text', true) }}
            {{ Form::fgText('Limit Debet', 'limit_debet', number_format($data->profile->limit_debet, 2), ['class' => 'form-control text-right', 'readonly' => true], null, 'text', true) }}
            {{ Form::fgText('Limit Kredit', 'limit_kredit', number_format($data->profile->limit_debet, 2), ['class' => 'form-control text-right', 'readonly' => true], null, 'text', true) }}
        </div>
        <div class="card-footer">
        </div>
    </div>
</div> --}}
<div class="col-6">
    <div class="card card-default">
        <div class="card-body">
            <table class="table table-striped" style="font-weight: bold; font-size: 18px;line-height: 15px">
                <tbody>
                    <tr>
                        <td style="width: 150px">Username</td>
                        <td style="width: 1px">:</td>
                        <td>{{ $data->username }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $data->profile->nama }}</td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td>{{ $data->profile->nip }}</td>
                    </tr>
                    <tr>
                        <td>Unit Kerja</td>
                        <td>:</td>
                        <td>{{ $data->profile->unitKerja->nama }}</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>{{ $data->profile->jabatan }}</td>
                    </tr>
                    <tr>
                        <td>Hak Akses</td>
                        <td>:</td>
                        <td>{{ $data->roles->pluck('name')->first() }}</td>
                    </tr>
                    <tr>
                        <td>Limit Debet</td>
                        <td>:</td>
                        <td>{{ number_format($data->profile->limit_debet, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Limit Kredit</td>
                        <td>:</td>
                        <td>{{ number_format($data->profile->limit_kredit, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Fingerprint</td>
                        <td>:</td>
                        <td>{{ $data->profile->isFinger == true ? 'True':'False' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 