<!--<div class="form-group <?php echo e($layout ? 'row' : ''); ?>">
    <?php if($layout): ?>
        <label for="" class="col-md-2 col-form-label"><?php echo e($label); ?></label>
        <div class="col-md-10">
            <?php echo e(Form::select($name, $options, $value, $attributes)); ?>

            <?php if(!is_null($help)): ?>
                <small class="form-text text-muted"><?php echo e($help); ?></small>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <label for=""><?php echo e($label); ?></label>
        <?php echo e(Form::select($name, $options, $value, $attributes)); ?>

        <?php if(!is_null($help)): ?>
            <small class="form-text text-muted"><?php echo e($help); ?></small>
        <?php endif; ?>
    <?php endif; ?>
</div> -->
<div class="form-group <?php echo e($layout ? 'row' : ''); ?>">
    <?php if($layout): ?>
        <div class="col-md-12">
            <label for=""><?php echo e($label); ?></label>
            <?php echo e(Form::select($name, $options, $value, $attributes)); ?>

            <?php if(!is_null($help)): ?>
            <small class="form-text text-muted"><?php echo e($help); ?></small>
            <?php endif; ?>
        </div>
    <?php else: ?>
    <label for=""><?php echo e($label); ?></label>
    <?php echo e(Form::select($name, $options, $value, $attributes)); ?>

        <?php if(!is_null($help)): ?>
        <small class="form-text text-muted"><?php echo e($help); ?></small>
        <?php endif; ?>
    <?php endif; ?>
</div><?php /**PATH D:\Data\Kerjaan\Bjb\Aplikasi AMT\Back Office\App\Local\bulk_kosongan\resources\views/components/form/select.blade.php ENDPATH**/ ?>