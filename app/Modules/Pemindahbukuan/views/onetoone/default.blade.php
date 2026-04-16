@extends('layouts.app')
@section('title', 'Form Input One To One')
@section('content')
<div class="row toastrDefaultInfo"></div>
<div class="row toastrDefaultError"></div>
<div class="row">
    <div class="col-sm-6">
        <div class="card card-default">
            <div class="card-header">
            </div>
            <form action="{{ url('onetoone/validasi') }}" method="post" id="formAccount" role="form" class="form-horizontal">
                @csrf
                <div class="card-body">
                    <input type="hidden" name="accuseSrc" id="accuseSrc" value="{{ @$accuseSrc }}">
                    <input type="hidden" name="accuseDst" id="accuseDst" value="{{ @$accuseDst }}">
                    <div class="col-sm-12 form-group">
                        <label>Rekening Sumber <span style="color: red">*</span></label>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row col-sm-12">
                                    <input type="text" name="extSrc" id="extSrc" class="form-control number rekSumber" maxlength="13" placeholder="External Account">
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="branchSrc" id="branchSrc" class="form-control number rekSumber" maxlength="4" placeholder="Branch">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="cifSrc" id="cifSrc" class="form-control ucase rekSumber" maxlength="6" placeholder="CIF">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="suffixSrc" id="suffixSrc" class="form-control number rekSumber" maxlength="3" placeholder="Suffix">
                                        <input type="hidden" name="tipeSrc" id="tipeSrc" class="form-control detailSrc" readonly>
                                        <input type="hidden" name="namaSrc" id="namaSrc" class="form-control detailSrc" readonly>
                                        <input type="hidden" name="ccySrc" id="ccySrc" class="form-control detailSrc" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-info" onclick="detailSumber();"><i class="fa fa-info-circle"></i> Detail</button>
                                <button type="button" id="btnToogleSrc" class="btn btn-secondary" onclick="toogle(this.id);" title="Toogle Form"><i class="fa fa-recycle"></i></button>
                            </div>
                        </div>

                        <table style="margin-left: 30px; margin-top: 10px">
                            <tr>
                                <td style="width: 150px; font-weight: bold">Nama Rekening</td>
                                <td> :&nbsp;&nbsp;</td>
                                <td id="nama_sumber" class="detailSrc"></td>
                            </tr>
                            <tr>
                                <td style="width: 110px; font-weight: bold">Tipe Rekening</td>
                                <td> :&nbsp;&nbsp;</td>
                                <td id="tipe_rek_sumber" class="detailSrc"></td>
                            </tr>
                            <tr>
                                <td style="width: 110px; font-weight: bold">Mata Uang</td>
                                <td> :&nbsp;&nbsp;</td>
                                <td id="tipe_ccy_sumber" class="detailSrc"></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-12 form-group">
                        <label>Rekening Tujuan <span style="color: red">*</span></label>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row col-sm-12">
                                    <input type="text" name="extDst" id="extDst" class="form-control number rekTujuan" maxlength="13" placeholder="External Account">
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="branchDst" id="branchDst" class="form-control number rekTujuan" maxlength="4" placeholder="Branch">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="cifDst" id="cifDst" class="form-control ucase rekTujuan" maxlength="6" placeholder="CIF">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="suffixDst" id="suffixDst" class="form-control number rekTujuan" maxlength="3" placeholder="Suffix">
                                        <input type="hidden" name="tipeDst" id="tipeDst" class="form-control detailDst" readonly>
                                        <input type="hidden" name="namaDst" id="namaDst" class="form-control detailDst" readonly>
                                        <input type="hidden" name="ccyDst" id="ccyDst" class="form-control detailDst" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-info" onclick="detailTujuan();"><i class="fa fa-info-circle"></i> Detail</button>
                                <button type="button" id="btnToogleDst" class="btn btn-secondary" onclick="toogle(this.id);" title="Toogle Form"><i class="fa fa-recycle"></i></button>
                            </div>
                        </div>
                        <table style="margin-left: 30px; margin-top: 10px">
                            <tr>
                                <td style="width: 150px; font-weight: bold">Nama Rekening</td>
                                <td> :&nbsp;&nbsp;</td>
                                <td id="nama_tujuan" class="detailDst"></td>
                            </tr>
                            <tr>
                                <td style="width: 110px; font-weight: bold">Tipe Rekening</td>
                                <td> :&nbsp;&nbsp;</td>
                                <td id="tipe_rek_tujuan" class="detailDst"></td>
                            </tr>
                            <tr>
                                <td style="width: 110px; font-weight: bold">Mata Uang</td>
                                <td> :&nbsp;&nbsp;</td>
                                <td id="tipe_ccy_tujuan" class="detailDst"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 form-group">
                        <label>Refference</label>
                        <input type="text" name="reff" id="reff" class="form-control" value="{{ @$reff }}" readonly>
                    </div>
                    <div class="col-12 form-group">
                        <label>Nominal <span id="ccy_amount"></span><span style="color: red">*</span></label>
                        <input type="text" name="nominal_" id="nominal_" class="form-control currency text-right" placeholder="Nominal">
                        <input type="hidden" name="nominal" id="nominal" class="form-control text-right" readonly>
                        <input type="hidden" name="exchangeRate" id="exchangeRate" class="form-control text-right" readonly>
                    </div>
                    <div id="rates_fields"></div>
                    <div class="col-12">
                        <label>Keterangan</label>
                        <input type="text" name="narative3" id="narative3" class="form-control nar" placeholder="Narative 3">
                    </div>
                    <div class="col-12 form-group">
                        <label></label>
                        <input type="text" name="narative4" id="narative4" class="form-control nar" placeholder="Narative 4">
                    </div>
                    <div class="col-12">
                        <label>User Code</label>
                        <select id="getUserCodeList" name="usercode_desc" class="form-control select2">
                        </select><br>
                        <div class="row form-group">
                            <div class="col-6">
                                <input type="text" name="userCode1" id="userCode1" class="form-control" readonly>
                            </div>
                            <div class="col-6">
                                <input type="text" name="userCode2" id="userCode2" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="col-12">
                        <div class="btn-group">
                            <button type="button" id="btnEnter" class="btn btn-sm btn-primary" style="width: 80px"><i class="fa fa-check"></i> Submit</button>
                        </div>
                        <div class="btn-group">
                            <button type="reset" class="btn btn-sm btn-danger" style="width: 80px"><i class="fa fa-redo"></i> Reset</button>
                        </div>
                        <div class="btn-group float-right">
                            <button type="button" id="listRekening" class="btn btn-sm btn-secondary " data-toggle="modal" data-target="#modal-xl" style="width: 150px; position: right">List Rekening</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('prompt.promptRekening')
@endsection