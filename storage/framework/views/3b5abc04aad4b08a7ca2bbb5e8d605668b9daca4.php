<div class="modal fade" id="modal-<?php echo e($d->id); ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Properti</h4>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?php ($properties = json_decode($d->properties, true)); ?>
                <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $prop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($prop['id'])): ?>
                        <?php (\Illuminate\Support\Arr::forget($prop, 'id')); ?>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <h4><?php echo e(strtoupper($key)); ?></h4>
                            <blockquote><?php echo e(print_r($prop, true)); ?></blockquote>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__('button.close')); ?></button>
            </div>
        </div>
    </div>
</div><?php /**PATH /var/www/html/backoff/app/Modules/Log/Providers/../views/log-aktifitas/modal.blade.php ENDPATH**/ ?>