<?php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'users.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['users.update', $data->id]; }
?>

<?php $__env->startSection('title', 'Edit Profile User'); ?>
<?php $__env->startSection('content'); ?>
<div class="col-6">
    <div class="card card-default">
        <div class="card-header">
            <table cellspacing="0" cellpadding="0" style="font-weight: bold">
                <tbody>
                    <tr>
                        <td style="width:100px">Nama</td>
                        <td style="width:10px">:</td>
                        <td><?php echo e($data->profile->nama); ?></td>
                    </tr>
                    <tr>
                        <td>User</td>
                        <td>:</td>
                        <td><?php echo e($data->username); ?></td>
                    </tr>
                    <tr>
                        <td>Unit Kerja</td>
                        <td>:</td>
                        <td><?php echo e($data->profile->unitKerja->nama); ?> (<?php echo e($data->profile->rolename); ?>)</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php echo e(Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off'])); ?>

        <?php echo csrf_field(); ?>
        <input type="hidden" name="username" value="<?php echo e($data->username); ?>" readonly>
        <div class="card-body">
            <div class="col-12">
                <div class="form-group col-12 row">
                    <label class="col-sm-2 col-form-label">Limit Debet</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" name="limit_debet" class="form-control currency text-right" value="<?php echo e(number_format($data->profile->limit_debet)); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group col-12 row">
                    <label class="col-sm-2 col-form-label">Limit Kredit</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" name="limit_kredit" class="form-control currency text-right" value="<?php echo e(number_format($data->profile->limit_kredit)); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group col-12 row">
                    <label class="col-sm-2 col-form-label">Fingerprint</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <select class="form-control" name="isFinger">
                                <option value="true" <?php echo e($data->profile->isFinger == true ? "selected":""); ?>>True</option>
                                <option value="false" <?php echo e($data->profile->isFinger == false ? "selected":""); ?>>False</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="btn-group">
                <button type="submit" class="btn btn-sm btn-primary" style="width: 80px">Submit</button>
            </div>
            <div class="btn-group">
                <a href="<?php echo e(url('users')); ?>" type="button" class="btn btn-sm btn-warning" style="width: 80px">Kembali</a>
            </div>
        </div>
        <?php echo e(Form::close()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/User/Providers/../views/edit.blade.php ENDPATH**/ ?>