
<?php $__env->startSection('title', 'View Signature'); ?>
<?php $__env->startSection('content'); ?>
<div class="row toastrDefaultInfo"></div>
<div class="row toastrDefaultError"></div>
<div class="col-5">
    <div class="card card-default">
        <form action="<?php echo e(url('view-signature/checkImage')); ?>" method="post" id="formAccount" role="form" class="form-horizontal">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <input type="hidden" name="accuse" id="accuse" value="external" readonly>
                <input type="hidden" name="cif_cust" id="cif_cust" value="<?php echo e(@$request->cif_cust); ?>" readonly>
                <input type="hidden" name="cif_name" id="cif_name" value="<?php echo e(@$request->cif_name); ?>" readonly>
                <div class="col-sm-12">
                    <label>Account <span style="color: red">*</span></label>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="row col-sm-12">
                                <input type="text" name="ext" id="ext" class="form-control number" value="<?php echo e(@$request->ext); ?>" maxlength="13" placeholder="External Account">
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="text" name="branch" id="branch" class="form-control number" value="<?php echo e(@$request->branch); ?>" maxlength="4" placeholder="Branch">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="cif" id="cif" class="form-control ucase" value="<?php echo e(@$request->cif); ?>" maxlength="6" placeholder="CIF">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="suffix" id="suffix" class="form-control number" value="<?php echo e(@$request->suffix); ?>" maxlength="3" placeholder="Suffix">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-info" onclick="detail();"><i class="fa fa-info-circle"></i> Detail</button>
                        </div>
                    </div>

                    <fieldset style="background-color: #eeeeee; padding: 2px; margin-top: 20px">
                        <table style="margin-left: 20px">
                            <tr>
                                <td style="width: 130px">Customer</td>
                                <td style="width: 10px; display: block">:</td>
                                <td id="cust"></td>
                            </tr>
                            <tr>
                                <td>Customer Name</td>
                                <td style="width: 10px; display: block">:</td>
                                <td id="cust_name"></td>
                            </tr>

                        </table><br>
                        <table style="margin-left: 20px">
                            <tr>
                                <td>Image List</td>
                                <td></td>
                                <td id="list"></td>
                            </tr>
                            <tr>
                                <?php if(isset($data)): ?>
                                <?php $__currentLoopData = @$data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td style="margin-bottom: 20px;">
                                    <?php if(!empty($value['img'])): ?>
                                    <span style="margin: 0px; padding-right: 2px"><img class="imgThumb" style="border-style:solid;border-width:1px" width="150px" height="100px" data-id="<?php echo e($value['id']); ?>" src="data:image/png;base64,<?php echo e($value['img']); ?>"></span>
                                    <div id="zoomArea_<?php echo e($value['id']); ?>" style="position:absolute;display:none;z-index:10;border-style:solid;border-width:1px"><img id="zoomImg_<?php echo e($value['id']); ?>" width="350px" height="300px" src=""></div>
                                    <?php else: ?>
                                    <p><i>Tidak ada gambar.</i></p>
                                    <?php endif; ?>
                                </td>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tr>
                        </table>
                    </fieldset>
                </div>
            </div>
            <div class="card-footer clearfix">
                <button type="submit" id="btnEnter" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
                <a href="<?php echo e(url('view-signature')); ?>" type="button" class="btn btn-sm btn-danger"><i class="fa fa-redo"></i> Reset</a>
                <button type="button" id="btnToogle" class="btn btn-sm btn-secondary" onclick="toogle(this.id);"><i class="fa fa-recycle"></i> Toogle Account</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/Signature/Providers/../views/view_signature.blade.php ENDPATH**/ ?>