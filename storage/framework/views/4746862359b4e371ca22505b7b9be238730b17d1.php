
<?php $__env->startSection('title', 'Log Aktifitas'); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('log::log-aktifitas.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if(count($data)): ?>
        <div class="card card-success">
            <div class="card-body">
                <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                    <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Log</th>
                        <th>User</th>
                        <th>IP Address</th>
                        <th>User Agent</th>
                        <th>Deskripsi</th>
                        <th>Properti</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($d->created_at); ?></td>
                            <td><?php echo e($d->log_name); ?></td>
                            <td><?php echo e($d->user ? $d->user->nama : '-'); ?></td>
                            <td><?php echo e($d->ip_address); ?></td>
                            <td><?php echo e($d->user_agent); ?></td>
                            <td>
                                <?php
                                if (Str::contains($d->description, '{')) {
                                    $curlyFirst = strpos($d->description, '{');
                                    $curlyEnd = strpos($d->description, '}') + 1;
                                    $deskripsi = substr($d->description, 0, $curlyFirst) . ' ' . substr($d->description, $curlyEnd);
                                } else {
                                    $deskripsi = $d->description;
                                }
                                ?>
                                <?php echo e($deskripsi); ?>

                            </td>
                            <td>
                                <a href="#modal-<?php echo e($d->id); ?>" data-toggle="modal" data-target="#modal-<?php echo e($d->id); ?>">[Klik untuk melihat properti]</a>
                                <?php echo $__env->make('log::log-aktifitas.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-<?php echo e(auth()->user()->can('clean log-aktifitas') ? '6' : '12'); ?>">
                        <?php echo e($data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('log-aktifitas'))->links()); ?>

                    </div>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('clean log-aktifitas')): ?>
                    <div class="col-6 text-right">
                        <a href="<?php echo e(route('log-aktifitas.clean')); ?>" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i> <?php echo e(__('button.clean_log')); ?>

                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            <?php echo trans('label.no_data', ['label' => 'Log Aktifitas']); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/Log/Providers/../views/log-aktifitas/default.blade.php ENDPATH**/ ?>