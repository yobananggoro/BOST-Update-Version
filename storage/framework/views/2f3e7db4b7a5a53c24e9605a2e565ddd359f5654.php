<?php if(session('success')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Success',
            body: <?php echo json_encode(session('success')); ?>

        });
    });
</script>
<?php endif; ?>

<?php if(session('info')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).Toasts('create', {
            class: 'bg-info',
            title: 'Info',
            body: <?php echo json_encode(session('info')); ?>

        });
    });
</script>
<?php endif; ?>

<?php if(session('warning')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).Toasts('create', {
            class: 'bg-warning',
            title: 'Warning',
            body: <?php echo json_encode(session('warning')); ?>

        });
    });
</script>
<?php endif; ?>

<?php if(session('error')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Error',
            body: <?php echo json_encode(session('error')); ?>

        });
    });
</script>
<?php endif; ?>

<?php if($errors->any()): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Error',
                body: <?php echo json_encode($error); ?>

            });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    });
</script>
<?php endif; ?>
<?php /**PATH D:\Data\Pemograman\laragon\www\usercodes\resources\views/layouts/partials/message.blade.php ENDPATH**/ ?>