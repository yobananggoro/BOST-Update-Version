
<?php $__env->startSection('title', 'Opsi'); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('opsi::filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if(count($data)): ?>
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <?php if(hasModulePermission('opsi')): ?>
                        <th><?php echo e(__('label.action')); ?></th>
                        <?php endif; ?>
                        <th>Nama Opsi</th>
                        <th>Opsi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <?php if(hasModulePermission('opsi')): ?>
                            <td><?php echo Html::linkUpdateDelete('opsi', ['id' => $d->id, 'label' => $d->name]); ?></td>
                            <?php endif; ?>
                            <td><?php echo e($d->name); ?></td>
                            <td>
                                <?php ($values = $d->optionValues->mapWithKeys(function ($item) { return [$item['key'] => $item['value']]; })); ?>
                                <?php echo e(implode(', ', array_values($values->toArray()))); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        <?php echo e($data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('opsi'))->links()); ?>

                    </div>

                    <div class="col-6 text-right" style="margin-top: 8px">
                        <?php echo Html::linkCreate('opsi'); ?>

                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            <?php echo trans('label.no_data_with_link', ['label' => 'Opsi', 'uri' => route('opsi.create')]); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/Opsi/Providers/../views/default.blade.php ENDPATH**/ ?>