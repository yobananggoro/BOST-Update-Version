<?php echo e(Form::open(['url' => '/menu/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off'])); ?>

    <div class="card card-primary collapsed-card">
        <div class="card-header">
            <h3 class="card-title"><?php echo e(__('label.filter')); ?></h3> 
            <?php echo Html::cardCollapse(); ?>

        </div>

        <div class="card-body">
            <div class="col-md-12">
                <?php echo e(Form::fgText('Nama Menu', 'label', request()->label, ['class' => 'form-control'], null, 'text', true)); ?>

            </div>
        </div>

        <div class="card-footer">
            <?php echo e(Form::fgFilterButton()); ?>

        </div>
    </div>
<?php echo e(Form::close()); ?>

<?php /**PATH D:\Data\Kerjaan\Bjb\Aplikasi AMT\Back Office\App\Local\bulk_kosongan\app\Modules\Menu\Providers/../views/filter.blade.php ENDPATH**/ ?>