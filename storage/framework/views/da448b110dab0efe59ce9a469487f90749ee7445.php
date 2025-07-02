
<?php $__env->startSection('title', 'Setting'); ?>
<?php $__env->startSection('content'); ?>
<?php echo e(Form::open(['route' => 'setting.update', 'method' => 'post', 'class' => 'form-horizontal form-data', 'autocomplete' => 'off', 'files' => true])); ?>

<?php (\Illuminate\Support\Arr::forget($display_per_page, 'All')); ?>
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo e(to_upper($key)); ?></h3>
    </div>
    <div class="card-body">
        <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($d['key'] === 'display_per_page'): ?>
        <?php echo e(Form::fgSelect($d['shortdesc'], $d['key'], to_dropdown($display_per_page), $d['value'], ['class' => 'form-control'], null, true)); ?>

        <?php elseif($d['key'] === 'auth_method'): ?>
        <?php echo e(Form::fgSelect($d['shortdesc'], $d['key'], to_dropdown($auth_method), $d['value'], ['class' => 'form-control'], null, true)); ?>

        <?php elseif(in_array($d['key'], ['force_local', 'notif_via_email', 'push_notif', 'bypass_cutoff'])): ?>
        <?php echo e(Form::fgSelect($d['shortdesc'], $d['key'], ['' => __('label.choose_one'), 'true' => __('label.yes'), 'false' => __('label.no')], $d['value'], ['class' => 'form-control'], null, true)); ?>

        <?php elseif($d['key'] === 'logo'): ?>
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label"><?php echo e($d['shortdesc']); ?></label>
            <?php if(isset($d['value'])): ?>
            <div class="col-md-2 text-center mt-5">
                <img src="<?php echo e(asset('img/' . $d['value'])); ?>" alt="logo" width="140" height="100">
            </div>
            <?php endif; ?>
            <div class="col-md-<?php echo e(isset($d['value']) ? '8' : '10'); ?>">
                <?php echo Form::file($d['key'], ['class' => 'dropify']); ?>

            </div>
        </div>
        <?php elseif(in_array($d['key'], ['motd', 'disclaimer'])): ?>
        <?php echo e(Form::fgText($d['shortdesc'], $d['key'], $d['value'], ['class' => 'form-control'], null, 'textarea', true)); ?>

        <?php else: ?>
        <?php echo e(Form::fgText($d['shortdesc'], $d['key'], $d['value'], ['class' => 'form-control ' . ($d['key'] === 'ftp_rdn' ? 'ipport' : '')], null, 'text', true)); ?>

        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<div class="card">
    <div class="card-footer">
        <div class="row col-12 clearfix">
            <button class="btn btn-success btn-sm save">
                <i class="fa fa-save"></i> <?php echo e(__('button.save')); ?>

            </button>&nbsp;
            <button type="reset" class="btn btn-warning btn-sm reset">
                <i class="fa fa-refresh"></i> <?php echo e(__('button.reset')); ?>

            </button>&nbsp;
        </div>
    </div>
</div>
<?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/Setting/Providers/../views/default.blade.php ENDPATH**/ ?>