
<?php $__env->startSection('title', 'Currency List'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <div class="btn-group">
                    <a href="<?php echo e(url('list-currency/getList')); ?>" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> List Data</a>
                </div>
                <div class="btn-group">
                    <a href="<?php echo e(url('list-currency/reload')); ?>" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reload Data</a>
                </div>
            </div>
            <div class="card-body">
                <table id="dataTable1" class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:10px">No.</th>
                            <th>Kode</th>
                            <th>Nomor</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Desimal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($data)): ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+1); ?>.</td>
                                <td><?php echo e($d['currCode']); ?></td>
                                <td><?php echo e($d['currNumb']); ?></td>
                                <td><?php echo e($d['currDesc']); ?></td>
                                <td><?php echo e($d['isActive'] == 1 ? 'Active':'Non-Active'); ?></td>
                                <td><?php echo e($d['decimalPlaces']); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Pemograman\laragon\www\apuppt\app\Modules\Currency\Providers/../views/default.blade.php ENDPATH**/ ?>