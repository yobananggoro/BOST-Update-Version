@extends('layouts.app')
@section('title', 'Upload File Data Many To Many')
@section('content')
<div class="row toastrDefaultInfo"></div>
<div class="row toastrDefaultError"></div>
<div class="col-sm-6">
    <div class="card card-default">
        <div class="card-header"></div>
        <form action="{{ url('upload-manytomany/validasi') }}" method="post" id="formAccount" role="form" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <input type="hidden" name="trxtype" value="MTM">
                <div class="col-12 form-group">
                    <label>Upload Bulk File <span style="color: red">*</span></label><br>
                    <input type="file" id="myfile" name="file">
                </div>
                <div class="col-12 form-group">
                    <label>Jenis Transaksi <span style="color: red">*</span></label>
                    <select id="getTrxList" name="trxName" class="form-control select2" style="width: 100%">
                    </select><br>
                    <div class="row">
                        <div class="col-6">
                            <label>Trx Debet</label>
                            <input type="text" name="dbCode" id="dbCode" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label>Trx Credit</label>
                            <input type="text" name="crCode" id="crCode" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-12 form-group">
                    <label>Refference</label>
                    <input type="text" name="reff" id="reff" class="form-control" value="{{@$reff}}" readonly>
                </div>
                <blockquote style="text-align: justify;text-justify: inter-word;hyphens: auto">
                    <p><strong>Catatan!</strong></p>
                    <p>
                        Pastikan gunakan template yang telah disediakan oleh sistem, tidak disarankan untuk menggunakan template yang
                        bukan berasal dari template default. Sebelum melakukan unduh file template silahkan hapus cache
                        browser terlebih dahulu agar dipastikan selalu mendapat versi terbaru.
                    </p>
                </blockquote>
                @include('addInfo')
            </div>
            <div class="card-footer clearfix">
                <div class="btn-group">
                    <button type="button" id="btnEnter" class="btn btn-sm btn-primary" rel="action" title="anda yakin?" style="width: 80px"><i class="fa fa-check"></i> Submit</button>
                </div>
                <div class="btn-group">
                    <button type="reset" class="btn btn-sm btn-danger" style="width: 80px"><i class="fa fa-redo"></i> Reset</button>
                </div>
                <div class="btn-group">
                    <a href="{{ url('upload-manytomany/download/template_bulk_agi_mtm.xlsx') }}" type="button" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Template Excel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection