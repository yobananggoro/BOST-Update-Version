
<?php $__env->startSection('title', 'Profile'); ?>
<?php $__env->startSection('content'); ?>

<div class="col-6">
    <div class="card card-default">
        <div class="card-body">
            <table class="table table-striped" style="font-weight: bold; font-size: 18px;line-height: 15px">
                <tbody>
                    <tr>
                        <td style="width: 150px">Username</td>
                        <td style="width: 1px">:</td>
                        <td><?php echo e($data->username); ?></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><?php echo e($data->profile->nama); ?></td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td><?php echo e($data->profile->nip); ?></td>
                    </tr>
                    <tr>
                        <td>Unit Kerja</td>
                        <td>:</td>
                        <td><?php echo e($data->profile->unitKerja->nama); ?></td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td><?php echo e($data->profile->jabatan); ?></td>
                    </tr>
                    <tr>
                        <td>Hak Akses</td>
                        <td>:</td>
                        <td><?php echo e($data->roles->pluck('name')->first()); ?></td>
                    </tr>
                    <tr>
                        <td>Limit Debet</td>
                        <td>:</td>
                        <td><?php echo e(number_format($data->profile->limit_debet, 2)); ?></td>
                    </tr>
                    <tr>
                        <td>Limit Kredit</td>
                        <td>:</td>
                        <td><?php echo e(number_format($data->profile->limit_kredit, 2)); ?></td>
                    </tr>
                    <tr>
                        <td>Fingerprint</td>
                        <td>:</td>
                        <td><?php echo e($data->profile->isFinger == true ? 'True':'False'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/User/Providers/../views/profile.blade.php ENDPATH**/ ?>