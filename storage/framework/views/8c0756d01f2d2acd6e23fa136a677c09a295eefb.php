
<?php $__env->startSection('title', 'Detail Transaksi'); ?>
<?php $__env->startSection('content'); ?>
<div class="col-sm-6">
    <div class="card card-default"> 
        <form action="<?php echo e(url('remote-otorisasi/approval')); ?>" method="post" role="form" class="form-horizontal">
            <?php echo csrf_field(); ?>
            <div class="card-header text-center" style="font-size: 18px; font-weight: bold">Detail Data Transaksi</div>
            <div class="card-body">
                <div class="col-sm-12" style="font-size: 18px">
                    <div class="form-group" style="display: none">
                        <input type="hidden" name="id" value="<?php echo e(@$data->id); ?>" readonly>
                        <input type="hidden" name="reff" value="<?php echo e(@$data['reff']); ?>" readonly>
                        <input type="hidden" name="tipe_transaksi" value="<?php echo e(@$data->tipe_transaksi); ?>" readonly>
                        <input type="hidden" name="total_nominal" value="<?php echo e(@$data['nominal']); ?>" readonly>
                        
                    </div>
                    <table cellspacing="0" cellpadding="0">
                        <tbody>
                            <?php $__currentLoopData = $additional_info['rekening_sumber']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dbt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="width: 200px; font-weight: bold">Rekening Sumber <?php echo e($key == 0 ? "" : $key+1); ?></td>
                                <td style="width: 25px"> :</td>
                                <td style="width: 500px"><b><?php if(@$dbt['accuseSrc'] == 'external'): ?> <?php echo e(@$dbt['extSrc']); ?>  <?php else: ?> <?php echo e(@$dbt['branchSrc']); ?> - <?php echo e(@$dbt['cifSrc']); ?> - <?php echo e(@$dbt['suffixSrc']); ?> <?php endif; ?></b></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Nama</td>
                                <td> :</td>
                                <td><?php echo e(@$dbt['namaSrc']); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Tipe Rekening</td>
                                <td> :</td>
                                <td><?php echo e(@$dbt['tipeSrc']); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Mata Uang</td>
                                <td> :</td>
                                <td><?php echo e(@$dbt['ccySrc']); ?></td>
                            </tr>
                            <?php if(!empty(@$dbt['nominalSrc'])): ?>
                            <tr>
                                <td style="font-weight: bold">Nominal</td>
                                <td> :</td>
                                <td><?php echo e(number_format(@$dbt['nominalSrc'])); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Terbilang</td>
                                <td> :</td>
                                <td><i><?php echo e(terbilang(@$dbt['nominalSrc'], null, null, @$dbt['ccySrc'])); ?></i></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td><hr></td>
                                <td><hr></td>
                                <td><hr></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php $__currentLoopData = $additional_info['rekening_tujuan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="font-weight: bold">Rekening Tujuan <?php echo e($key == 0 ? "" : $key+1); ?></td>
                                <td> :</td>
                                <td><b><?php if(@$cr['accuseDst'] == 'external'): ?> <?php echo e(@$cr['extDst']); ?> <?php else: ?> <?php echo e(@$cr['branchDst']); ?> - <?php echo e(@$cr['cifDst']); ?> - <?php echo e(@$cr['suffixDst']); ?> <?php endif; ?></b></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Nama</td>
                                <td> :</td>
                                <td><?php echo e(@$cr['namaDst']); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Tipe Rekening</td>
                                <td> :</td>
                                <td><?php echo e(@$cr['tipeDst']); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Mata Uang</td>
                                <td> :</td>
                                <td><?php echo e(@$cr['ccyDst']); ?></td>
                            </tr>
                            <?php if(!empty(@$cr['nominalDst'])): ?>
                            <tr>
                                <td style="font-weight: bold">Nominal</td>
                                <td> :</td>
                                <td><?php echo e(number_format(@$cr['nominalDst'])); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Terbilang</td>
                                <td> :</td>
                                <td><i><?php echo e(terbilang(@$cr['nominalDst'], null, null, @$cr['ccyDst'])); ?></i></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td><hr></td>
                                <td><hr></td>
                                <td><hr></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="font-weight: bold">Refference</td>
                                <td> :</td>
                                <td><?php echo e(@$data['reff']); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Nominal Total</td>
                                <td> :</td>
                                <td><?php echo e(number_format(@$data['nominal'])); ?></td>
                            </tr>
                            <!-- <tr>
                                <td style="font-weight: bold">Terbilang</td>
                                <td> :</td>
                                <td><i><?php echo e(terbilang(@$data['nominal'])); ?></i></td>
                            </tr> -->
                            <tr>
                                <td style="font-weight: bold">Keterangan</td>
                                <td> :</td>
                                <td><?php echo e(@$additional_info['narative1']); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><?php echo e(@$additional_info['narative2']); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><?php echo e(@$additional_info['narative3']); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><?php echo e(@$additional_info['narative4']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <span class="metadata" id="isFinger" title="<?php echo e(auth()->user()->profile->isFinger == true ? '1':'0'); ?>"></span>
                <?php if((hasModulePermission('remote-otorisasi')) && ($data->status_override == 1)): ?>
                    <?php if(auth()->user()->profile->isFinger == true): ?>
                        <?php echo $__env->make('fingerstatus::otoFinger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                
                    <div class="btn-group">
                        <button type="button" id="btnApprove" class="btn btn-sm btn-primary col-sm-12" style="width: 80px">Setujui</button>
                        <button type="submit" id="approveBTN" class="btn btn-sm btn-default col-sm-12" name="subject" value="approve" style="display: none"></button>
                    </div>
                    <div class="btn-group">
                        <button type="button" id="btnReject" class="btn btn-sm btn-danger col-sm-12" style="width: 80px">Tolak</button>
                        <button type="submit" id="rejectBTN" class="btn btn-sm btn-default col-sm-12" name="subject" value="reject" style="display: none"></button>
                    </div>
                <?php endif; ?>
                <a href="<?php echo e(url('remote-otorisasi')); ?>" type="button" class="btn btn-sm btn-warning float-right" style="width: 80px">Kembali</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/Pemindahbukuan/Providers/../views/remote-otorisasi/detail.blade.php ENDPATH**/ ?>