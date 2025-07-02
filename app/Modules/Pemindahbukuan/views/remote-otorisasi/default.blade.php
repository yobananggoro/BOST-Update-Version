@extends('layouts.app')
@section('title', 'Remote Otorisasi')
@section('content')
@include('pemindahbukuan::remote-otorisasi.filter')
@if(count($data))
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>                  
                        <tr>
                            <th style="width:30px">Aksi</th>
                            <th style="width:10px">No.</th> 
                            <th style="width:180px">Nomor Refference</th>
                            <th style="width:250px">Nama Transaksi</th>
                            <th style="width:150px;text-align:center">Nominal</th>
                            <th style="width:110px">User Maker</th>
                            <th style="width:160px">Status Otorisasi</th>
                            <th style="width:140px">Status Transaksi</th>
                            <th style="width:180px">Tanggal Transaksi</th>
                            <th>Cabang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1
                        @endphp
                        @foreach($data as $d)
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('remote-otorisasi.show', $d->id) }}" class="btn btn-info btn-sm" title="Verifikasi" style="width:40px; margin-right: 5px"><i class="fas fa-info"></i></a>
                                </div>
                            </td>  
                            <td>{{ $i++ }}.</td>
                            <td>{{ $d->reff }}</td>
                            <td>Pemindahbukuan {{ $tipe_transaksi[$d->tipe_transaksi] }}</td>
                            <td class="text-right">{{ number_format($d->nominal, 2) }}</td>
                            <td>{{ $d->userid }}</td>
                            <td>{{ $status_approval[$d->status_override] }}</td>
                            <td>{{ $status_validasi_posting[$d->status_transaksi] }}</td>
                            <td>{{ date('d M Y H:i:s', strtotime($d->created_at)) }}</td> 
                            <td>{{ $d->unitKerja->nama }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table> 
            </div>
            <div class="card-footer">
                <div class="col-6">
                    {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('remote-otorisasi'))->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning col-6">
    <b>Belum ada data transaksi per hari ini.</b>
</div>
@endif
@endsection