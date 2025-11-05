@extends('layouts.app')
@section('title', 'Transaksi List')
@section('content')
@include('pemindahbukuan::transaksi-list.filter')
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" style="width: 115%">
                        <thead>
                            <tr>
                                <th style="width:30px">Aksi</th>
                                <th style="width:10px">No.</th>
                                <th style="width:160px">Refference</th>
                                <th style="width:250px">Transaksi</th>
                                <th style="width:150px;text-align:right">Nominal</th>
                                <th style="width:130px">User Maker</th>
                                <th style="width:100px">User Oto</th>
                                <th style="width:160px">Status Oto</th>
                                <th style="width:140px">Status Transaksi</th>
                                <th style="width:180px">Tanggal Transaksi</th>
                                <th style="width:180px">Tanggal Otorisasi</th>
                                @if(auth()->user()->profile->rolename == "SUPER ADMIN")
                                <th>Cabang</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1
                            @endphp
                            @foreach($data as $d)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('transaksi-list.show', $d->id) }}" class="btn btn-info btn-sm" title="Detail" style="width:40px; margin-right: 5px"><i class="fa fa-info"></i></a>
                                    </div>
                                </td>
                                <td>{{ $i++ }}.</td>
                                <td>{{ $d->reff }}</td>
                                <td>Pemindahbukuan {{ $tipe_transaksi[$d->tipe_transaksi] }}</td>
                                <td class="text-right">{{ number_format($d->nominal, 2) }}</td>
                                <td>{{ $d->userid }}</td>
                                <td>{{ $d->user_override }}</td>
                                <td>{{ $status_approval[$d->status_override] }}</td>
                                <td>{{ $status_validasi_posting[$d->status_transaksi] }}</td>
                                <td>{{ date('d M Y H:i:s', strtotime($d->created_at)) }}</td>
                                @if($d->created_at != $d->updated_at)
                                <td>{{ date('d M Y H:i:s', strtotime($d->updated_at)) }}</td>
                                @else
                                <td></td>
                                @endif
                                @if(auth()->user()->profile->rolename == "SUPER ADMIN")
                                <td>{{ $d->unitKerja->nama }}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-6">
                    {{ $data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('transaksi-list'))->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection