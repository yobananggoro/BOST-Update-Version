
<?php $__env->startSection('title', 'Rekening List'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('rekening::filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(count($data)): ?>
<div class="card card-default">
    <div class="card-body">
        <table class="table table-striped tablesaw">
            <thead>
                <tr>
                    <?php if(hasModulePermission('rekening')): ?>
                    <th><?php echo e(__('label.action')); ?></th>
                    <?php endif; ?>
                    <th>No Rek Internal </th>
                    <th>No Rek Eksternal</th>
                    <th>Nama Rekening</th>
                    <th>Tipe Rekening</th>
                    <th>Tipe Currency</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <?php if(hasModulePermission('rekening')): ?>
                    <td><?php echo Html::linkUpdateDelete('rekening', ['id' => $d->id, 'label' => $d->nama]); ?></td>
                    <?php endif; ?>
                    <td><?php echo e($d->branch); ?> - <?php echo e($d->cif); ?> - <?php echo e($d->suffix); ?></td>
                    <td><?php echo e($d->externalNum); ?></td>
                    <td><?php echo e($d->nama); ?></td>
                    <td><?php echo e($d->tipe_rek); ?></td>
                    <td><?php echo e($d->tipe_ccy); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        <div class="row">
            <div class="col-6">
                <?php echo e($data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('rekening'))->links()); ?>

            </div>
            <div class="col-6 text-right" style="margin-top: 8px">
                <?php echo Html::linkCreate('rekening'); ?>

            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="alert alert-warning">
    <?php echo trans('label.no_data_with_link', ['label' => 'Rekening', 'uri' => route('rekening.create')]); ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/Rekening/Providers/../views/default.blade.php ENDPATH**/ ?>