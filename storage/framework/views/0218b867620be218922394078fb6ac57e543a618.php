
<?php $__env->startSection('title', 'Menu List'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('menu::filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(count($data)): ?>
<div class="card card-success">
    <div class="card-body">
        <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
            <thead>
                <tr>
                    <?php if(hasModulePermission('menu')): ?>
                    <th><?php echo e(__('label.action')); ?></th>
                    <?php endif; ?>
                    <th>Label Menu</th>
                    <th>Url</th>
                    <th>Icon</th>
                    <th>Parent</th>
                    <th>visible</th>
                    <th>Sequence</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <?php if(hasModulePermission('menu')): ?>
                    <td><?php echo Html::linkUpdateDelete('menu', ['id' => $d->id, 'label' => $d->label]); ?></td>
                    <?php endif; ?>
                    <td><?php echo e($d->label); ?></td>
                    <td><?php echo e($d->uri); ?></td>
                    <td><?php echo e($d->icon); ?></td>
                    <td><?php echo e($d->parents->label ?? ''); ?></td>
                    <td><?php echo e($d->visible == 't' ? 'on':'off'); ?></td>
                    <td><?php echo e($d->sequence); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix"> 
        <div class="row">
            <div class="col-6">
                <?php echo e($data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('menu'))->links()); ?>

            </div>
            
            <div class="col-6 text-right" style="margin-top: 8px">
                <?php echo Html::linkCreate('menu'); ?>

            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="alert alert-warning">
    <?php echo trans('label.no_data_with_link', ['label' => 'Menu', 'uri' => route('menu.create')]); ?>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/Menu/Providers/../views/default.blade.php ENDPATH**/ ?>