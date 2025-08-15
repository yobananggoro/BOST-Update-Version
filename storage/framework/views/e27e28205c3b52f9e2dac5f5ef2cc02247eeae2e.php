<?php if(session('success')): ?>
    
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo session('success'); ?>

            </div>
        </div>
    
<?php endif; ?>

<?php if(session('info')): ?>
    
        <div class="col-md-12">
            <div class="alert alert-info alert-dismissable">
                <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo session('info'); ?>

            </div>
        </div>
    
<?php endif; ?> 

<?php if(session('warning')): ?>
    
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissable">
                <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo session('warning'); ?>

            </div>
        </div>
    
<?php endif; ?>

<?php if(session('error')): ?>
    
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable">
                <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo session('error'); ?>

            </div>
        </div>
    
<?php endif; ?>

<?php if($errors->any()): ?>
    
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    
<?php endif; ?><?php /**PATH D:\Data\Kerjaan\Bjb\Aplikasi AMT\Back Office\App\Local\bulk_kosongan\resources\views/layouts/partials/message.blade.php ENDPATH**/ ?>