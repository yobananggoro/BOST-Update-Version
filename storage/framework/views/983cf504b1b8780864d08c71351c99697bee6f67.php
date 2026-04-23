
<?php $__env->startSection('title', 'Validasi One To One'); ?>
<?php $__env->startSection('content'); ?>

<div class="col-sm-6">
    <div class="card card-default">
        <form action="<?php echo e(route('onetoone.store')); ?>" method="post" role="form" class="form-horizontal">
            <?php echo csrf_field(); ?>
            <div class="card-header text-center" style="font-size: 18px; font-weight: bold">Verifikasi Transaksi</div>
            <div class="card-body">
                <div class="form-group" style="display: ">
                    <input type="text" name="branchSrc" value="<?php echo e(@$data[0]['branchSrc']); ?>" maxlength="4" readonly>
                    <input type="text" name="cifSrc" value="<?php echo e(@$data[0]['cifSrc']); ?>" maxlength="6" readonly>
                    <input type="text" name="suffixSrc" value="<?php echo e(@$data[0]['suffixSrc']); ?>" maxlength="3" readonly>
                    <input type="text" name="extSrc" value="<?php echo e(@$data[0]['extSrc']); ?>" readonly>
                    <input type="text" name="tipeSrc" value="<?php echo e(@$data[0]['tipeSrc']); ?>" maxlength="2" readonly>
                    <input type="text" name="namaSrc" value="<?php echo e(@$data[0]['sourceAccountName']); ?>" readonly>
                    <input type="text" name="ccySrc" value="<?php echo e(@$data[0]['ccySrc']); ?>" readonly>
                    <input type="text" name="accuseSrc" value="<?php echo e(@$data[0]['accuseSrc']); ?>" readonly>
                    <input type="text" name="codeSrc" value="<?php echo e(@$data[0]['codeSrc']); ?>" readonly>

                    <input type="text" name="branchDst" value="<?php echo e(@$data[0]['branchDst']); ?>" maxlength="4" readonly>
                    <input type="text" name="cifDst" value="<?php echo e(@$data[0]['cifDst']); ?>" maxlength="6" readonly>
                    <input type="text" name="suffixDst" value="<?php echo e(@$data[0]['suffixDst']); ?>" maxlength="3" readonly>
                    <input type="text" name="extDst" value="<?php echo e(@$data[0]['extDst']); ?>" maxlength="3" readonly>
                    <input type="text" name="tipeDst" value="<?php echo e(@$data[0]['tipeDst']); ?>" maxlength="2" readonly>
                    <input type="text" name="namaDst" value="<?php echo e(@$data[0]['destinationAccountName']); ?>" readonly>
                    <input type="text" name="ccyDst" value="<?php echo e(@$data[0]['ccyDst']); ?>" readonly>
                    <input type="text" name="accuseDst" value="<?php echo e(@$data[0]['accuseDst']); ?>" readonly>
                    <input type="text" name="codeDst" value="<?php echo e(@$data[0]['codeDst']); ?>" readonly>

                    <input type="text" name="reff" value="<?php echo e(@$data[0]['reff']); ?>" id="reff" readonly>
                    <input type="text" name="nominal" value="<?php echo e(@$data[0]['nominal']); ?>" id="nominal" readonly>
                    <input type="text" name="narative1" value="<?php echo e(@$data[0]['narative1']); ?>" readonly>
                    <input type="text" name="narative2" value="<?php echo e(@$data[0]['narative2']); ?>" readonly>
                    <input type="text" name="narative3" value="<?php echo e(@$data[0]['narative3']); ?>" readonly>
                    <input type="text" name="narative4" value="<?php echo e(@$data[0]['narative4']); ?>" readonly>

                    <?php if(($data[0]['ccySrc'] == 'IDR' && $data[0]['ccyDst'] != 'IDR') || ($data[0]['ccySrc'] != 'IDR' && $data[0]['ccyDst'] == 'IDR')): ?>
                    <input type="text" name="nominalSrc" value="<?php echo e(@$data[0]['amountSrc']); ?>" readonly>    
                    <input type="text" name="nominalDst" value="<?php echo e(@$data[0]['amountDst']); ?>" readonly>
                    <input type="text" name="exchangeRate" value="<?php echo e(@$data[0]['exchangeRate']); ?>" readonly>
                    <?php endif; ?>

                    <input type="text" name="instrumentCode" value="<?php echo e(@$data[0]['instrumentCode']); ?>" readonly> 
                    <input type="text" name="instrumentOther" value="<?php echo e(@$data[0]['instrumentOther']); ?>" readonly> 
                    <input type="text" name="classificationCode" value="<?php echo e(@$data[0]['classificationCode']); ?>" readonly> 
                    <input type="text" name="classificationOther" value="<?php echo e(@$data[0]['classificationOther']); ?>" readonly> 
                    <input type="text" name="purposeCode" value="<?php echo e(@$data[0]['purposeCode']); ?>" readonly>
                    <input type="text" name="purposeOther" value="<?php echo e(@$data[0]['purposeOther']); ?>" readonly>
                    <input type="text" name="sourceCode" value="<?php echo e(@$data[0]['sourceCode']); ?>" readonly>
                    <input type="text" name="sourceOther" value="<?php echo e(@$data[0]['sourceOther']); ?>" readonly>
                    <input type="text" name="destinationCode" value="<?php echo e(@$data[0]['destinationCode']); ?>" readonly>
                    <input type="text" name="destinationOther" value="<?php echo e(@$data[0]['destinationOther']); ?>" readonly>
                    <input type="text" name="remark" value="<?php echo e(@$data[0]['remark']); ?>" readonly>
                </div>
                <div class="row" style="font-size: 17px">
                    <div class="col-sm-12">
                        <table cellspacing="0" cellpadding="1" style="width: 100%">
                            <tbody>
                                <tr>
                                    <td style="width: 160px; font-weight: bold">Rekening Sumber</td>
                                    <td style="width: 25px"> :</td>
                                    <td><b><?php echo e(@$data[0]['sourceAccount']); ?></b></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nama</td>
                                    <td> :</td>
                                    <td><?php echo e(@$data[0]['sourceAccountName']); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Tipe Rekening</td>
                                    <td> :</td>
                                    <td><?php echo e(@$data[0]['tipeSrc']); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Mata Uang</td>
                                    <td> :</td>
                                    <td><?php echo e(@$data[0]['ccySrc']); ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <hr>
                                    </td>
                                    <td>
                                        <hr>
                                    </td>
                                    <td>
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Rekening Tujuan</td>
                                    <td> :</td>
                                    <td><b><?php echo e(@$data[0]['destinationAccount']); ?></b></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nama</td>
                                    <td> :</td>
                                    <td><?php echo e(@$data[0]['destinationAccountName']); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Tipe Rekening</td>
                                    <td> :</td>
                                    <td><?php echo e(@$data[0]['tipeDst']); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Mata Uang</td>
                                    <td> :</td>
                                    <td><?php echo e(@$data[0]['ccyDst']); ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <hr>
                                    </td>
                                    <td>
                                        <hr>
                                    </td>
                                    <td>
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Refference</td>
                                    <td> :</td>
                                    <td><?php echo e(@$data[0]['reff']); ?></td>
                                </tr>
                                <?php if(@$data[0]['ccySrc'] != @$data[0]['ccyDst']): ?>
                                    <tr>
                                        <td style="font-weight: bold">Nominal <?php echo e(@$data[0]['ccySrc']); ?></td>
                                        <td> :</td>
                                        <td style="font-weight: bold; text-align: right"><?php echo e(number_format(@$data[0]['amountSrc'], 2, '.', ',')); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold">Nominal <?php echo e(@$data[0]['ccyDst']); ?></td>
                                        <td> :</td>
                                        <td style="font-weight: bold; text-align: right"><?php echo e(number_format(@$data[0]['amountDst'], 2, '.', ',')); ?></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td style="font-weight: bold">Nominal Transaksi</td>
                                        <td> :</td>
                                        <td style="font-weight: bold; text-align: right"><?php echo e(number_format(@$data[0]['nominal'], 2, '.', ',')); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td style="font-weight: bold">Terbilang</td>
                                    <td> :</td>
                                    <td><i><?php echo e(terbilang(@$data[0]['nominal'], null, null, @$data[0]['ccySrc'])); ?></i></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Keterangan</td>
                                    <td> :</td>
                                    <td><?php echo e(is_null(@$data[0]['narative1']) ? '-':@$data[0]['narative1']); ?></td><br>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> :</td>
                                    <td><?php echo e(is_null(@$data[0]['narative2']) ? '-':@$data[0]['narative2']); ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> :</td>
                                    <td><?php echo e(is_null(@$data[0]['narative3']) ? '-':@$data[0]['narative3']); ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> :</td>
                                    <td><?php echo e(is_null(@$data[0]['narative4']) ? '-':@$data[0]['narative4']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer clearfix">
                <div class="btn-group">
                    <button type="submit" class="btn btn-sm btn-primary" style="width: 80px">Submit</button>
                </div>
                <div class="btn-group">
                    <a href="<?php echo e(url('onetoone')); ?>" type="button" class="btn btn-sm btn-warning" style="width: 80px">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Pemograman\laragon\www\apuppt\app\Modules\Pemindahbukuan\Providers/../views/onetoone/validate.blade.php ENDPATH**/ ?>