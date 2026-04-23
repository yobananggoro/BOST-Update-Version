
<?php $__env->startSection('title', 'Validasi One To Many'); ?>
<?php $__env->startSection('content'); ?>

<div class="col-sm-6">
    <div class="card card-default">
        <form action="<?php echo e(route('manytoone.store')); ?>" method="post" role="form" class="form-horizontal">
            <?php echo csrf_field(); ?>
            <div class="card-header text-center" style="font-size: 18px; font-weight: bold">Verifikasi Transaksi</div>
            <div class="card-body">
                <div class="form-group" style="display: none">
                    <?php $__currentLoopData = $data['rekening_sumber']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dbt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="text" name="branchSrc[]" value="<?php echo e(@$data['rekening_sumber'][$key]['branchSrc']); ?>" maxlength="4" readonly>
                    <input type="text" name="cifSrc[]" value="<?php echo e(@$data['rekening_sumber'][$key]['cifSrc']); ?>" maxlength="6" readonly>
                    <input type="text" name="suffixSrc[]" value="<?php echo e(@$data['rekening_sumber'][$key]['suffixSrc']); ?>" maxlength="3" readonly>
                    <input type="text" name="extSrc[]" value="<?php echo e(@$data['rekening_sumber'][$key]['extSrc']); ?>" readonly>
                    <input type="text" name="tipeSrc[]" value="<?php echo e(@$data['rekening_sumber'][$key]['tipeSrc']); ?>" maxlength="2" readonly>
                    <input type="text" name="namaSrc[]" value="<?php echo e(@$data['rekening_sumber'][$key]['namaSrc']); ?>" readonly>
                    <input type="text" name="ccySrc[]" value="<?php echo e(@$data['rekening_sumber'][$key]['ccySrc']); ?>" readonly>
                    <input type="text" name="nominalSrc[]" value="<?php echo e(@$data['rekening_sumber'][$key]['nominalSrc']); ?>" readonly>
                    <input type="text" name="accuseSrc[]" value="<?php echo e(@$data['rekening_sumber'][$key]['accuseSrc']); ?>" readonly>
                    <hr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <hr>

                    <?php $__currentLoopData = $data['rekening_tujuan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="text" name="branchDst" value="<?php echo e(@$data['rekening_tujuan'][$key]['branchDst']); ?>" maxlength="4" readonly>
                    <input type="text" name="cifDst" value="<?php echo e(@$data['rekening_tujuan'][$key]['cifDst']); ?>" maxlength="6" readonly>
                    <input type="text" name="suffixDst" value="<?php echo e(@$data['rekening_tujuan'][$key]['suffixDst']); ?>" maxlength="3" readonly>
                    <input type="text" name="extDst" value="<?php echo e(@$data['rekening_tujuan'][$key]['extDst']); ?>" readonly>
                    <input type="text" name="tipeDst" value="<?php echo e(@$data['rekening_tujuan'][$key]['tipeDst']); ?>" maxlength="2" readonly>
                    <input type="text" name="namaDst" value="<?php echo e(@$data['rekening_tujuan'][$key]['namaDst']); ?>" readonly>
                    <input type="text" name="ccyDst" value="<?php echo e(@$data['rekening_tujuan'][$key]['ccyDst']); ?>" readonly>
                    <input type="text" name="nominalDst" value="<?php echo e(@$data['rekening_tujuan'][$key]['nominalDst']); ?>" readonly>
                    <input type="text" name="nominalDst_" value="<?php echo e(@$data['rekening_tujuan'][$key]['nominalDst_']); ?>" readonly>
                    <input type="text" name="accuseDst" value="<?php echo e(@$data['rekening_tujuan'][$key]['accuseDst']); ?>" readonly>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <hr>
                    
                    <!-- <input type="text" name="limit" value="<?php echo e(auth()->user()->profile->limit_kredit); ?>" readonly> -->
                    <input type="text" name="reff" value="<?php echo e(@$data['reff']); ?>" readonly>
                    <input type="text" name="nominal_total" value="<?php echo e(@$data['nominal']); ?>" readonly>
                    <input type="text" name="narative1" value="<?php echo e(@$data['narative1']); ?>" readonly>
                    <input type="text" name="narative2" value="<?php echo e(@$data['narative2']); ?>" readonly>
                    <input type="text" name="narative3" value="<?php echo e(@$data['narative3']); ?>" readonly>
                    <input type="text" name="narative4" value="<?php echo e(@$data['narative4']); ?>" readonly>
                </div>
                <div class="col-sm-12" style="font-size: 17px">
                    <table cellspacing="0" cellpadding="0">
                        <tbody>
                            <?php $__currentLoopData = $data['rekening_sumber']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dbt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="width: 200px; font-weight: bold">Rekening Sumber <?php echo e($key == 0 ? "" : $key+1); ?></td>
                                    <td style="width: 25px"> :</td>
                                    <td style="width: 500px"><b><?php echo e(@$data['rekening_sumber'][$key]['sourceAccount']); ?></b></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nama</td>
                                    <td> :</td>
                                    <td><?php echo e(@$data['rekening_sumber'][$key]['namaSrc']); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Tipe Rekening</td>
                                    <td> :</td>
                                    <td><?php echo e(@$data['rekening_sumber'][$key]['tipeSrc']); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Mata Uang</td>
                                    <td> :</td>
                                    <td><?php echo e(@$data['rekening_sumber'][$key]['ccySrc']); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nominal</td>
                                    <td> :</td>
                                    <td><?php echo e(number_format(@$data['rekening_sumber'][$key]['nominalSrc'])); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Terbilang</td>
                                    <td> :</td>
                                    <td><i><?php echo e(terbilang(@$data['rekening_sumber'][$key]['nominalSrc'], null, null, @$data['rekening_sumber'][0]['ccySrc'])); ?></i></td>
                                </tr>
                                <tr>
                                    <td><hr></td>
                                    <td><hr></td>
                                    <td><hr></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php $__currentLoopData = $data['rekening_tujuan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="font-weight: bold">Rekening Tujuan <?php echo e($key == 0 ? "" : $key+1); ?></td>
                                    <td> :</td>
                                    <td><b><?php echo e(@$data['rekening_tujuan'][$key]['destinationAccount']); ?></b></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nama</td>
                                    <td> :</td>
                                    <td><?php echo e(@$data['rekening_tujuan'][$key]['namaDst']); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Tipe Rekening</td>
                                    <td> :</td>
                                    <td><?php echo e(@$data['rekening_tujuan'][$key]['tipeDst']); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Mata Uang</td>
                                    <td> :</td>
                                    <td><?php echo e(@$data['rekening_tujuan'][$key]['ccyDst']); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nominal</td>
                                    <td> :</td>
                                    <td><?php echo e(number_format(@$data['rekening_tujuan'][$key]['nominalDst'])); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Terbilang</td>
                                    <td> :</td>
                                    <td><i><?php echo e(terbilang(@$data['rekening_tujuan'][$key]['nominalDst'], null, null, @$data['rekening_tujuan'][0]['ccyDst'])); ?></i></td>
                                </tr>
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
                            <tr>
                                <td style="font-weight: bold">Terbilang</td>
                                <td> :</td>
                                <td><?php echo e(terbilang(@$data['nominal'], null, null, @$data['rekening_tujuan'][0]['ccyDst'])); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Keterangan</td>
                                <td> :</td>
                                <td><?php echo e(@$data['narative1']); ?></td><br>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><?php echo e(@$data['narative2']); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><?php echo e(@$data['narative3']); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><?php echo e(@$data['narative4']); ?></td> 
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn-group">
                    <button type="submit" class="btn btn-sm btn-primary" style="width: 80px">Submit</button>
                </div>
                <div class="btn-group">
                    <a href="<?php echo e(url('onetomany')); ?>" type="button" class="btn btn-sm btn-warning" style="width: 80px">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Pemograman\laragon\www\usercodes\app\Modules\Pemindahbukuan\Providers/../views/manytoone/validate.blade.php ENDPATH**/ ?>