
<?php $__env->startSection('title', 'Transaksi List'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('pemindahbukuan::transaksi-list.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" style="width: 115%">
                        <thead>
                            <tr>
                                <th style="width:30px">Aksi</th>
                                <th style="width:10px">No.</th>
                                <th style="width:160px">Refference</th>
                                <th style="width:250px">Transaksi</th>
                                <th style="width:150px;text-align:right">Nominal</th>
                                <th style="width:130px">User Maker</th>
                                <th style="width:100px">User Oto</th>
                                <th style="width:160px">Status Oto</th>
                                <th style="width:140px">Status Transaksi</th>
                                <th style="width:180px">Tanggal Transaksi</th>
                                <th style="width:180px">Tanggal Otorisasi</th>
                                <?php if(auth()->user()->profile->rolename == "SUPER ADMIN"): ?>
                                <th>Cabang</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1
                            ?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo e(route('transaksi-list.show', $d->id)); ?>" class="btn btn-info btn-sm" title="Detail" style="width:40px; margin-right: 5px"><i class="fa fa-info"></i></a>
                                    </div>
                                </td>
                                <td><?php echo e($i++); ?>.</td>
                                <td><?php echo e($d->reff); ?></td>
                                <td>Pemindahbukuan <?php echo e($tipe_transaksi[$d->tipe_transaksi]); ?></td>
                                <td class="text-right"><?php echo e(number_format($d->nominal, 2)); ?></td>
                                <td><?php echo e($d->userid); ?></td>
                                <td><?php echo e($d->user_override); ?></td>
                                <td><?php echo e($status_approval[$d->status_override]); ?></td>
                                <td><?php echo e($status_validasi_posting[$d->status_transaksi]); ?></td>
                                <td><?php echo e(date('d M Y H:i:s', strtotime($d->created_at))); ?></td>
                                <?php if($d->created_at != $d->updated_at): ?>
                                <td><?php echo e(date('d M Y H:i:s', strtotime($d->updated_at))); ?></td>
                                <?php else: ?>
                                <td></td>
                                <?php endif; ?>
                                <?php if(auth()->user()->profile->rolename == "SUPER ADMIN"): ?>
                                <td><?php echo e($d->unitKerja->nama); ?></td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-6">
                    <?php echo e($data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('transaksi-list'))->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Pemograman\laragon\www\apuppt\app\Modules\Pemindahbukuan\Providers/../views/transaksi-list/default.blade.php ENDPATH**/ ?>