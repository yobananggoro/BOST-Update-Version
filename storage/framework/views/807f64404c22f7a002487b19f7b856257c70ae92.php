
<?php $__env->startSection('title', 'Login'); ?>
<?php $__env->startSection('content'); ?>
    <?php echo e(Form::open(['route' => 'login', 'method' => 'post', 'name' => 'form-login', 'autocomplete' => 'off'])); ?>

    <div class="input-group mb-3">
        <?php echo e(Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'User ID', 'maxlength' => '4'])); ?>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
    </div>

    <div class="input-group mb-3">
        <?php echo e(Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password'])); ?>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary btn-block btn-flat">
                <?php echo e(__('button.login')); ?>

            </button>
        </div>
    </div>
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Kerjaan\Bjb\Aplikasi AMT\Back Office\App\Local\bulk_kosongan\resources\views/auth/login.blade.php ENDPATH**/ ?>