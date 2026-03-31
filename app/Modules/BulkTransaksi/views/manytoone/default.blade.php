@extends('layouts.app')
@section('title', 'Upload File Data Many To One')
@section('content')
<div class="row toastrDefaultInfo"></div>
<div class="row toastrDefaultError"></div>
<div class="col-sm-6">
    <div class="card card-default">
        <div class="card-header"></div>
        <form action="{{ url('upload-manytoone/validasi') }}" method="post" id="formAccount" role="form" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="col-12">
                    <label>Rekening Sumber Bulk File<span style="color: red">*</span></label><br>
                    <input type="file" id="myfile" name="file">
                </div><br>
                <div class="col-sm-12">
                    <input type="hidden" name="accuse" id="accuse" value="{{$accuse}}">
                    <input type="hidden" name="trxtype" value="MTO">
                    <label>Rekening Tujuan <span style="color: red">*</span></label>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row col-sm-12">
                                <input type="text" name="ext" id="extDst" class="form-control number rekTujuan" maxlength="13" placeholder="External Account">
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="text" name="branch" id="branchDst" class="form-control number rekTujuan" maxlength="4" placeholder="Branch">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="cif" id="cifDst" class="form-control ucase rekTujuan" maxlength="6" placeholder="CIF">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="suffix" id="suffixDst" class="form-control number rekTujuan" maxlength="3" placeholder="Suffix">
                                    <input type="hidden" name="tipe" id="tipeDst" class="form-control detailDst" readonly>
                                    <input type="hidden" name="nama" id="namaDst" class="form-control detailDst" readonly>
                                    <input type="hidden" name="ccy" id="ccyDst" class="form-control detailDst" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-info" onclick="detailTujuan();"><i class="fa fa-info-circle"></i> Detail</button>
                            <button type="button" id="btnToogleDst" class="btn btn-secondary" onclick="toogle(this.id);" title="Toogle Form"><i class="fa fa-recycle"></i></button>
                        </div>
                    </div>

                    <table style="margin-left: 30px; margin-top: 10px">
                        <tr>
                            <td style="width: 150px; font-weight: bold">Nama Rekening</td>
                            <td> :&nbsp;&nbsp;</td>
                            <td id="nama_tujuan" class="detailSrc"></td>
                        </tr>
                        <tr>
                            <td style="width: 110px; font-weight: bold">Tipe Rekening</td>
                            <td> :&nbsp;&nbsp;</td>
                            <td id="tipe_rek_tujuan" class="detailSrc"></td>
                        </tr>
                        <tr>
                            <td style="width: 110px; font-weight: bold">Mata Uang</td>
                            <td> :&nbsp;&nbsp;</td>
                            <td id="tipe_ccy_tujuan" class="detailSrc"></td>
                        </tr>
                    </table>
                </div><br>
                <div class="col-12">
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
                </div><br>
                <div class="col-12">
                    <label>Refference</label>
                    <input type="text" name="reff" id="reff" class="form-control" value="{{@$reff}}" readonly>
                </div><br>
                <div class="col-12">
                    <label>Nominal <span style="color: red">*</span></label>
                    <input type="text" name="nominal_" id="nominal_" class="form-control currency text-right" placeholder="Nominal">
                    <input type="hidden" name="nominal" id="nominal" class="form-control text-right" readonly>
                </div><br>
                <div class="col-12">
                    <label>Keterangan</label>
                    <input type="text" name="narative3" id="narative3" class="form-control nar" maxlength="35" placeholder="Narative 3">
                </div>
                <div class="col-12">
                    <label></label>
                    <input type="text" name="narative4" id="narative4" class="form-control nar" maxlength="35" placeholder="Narative 4">
                </div>
                <blockquote>
                    <p>Catatan!</p>
                    <p>
                        Pastikan gunakan template yang telah disediakan oleh sistem, tidak disarankan untuk menggunakan template yang
                        bukan berasal dari template default. Sebelum melakukan unduh file template silahkan hapus cache
                        browser terlebih dahulu agar dipastikan selalu mendapat versi terbaru.
                    </p>
                </blockquote>
            </div>
            <div class="card-footer clearfix">
                <div class="btn-group">
                    <button type="button" id="btnEnter" class="btn btn-sm btn-primary" rel="action" title="anda yakin?" style="width: 80px"><i class="fa fa-check"></i> Submit</button>
                </div>
                <div class="btn-group">
                    <button type="reset" class="btn btn-sm btn-danger" style="width: 80px"><i class="fa fa-redo"></i> Reset</button>
                </div>
                <div class="btn-group">
                    <a href="{{ url('upload-manytoone/download/template_bulk_agi.xlsx') }}" type="button" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Template Excel</a>
                </div>
                <button type="button" id="listRekening" class="btn btn-sm btn-default float-right" data-toggle="modal" data-target="#modal-xl" style="width: 150px; position: right">List Rekening</button>
            </div>
        </form>
    </div>
</div>
@include('prompt.promptRekening')
@endsection