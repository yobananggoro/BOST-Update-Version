@extends('layouts.app')
@section('title', 'Upload File Data One To One HeadOffice')
@section('content')
<div class="row toastrDefaultInfo"></div>
<div class="row toastrDefaultError"></div>
<div class="col-sm-6">
    <div class="card card-default">
        <div class="card-header"></div>
        <form action="{{ url('upload-onetoone-ho/validasi') }}" method="post" id="formAccount" role="form" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <input type="hidden" name="trxtype" value="OTO">
                <div class="col-12 form-group">
                    <label>Bulk File<span style="color: red">*</span></label><br>
                    <input type="file" id="myfile" name="file">
                </div>

                <div class="col-12 form-group">
                    <label>Jenis Transaksi</label>
                    <select id="getTrxList" name="trxName" class="form-control select2">
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

                <blockquote>
                    <p>Catatan!</p>
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
                <!-- <div class="btn-group">
                    <button type="reset" class="btn btn-sm btn-danger" style="width: 80px"><i class="fa fa-redo"></i> Reset</button>
                </div> -->
                <div class="btn-group">
                    <a href="{{ url('upload-onetoone-ho') }}" type="button" class="btn btn-sm btn-danger" style="width: 80px"><i class="fa fa-redo"></i> Reload</a>
                </div>
                <div class="btn-group">
                    <a href="{{ url('upload-onetoone-ho/download/template_bulk_ita_ho.xlsx') }}" type="button" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Template Excel</a>
                </div>
                <!-- <button type="button" id="listRekening" class="btn btn-sm btn-default float-right" data-toggle="modal" data-target="#modal-xl" style="width: 150px; position: right">List Rekening</button> -->
            </div>
        </form>
    </div>
</div>
@endsection