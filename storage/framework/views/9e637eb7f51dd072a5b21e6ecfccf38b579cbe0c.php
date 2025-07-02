<?php echo e(Form::open(['url' => '/hak-akses/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off'])); ?>

    <div class="card card-default">
        <div class="card-header">
            <b>Filter</b>
            <?php echo Html::cardCollapse(); ?>

        </div>

        <div class="card-body">
            <div class="col-md-12">
                <?php echo e(Form::fgText('Hak Akses', 'name', request()->name, ['class' => 'form-control ucase'], null, 'text', true)); ?>

            </div>
        </div>

        <div class="card-footer">
            <?php echo e(Form::fgFilterButton()); ?>

        </div>
    </div>
<?php echo e(Form::close()); ?><?php /**PATH /var/www/html/backoff/app/Modules/HakAkses/Providers/../views/filter.blade.php ENDPATH**/ ?>