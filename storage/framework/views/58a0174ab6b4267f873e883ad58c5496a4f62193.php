
<?php $__env->startSection('title', 'Remote Otorisasi'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('pemindahbukuan::remote-otorisasi.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(count($data)): ?>
<div class="row">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>                  
                        <tr>
                            <th style="width:30px">Aksi</th>
                            <th style="width:10px">No.</th> 
                            <th style="width:180px">Nomor Refference</th>
                            <th style="width:250px">Nama Transaksi</th>
                            <th style="width:150px;text-align:center">Nominal</th>
                            <th style="width:110px">User Maker</th>
                            <th style="width:160px">Status Otorisasi</th>
                            <th style="width:140px">Status Transaksi</th>
                            <th style="width:180px">Tanggal Transaksi</th>
                            <th>Cabang</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1
                        ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('remote-otorisasi.show', $d->id)); ?>" class="btn btn-info btn-sm" title="Verifikasi" style="width:40px; margin-right: 5px"><i class="fas fa-info"></i></a>
                                </div>
                            </td>  
                            <td><?php echo e($i++); ?>.</td>
                            <td><?php echo e($d->reff); ?></td>
                            <td>Pemindahbukuan <?php echo e($tipe_transaksi[$d->tipe_transaksi]); ?></td>
                            <td class="text-right"><?php echo e(number_format($d->nominal, 2)); ?></td>
                            <td><?php echo e($d->userid); ?></td>
                            <td><?php echo e($status_approval[$d->status_override]); ?></td>
                            <td><?php echo e($status_validasi_posting[$d->status_transaksi]); ?></td>
                            <td><?php echo e(date('d M Y H:i:s', strtotime($d->created_at))); ?></td> 
                            <td><?php echo e($d->unitKerja->nama); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table> 
            </div>
            <div class="card-footer">
                <div class="col-6">
                    <?php echo e($data->appends(\Illuminate\Support\Arr::except(request()->input(), '_token'))->setPath(url('remote-otorisasi'))->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="alert alert-warning col-6">
    <b>Belum ada data transaksi per hari ini.</b>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/Pemindahbukuan/Providers/../views/remote-otorisasi/default.blade.php ENDPATH**/ ?>