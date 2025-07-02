<?php echo e(Form::open(['url' => '/rekening/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off'])); ?>

<div class="card card-primary collapsed-card">
    <div class="card-header">
        <h3 class="card-title"><?php echo e(__('label.filter')); ?></h3>
        <?php echo Html::cardCollapse(); ?>

    </div>  
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?php echo e(Form::fgText('Cif', 'cif', request()->cif, ['class' => 'form-control'], null, 'text', true)); ?>

            </div>
            <div class="col-md-6">
                <?php echo e(Form::fgText('Nama Rekening', 'nama', request()->nama, ['class' => 'form-control'], null, 'text', true)); ?>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <?php echo e(Form::fgFilterButton()); ?>

    </div>
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /var/www/html/backoff/app/Modules/Rekening/Providers/../views/filter.blade.php ENDPATH**/ ?>