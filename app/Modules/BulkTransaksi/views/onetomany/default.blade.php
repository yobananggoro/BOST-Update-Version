@extends('layouts.app')
@section('title', 'Upload File Data One To Many')
@section('content')
<div class="row toastrDefaultInfo"></div>
<div class="row toastrDefaultError"></div>
<div class="row">
    <div class="col-sm-6">
        <div class="card card-default">
            <div class="card-header"></div>
            <form action="{{ url('upload-onetomany/validasi') }}" method="post" id="formAccount" role="form" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="col-sm-12">
                        <input type="hidden" name="accuse" id="accuse" value="{{$accuse}}">
                        <input type="hidden" name="trxtype" value="OTM">
                        <label>Rekening Sumber <span style="color: red">*</span></label>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row col-sm-12">
                                    <input type="text" name="ext" id="extSrc" class="form-control number rekSumber" maxlength="13" placeholder="External Account">
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="branch" id="branchSrc" class="form-control number rekSumber" maxlength="4" placeholder="Branch">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="cif" id="cifSrc" class="form-control ucase rekSumber" maxlength="6" placeholder="CIF">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="suffix" id="suffixSrc" class="form-control number rekSumber" maxlength="3" placeholder="Suffix">
                                        <input type="hidden" name="tipe" id="tipeSrc" class="form-control detailSrc" readonly>
                                        <input type="hidden" name="nama" id="namaSrc" class="form-control detailSrc" readonly>
                                        <input type="hidden" name="ccy" id="ccySrc" class="form-control detailSrc" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-info" onclick="detailSumber();"><i class="fa fa-info-circle"></i> Detail</button>
                                <button type="button" id="btnToogleSrc" class="btn btn-secondary" onclick="toogle(this.id);" title="Toogle Form"><i class="fa fa-recycle"></i></button>
                            </div>
                        </div>

                        <table style="margin-left: 30px; margin-top: 10px">
                            <tr>
                                <td style="width: 110px; font-weight: bold">Nama Account</td>
                                <td> :&nbsp;&nbsp;</td>
                                <td id="nama_sumber" class="detailSrc"></td>
                            </tr>
                            <tr>
                                <td style="width: 110px; font-weight: bold">Tipe Account</td>
                                <td> :&nbsp;&nbsp;</td>
                                <td id="tipe_rek_sumber" class="detailSrc"></td>
                            </tr>
                            <tr>
                                <td style="width: 110px; font-weight: bold">Currency</td>
                                <td> :&nbsp;&nbsp;</td>
                                <td id="tipe_ccy_sumber" class="detailSrc"></td>
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
                        <label>Transaksi Cheque?</label>
                        <div class="form-group">
                            <div class="form-check">
                                <div class="col-6">
                                    <div class="col-6">
                                        <input class="form-check-input" type="radio" name="isCheque" value="N" onclick="valCheque(this.value);" checked>
                                        <label class="form-check-label">Tidak</label>
                                    </div>
                                    <div class="col-6">
                                        <input class="form-check-input" type="radio" name="isCheque" value="Y" onclick="valCheque(this.value);">
                                        <label class="form-check-label">Ya</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="numbCheck">
                    </div>
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
                        <input type="text" name="narative4" id="narative4" class="form-control nar" maxlength="34" placeholder="Narative 4">
                    </div><br>
                    <div class="col-12">
                        <label>Rekening Tujuan Bulk File<span style="color: red">*</span></label><br>
                        <input type="file" id="myfile" name="file">
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
                        <a href="{{ url('upload-onetomany') }}" type="button" class="btn btn-sm btn-danger" style="width: 80px"><i class="fa fa-redo"></i> Reload</a>
                    </div>
                    <div class="btn-group">
                        <a href="{{ url('upload-onetomany/download/template_bulk_agi.xlsx') }}" type="button" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Template Excel</a>
                    </div>
                    <button type="button" id="listRekening" class="btn btn-sm btn-default float-right" data-toggle="modal" data-target="#modal-xl" style="width: 150px; position: right">List Rekening</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('prompt.promptRekening')
@endsection