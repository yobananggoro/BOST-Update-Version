
<?php $__env->startSection('title', 'Form Input Many To One'); ?>
<?php $__env->startSection('content'); ?>
<input type="hidden" id="dynamicField" value="<?php echo e(config('app.dynamic_field_rows')); ?>" readonly>
<div class="row toastrDefaultInfo"></div>
<div class="row toastrDefaultError"></div>
<div class="row">
    <div class="col-sm-6">
        <div class="card card-default">
            <div class="card-header">
            </div>
            <form action="<?php echo e(url('manytoone/validasi')); ?>" method="post" id="formAccount" role="form" class="form-horizontal">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <input type="hidden" name="trxtype" id="trxtype" value="MTO">
                    <div class="col-12 form-group">
                        <input type="hidden" name="accuseSrc[]" id="accuseSrc1" value="<?php echo e(@$accuseSrc1); ?>">
                        <label>Rekening Sumber <span style="color: red">*</span></label>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row col-sm-12">
                                    <input type="text" name="extSrc[]" id="extSrc1" class="form-control number rekSumber" maxlength="13" placeholder="External Account">
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="branchSrc[]" id="branchSrc1" class="form-control number rekSumber" maxlength="4" placeholder="Branch">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="cifSrc[]" id="cifSrc1" class="form-control ucase rekSumber" maxlength="6" placeholder="CIF">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="suffixSrc[]" id="suffixSrc1" class="form-control number rekSumber" maxlength="3" placeholder="Suffix">
                                        <input type="hidden" name="tipeSrc[]" id="tipeSrc1" class="form-control detailSrc1" readonly>
                                        <input type="hidden" name="namaSrc[]" id="namaSrc1" class="form-control detailSrc1" readonly>
                                        <input type="hidden" name="ccySrc[]" id="ccySrc1" class="form-control detailSrc1" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-info" value="1" onclick="detailSumber(this);"><i class="fa fa-fw fa-info-circle"></i> Detail</button>
                                <button type="button" id="btnToogleDst1" class="btn btn-secondary" onclick="toogle(this.id);" title="Toogle Form"><i class="fa fa-recycle"></i></button>
                                <button type="button" id="dynamic-ar" onclick="dynamicField()" class="btn btn-primary" style="width:40px"><i class="fa fa-plus"></i></button>
                                <button type="button" onclick="deleteField()" class="btn btn-danger removeField" style="width: 40px; display: none"><i class="fa fa-trash"></i></button>
                            </div>
                            <div class="col-7" style="margin-top: 10px">
                                <input type="text" id="nominalSrc1" class="form-control currency text-right" onkeyup="nomsumber(this)" placeholder="Nominal Sumber">
                                <input type="hidden" id="nominalSrc1_" name="nominalSrc[]" class="form-control nomsumber text-right" readonly>
                            </div>
                        </div>
                        <table style="margin-left: 30px; margin-top: 10px">
                            <tr>
                                <td style="width: 150px; font-weight: bold">Nama Rekening</td>
                                <td> :&nbsp;&nbsp;</td>
                                <td id="nama_sumber1" class="detailSrc"></td>
                            </tr>
                            <tr>
                                <td style="width: 110px; font-weight: bold">Tipe Rekening</td>
                                <td> :&nbsp;&nbsp;</td>
                                <td id="tipe_rek_sumber1" class="detailSrc"></td>
                            </tr>
                            <tr>
                                <td style="width: 110px; font-weight: bold">Mata Uang</td>
                                <td> :&nbsp;&nbsp;</td>
                                <td id="tipe_ccy_sumber1" class="detailSrc"></td>
                            </tr>
                        </table>
                    </div>

                    <div id="dynamicAddRemove">
                    </div>

                    <div class="col-12 form-group">
                        <input type="hidden" name="accuseDst" id="accuseDst" value="<?php echo e(@$accuseDst); ?>">
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
                        <label>Total Nominal Sumber</label>
                        <div class="row">
                            <div class="col-12">
                                <input type="text" id="total_" class="form-control total currency text-right" Placeholder="Total Nominal Sumber" readonly>
                                <input type="hidden" name="total" id="total" class="form-control total text-right" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 form-group">
                        <label>Nominal Tujuan</label>
                        <div class="row">
                            <div class="col-12">
                                <input type="text" name="nominalDst_" id="nominalDst_" class="form-control currency text-right" Placeholder="Nominal Tujuan">
                                <input type="hidden" name="nominalDst" id="nominalDst" class="form-control text-right" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 form-group">
                        <label>Refference</label>
                        <input type="text" name="reff" id="reff" class="form-control" value="<?php echo e(@$reff); ?>" readonly>
                    </div>

                    <div class="col-12 form-group">
                        <label>Keterangan</label>
                        <input type="text" name="narative1" id="narative1" class="form-control nar" maxlength="35" placeholder="Narative 1">
                    </div>
                    <div class="col-12 form-group">
                        <input type="text" name="narative2" id="narative2" class="form-control nar" maxlength="35" placeholder="Narative 2">
                    </div>
                    <div class="col-12 form-group">
                        <input type="text" name="narative3" id="narative3" class="form-control nar" maxlength="35" placeholder="Narative 3">
                    </div>
                    <div class="col-12 form-group">
                        <input type="text" name="narative4" id="narative4" class="form-control nar" maxlength="35" placeholder="Narative 4">
                    </div>
                    <?php echo $__env->make('addInfo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="card-footer clearfix">
                    <div class="margin">
                        <div class="btn-group">
                            <button type="submit" id="btnEnter" class="btn btn-sm btn-primary" style="width: 80px"><i class="fa fa-check"></i> Submit</button>
                        </div>
                        <div class="btn-group">
                            <button type="reset" class="btn btn-sm btn-danger" style="width: 80px"><i class="fa fa-redo"></i> Reset</button>
                        </div>
                        <div class="btn-group float-right">
                            <button type="button" id="listRekening" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal-xl" style="width: 150px; position: right">List Rekening</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo $__env->make('prompt.promptRekening', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Pemograman\laragon\www\apuppt\app\Modules\Pemindahbukuan\Providers/../views/manytoone/default.blade.php ENDPATH**/ ?>