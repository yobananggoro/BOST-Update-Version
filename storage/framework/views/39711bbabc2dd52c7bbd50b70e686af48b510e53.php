<?php
$tanggal = request()->tanggal ?: request()->tanggal;
$tglawal = isset($tanggal['tgl_awal']) ? $tanggal['tgl_awal'] : now()->firstOfMonth()->format('Y-m-d');
$tglakhir = isset($tanggal['tgl_akhir']) ? $tanggal['tgl_akhir'] : now()->endOfMonth()->format('Y-m-d');
?>
<?php echo e(Form::open(['url' => '/log-aktifitas/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off'])); ?>

    <div class="card card-primary collapsed-card">
        <div class="card-header">
            <h3 class="card-title"><?php echo e(__('label.filter')); ?></h3>
            <?php echo Html::cardCollapse(); ?>

        </div>

        <div class="card-body">
            <div class="col-md-12">
                <div class="form-group row">
                    <label for="" class="col-md-2 col-form-label text-left">Range Tanggal</label>
                    <div class="col-md-5">
                        <?php echo e(Form::text('tanggal[tgl_awal]', $tglawal, ['class' => 'form-control datepick'])); ?>

                    </div>
                    <div class="col-md-5">
                        <?php echo e(Form::text('tanggal[tgl_akhir]', $tglakhir, ['class' => 'form-control datepick'])); ?>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <?php echo e(Form::fgSelect('User', 'causer_id', $causer, request()->causer_id, ['class' => 'form-control'], null, 'text', true)); ?>

            </div>
        </div>

        <div class="card-footer">
            <?php echo e(Form::fgFilterButton()); ?>

        </div>
    </div>
<?php echo e(Form::close()); ?>

<?php /**PATH /var/www/html/backoff/app/Modules/Log/Providers/../views/log-aktifitas/filter.blade.php ENDPATH**/ ?>