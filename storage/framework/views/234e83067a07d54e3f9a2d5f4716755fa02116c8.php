
<?php $__env->startSection('title', 'Log Aplikasi'); ?>
<?php $__env->startSection('content'); ?>
    <?php if(count($files)): ?>
        <div class="card card-success">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <ul class="list-group">
                            <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item">
                                    <a href="<?php echo e(url('/log-aplikasi?l=' . encrypt($file))); ?>"><?php echo e($file); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>

                    <div class="col-9">
                        <div class="btn-group pull-left mb-2">
                            <a href="<?php echo e(url('/log-aplikasi?dl=' . encrypt($current_file))); ?>" class="btn btn-default"><?php echo e(__('button.download')); ?></a>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('clean log-aplikasi')): ?>
                                <a href="<?php echo e(url('/log-aplikasi?clean=' . encrypt($current_file))); ?>" class="btn btn-default"><?php echo e(__('button.clean_log')); ?></a>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete log-aplikasi')): ?>
                                <a href="<?php echo e(url('/log-aplikasi?del=' . encrypt($current_file))); ?>" class="btn btn-default"><?php echo e(__('button.delete')); ?></a>
                            <?php endif; ?>
                        </div>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_all log-aplikasi')): ?>
                            <a href="<?php echo e(url('/log-aplikasi?delall=true')); ?>" class="btn btn-default pull-right"><?php echo e(__('button.delete_all')); ?> log file(s)</a>
                        <?php endif; ?>
                        <?php if($logs === null): ?>
                            <div class="alert alert-info">File log > 50M, harap unduh.</div>
                        <?php else: ?>
                            <div class="col-lg-12 text-center mb-2">
                                <h3><?php echo e($current_file); ?></h3>
                            </div>
                            <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
                                <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Context</th>
                                    <th>Date</th>
                                    <th>Content</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-<?php echo e($log['level_class']); ?>">
                                            <span class="fa fa-<?php echo e($log['level_img']); ?>" aria-hidden="true"></span>
                                            <?php echo e($log['level']); ?>

                                        </td>
                                        <td><?php echo e($log['context']); ?></td>
                                        <td><?php echo e($log['date'] !== 1 ? $log['date'] : ''); ?></td>
                                        <td>
                                            <?php if($log['text']): ?>
                                            <a href="#modal-<?php echo e($key); ?>" data-toggle="modal" data-target="#modal-<?php echo e($key); ?>">
                                                [<?php echo e(\Illuminate\Support\Str::limit($log['text'], 50)); ?>]
                                            </a>
                                            <?php echo $__env->make('log::log-aplikasi.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/resources/views/vendor/laravel-log-viewer/log.blade.php ENDPATH**/ ?>