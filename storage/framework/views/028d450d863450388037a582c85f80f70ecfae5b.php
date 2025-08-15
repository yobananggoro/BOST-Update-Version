<?php if($action === 'create'): ?>
    <button class="btn btn-success btn-sm save">
        <i class="fa fa-save"></i> <?php echo e(__('button.save')); ?>

    </button>&nbsp;
<?php endif; ?>
<button class="btn btn-primary btn-sm save-close">
    <i class="fa fa-backward"></i> <?php echo e(__('button.save_close')); ?>

</button>&nbsp;

<a href="<?php echo e(route((\Str::contains($uri, '.') ? $uri : $uri . '.index'), $parameter)); ?>" class="btn btn-danger btn-sm" rel="content">
    <i class="fa fa-times"></i> <?php echo e(__('button.cancel')); ?>

</a><?php /**PATH D:\Data\Kerjaan\Bjb\Aplikasi AMT\Back Office\App\Local\bulk_kosongan\resources\views/components/form/button.blade.php ENDPATH**/ ?>