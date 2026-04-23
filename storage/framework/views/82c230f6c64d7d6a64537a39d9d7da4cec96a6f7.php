
<?php $__env->startSection('title', 'List Bulk Upload'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('bulktransaksi::transaksi-list.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row" id="bulkList" style="display: ">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-body">
                <table id="dataTable1" class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:10px">No.</th>
                            <th style="width:70px">Aksi</th>
                            <th>Refference</th>
                            <th>Trx</th>
                            <th>File</th>
                            <th>Nominal</th>
                            <th>Maker</th>
                            <th>Approval</th>
                            <th>Status</th>
                            <th>Tanggal Buat</th>
                            <th>Tanggal Update</th>
                            <?php if(auth()->user()->profile->rolename == 'SUPER ADMIN'): ?>
                            <th>Kode Kantor</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($data != ''): ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+1); ?>.</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default">Action</button>
                                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-1px, -165px, 0px);">
                                        <a href="<?php echo e(route('list-bulkupload.listDetail', ['id' => $d['id'], 'page' => 0, 'rows' => $d['totalRecords'] ])); ?>" rel="action" title="Detail <?php echo e($d['reference']); ?>" class="dropdown-item">Detail | <b><?php echo e($d['reference']); ?></b></a>
                                        <?php if(in_array(auth()->user()->profile->rolename, ['Administrasi Dana Dan Jasa', 'Administrasi Kredit', 'Administrasi Operasional', 'SUPER ADMIN', 'Staf'])): ?>
                                            <?php if($d['status'] == 'WAITING_VERIFY'): ?>
                                            <a href="<?php echo e(route('list-bulkupload.verify', ['id' => $d['id'], 'action' => 'true'])); ?>" class="dropdown-item" rel="action" title="Verify <?php echo e($d['reference']); ?>">Verify | <b><?php echo e($d['reference']); ?></b></a>
                                            <a href="<?php echo e(route('list-bulkupload.verify', ['id' => $d['id'], 'action' => 'false'])); ?>" class="dropdown-item" rel="action" title="Cancel <?php echo e($d['reference']); ?>">Cancel | <b><?php echo e($d['reference']); ?></b></a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if($d['status'] == 'EXECUTED'): ?>
                                            <a target="_blank" href="<?php echo e(route('list-bulkupload.pdf', ['id' => $d['id'], 'usermaker' => $d['createdBy'], 'useroto' => $d['updatedBy'] == null ? '' : $d['updatedBy'], 'timecreate' => $d['createdAt'], 'timeoto' => $d['approvedAt'] == null ? '' : $d['approvedAt'], 'reff' => $d['reference'], 'trxType' => $d['bulkType']])); ?>" class="dropdown-item">Export PDF | <b><?php echo e($d['reference']); ?></b></a>
                                        <?php endif; ?>
                                        <?php if($d['status'] == 'NOT_VERIFIED'): ?>
                                            <a target="_blank" href="<?php echo e(route('list-bulkupload.excel', ['id' => $d['id'], 'usermaker' => $d['createdBy'], 'useroto' => $d['updatedBy'] == null ? '' : $d['updatedBy'], 'timecreate' => $d['createdAt'], 'timeoto' => $d['approvedAt'] == null ? '' : $d['approvedAt'], 'reff' => $d['reference'], 'trxType' => $d['bulkType']])); ?>" class="dropdown-item">Export Excel | <b><?php echo e($d['reference']); ?></b></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo e($d['reference']); ?></td>
                            <td><?php echo e($d['bulkType']); ?></td>
                            <td><?php echo e($d['fileName']); ?></td>
                            <!-- <td class="text-right"><?php echo e($d['totalRecords']-1); ?></td> -->
                            <td class="text-right"><?php echo e(number_format($d['totalDebit'], 2)); ?></td>
                            <td><?php echo e($d['createdBy']); ?></td>
                            <td><?php echo e($d['updatedBy']); ?></td>
                            <td><?php echo e(str_replace('_', ' ', $d['status'])); ?></td>
                            <td><?php echo e($d['createdAt'] != null ? date('d M Y H:i:s', strtotime($d['createdAt'])) : ''); ?></td>
                            <td><?php echo e($d['updatedAt'] != null ? date('d M Y H:i:s', strtotime($d['updatedAt'])) : ''); ?></td>
                            <?php if(auth()->user()->profile->rolename == "SUPER ADMIN"): ?>
                            <td><?php echo e($d['branch']); ?></td>
                            <?php endif; ?>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Pemograman\laragon\www\apuppt\app\Modules\BulkTransaksi\Providers/../views/transaksi-list/default.blade.php ENDPATH**/ ?>