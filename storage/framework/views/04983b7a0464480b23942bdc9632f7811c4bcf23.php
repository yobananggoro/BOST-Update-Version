
<?php $__env->startSection('title', 'Hak Akses'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('hakakses::filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <?php if(count($data)): ?>
    <div class="col-12">
        <div class="card card-default">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                        <tr>
                            <?php if(hasModulePermission('hak-akses')): ?>
                            <th style="width: 50px"><?php echo e(__('label.action')); ?></th>
                            <?php endif; ?>
                            <th style="width: 200px">Hak Akses</th>
                            <th>Menu</th>
                            <th>Pengelolaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <?php if(hasModulePermission('hak-akses')): ?>
                            <?php
                            $actions = null;
                            $actions[] = ['url' => 'hak-akses.edit', 'permission' => 'edit hak-akses', 'attributes' => ['rel' => 'action', 'title' => __('label.update_message', ['label' => $d->name])], 'label' => __('label.update_message', ['label' => $d->name])];
                            if ($d->modules->count() && $d->permissions->count()) {
                            array_push($actions, [
                            'url' => 'hak-akses.destroy', 'permission' => 'destroy hak-akses', 'attributes' => [
                            'rel' => 'delete',
                            'title' => __('label.delete_message', ['label' => $d->name])
                            ], 'label' => __('label.delete_message', ['label' => $d->name])
                            ]);
                            }
                            ?>
                            <td><?php echo Html::linkActions($actions, $d->id); ?></td>
                            <?php endif; ?>
                            <td><?php echo e($d->name); ?></td>
                            <td><?php echo e($d->modules->implode('label', ', ')); ?></td>
                            <td><?php echo e($d->permissions->implode('name', ', ')); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        <?php echo e($data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('hak-akses'))->links()); ?>

                    </div>

                    
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-warning">
        <!-- <?php echo trans('label.no_data_with_link', ['label' => 'Hak Akses', 'uri' => route('hak-akses.create')]); ?> -->
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/HakAkses/Providers/../views/default.blade.php ENDPATH**/ ?>