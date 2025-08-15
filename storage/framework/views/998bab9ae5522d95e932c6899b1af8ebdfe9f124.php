
<?php $__env->startSection('title', 'Detail Upload File'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-4">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Posting Success</span>
                <span class="info-box-number">
                    <?php
                    if(preg_match('/SUCCESS:\s*(\d+)/', $addtInfo, $matches))
                    {
                        $success = (int) $matches[1];
                        echo number_format($success, 0, '', '.');
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hourglass-half"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Posting on Progress</span>
                <span class="info-box-number">
                    <?php
                    if(preg_match('/IN_PROGRESS:\s*(\d+)/', $addtInfo, $matches))
                    {
                        $inprogress = (int) $matches[1];
                        echo number_format($inprogress, 0, '', '.');
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Posting Failed</span>
                <span class="info-box-number">
                    <?php
                    if(preg_match('/FAILED:\s*(\d+)/', $addtInfo, $matches))
                    {
                        $failed = (int) $matches[1];
                        echo number_format($failed, 0, '', '.');
                    }
                    ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header border-0">
                <div class="float-right" id="searchContainer"></div>
                <table class="float-left" cellspacing="0" cellpadding="0" style="font-weight: bold; font-size: 15px">
                    <tbody>
                        <tr>
                            <td style="width: 140px; text-align: left">Page</td>
                            <td style="width: 15px; text-align: left">:</td>
                            <td style="width: 80px; text-align: left"><?php echo e($page); ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: left">Total rows</td>
                            <td style="text-align: left">:</td>
                            <td style="text-align: left"><?php echo e(number_format($request->rows, 0, '', '.')); ?> rows</td>
                        </tr>
                        <tr>
                            <td style="text-align: left">Max rows per page</td>
                            <td style="text-align: left">:</td>
                            <!-- <td style="text-align: left"><?php echo e(number_format(count($data), 0, '', '.')); ?> rows</td> -->
                            <td style="text-align: left"><?php echo e(number_format($size, 0, '', '.')); ?> rows</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-body table-responsive" style="max-height: 650px; overflow-y: scroll">
                <!-- <table class="table table-striped table-head-fixed" style="width: 150%"> -->
                <table id="dataTableDetailUpload" class="table table-striped" style="width: 170%">

                    <thead>
                        <tr>
                            <!-- <th style="width:10px">No.</th> -->
                            <th style="width:100px">Trx Code</th>
                            <th>Cheque No</th>
                            <th>Account</th>
                            <th>Account Name</th>
                            <th>Account Status</th>
                            <th>Ccy</th>
                            <th>Amount</th>
                            <th>Nar 1</th>
                            <th>Nar 2</th>
                            <th>Nar 3</th>
                            <th>Nar 4</th>
                            <th>Trx Status</th>
                            <th>Posting Date</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <?php if($d['trxType'] != 'dc'): ?>
                            <!-- <td><?php echo e($key+1); ?>.</td> -->
                            <td><?php echo e($d['trxType'] == 'd' ? $d['trxCodeDebit'].' (D) ' : $d['trxCodeCredit'].' (C) '); ?></td>
                            <td><?php echo e($d['chequeNumber']); ?></td>
                            <td><?php echo e($d['trxType'] == 'd' ? $d['srcAccountNumber'] : $d['dstAccountNumber']); ?></td>
                            <td><?php echo e($d['accountName']); ?></td>
                            <td><?php echo e($d['accountStatus']); ?></td>
                            <td><?php echo e($d['trxType'] == 'd' ? $d['srcCcy'] : $d['dstCcy']); ?></td>
                            <td class="text-right"><?php echo e(number_format($d['trxAmount'],2)); ?></td>
                            <td><?php echo e($d['trxType'] == 'd' ? $d['nar1'] : $d['nar5']); ?></td>
                            <td><?php echo e($d['trxType'] == 'd' ? $d['nar2'] : $d['nar6']); ?></td>
                            <td><?php echo e($d['trxType'] == 'd' ? $d['nar3'] : $d['nar7']); ?></td>
                            <td><?php echo e($d['trxType'] == 'd' ? $d['nar4'] : $d['nar8']); ?></td>
                            <td><?php echo e($d['trxStatus']); ?></td>
                            <td><?php echo e($d['postingDt']); ?></td>
                            <td><?php echo e($d['createdAt'] != null ? date('d M Y H:i:s', strtotime($d['createdAt'])) : ''); ?></td>
                            <td><?php echo e($d['updatedAt'] != null ? date('d M Y H:i:s', strtotime($d['updatedAt'])) : ''); ?></td>
                            <?php else: ?>
                            <td><?php echo e($key+1); ?>.</td>
                            <td><?php echo e($d['trxCodeDebit'].' (D) '); ?><br><?php echo e($d['trxCodeCredit'].' (C) '); ?></td>
                            <td><?php echo e($d['srcAccountNumber']); ?><br><?php echo e($d['dstAccountNumber']); ?></td>
                            <td><?php echo e($d['accountName']); ?></td>
                            <td><?php echo e($d['accountStatus']); ?></td>
                            <td><?php echo e($d['trxType'] == 'd' ? $d['srcCcy'] : $d['dstCcy']); ?></td>
                            <td class="text-right"><?php echo e(number_format($d['trxAmount'],2)); ?></td>
                            <td><?php echo $d['trxType'] == 'd' ? $d['nar1'] : $d['nar1']."<br>".$d['nar5']; ?></td>
                            <td><?php echo $d['trxType'] == 'd' ? $d['nar2'] : $d['nar2']."<br>".$d['nar6']; ?></td>
                            <td><?php echo $d['trxType'] == 'd' ? $d['nar3'] : $d['nar3']."<br>".$d['nar7']; ?></td>
                            <td><?php echo $d['trxType'] == 'd' ? $d['nar4'] : $d['nar4']."<br>".$d['nar8']; ?></td>
                            <td><?php echo e($d['trxStatus']); ?></td>
                            <td><?php echo e($d['postingDt']); ?></td>
                            <td><?php echo e($d['createdAt'] != null ? date('d M Y H:i:s', strtotime($d['createdAt'])) : ''); ?></td>
                            <td><?php echo e($d['updatedAt'] != null ? date('d M Y H:i:s', strtotime($d['updatedAt'])) : ''); ?></td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-6">
                        <!-- <h8><b>Total rows: <?php echo e(number_format($request->rows, 0, '', '.')); ?></b></h8> -->
                    </div>
                    <div class="col-6">
                        <div class="btn-group float-right">
                            <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate" style="align-content: flex-end">
                                <ul class="pagination">
                                    <?php if($page <= 0 ): ?>
                                        <li class="paginate_button page-item previous disabled" id="example1_previous">
                                        <a type="button" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
                                            ‹
                                        </a>
                                        </li>
                                        <?php else: ?>
                                        <li class="paginate_button page-item previous" id="example1_previous">
                                            <a href="<?php echo e(route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $page-1, 'rows' => $request->rows])); ?>" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
                                                ‹
                                            </a>
                                        </li>
                                        <?php endif; ?>

                                        <li class="paginate_button page-item next" id="example1_next">
                                            <a href="<?php echo e(route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => 0, 'rows' => $request->rows])); ?>" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                                                First
                                            </a>
                                        </li>
                                        <?php for($i = 0; $i <= ceil($request->rows/$size)-1; $i++): ?>
                                            <?php
                                            $startpage=$page - 2;
                                            $endpage=$page + 2;
                                            ?>
                                            <?php if($i >= $startpage && $i <= $endpage): ?>
                                                <?php if($i==$page): ?>
                                                <li class="paginate_button page-item active">
                                                <a href="<?php echo e(route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $page, 'rows' => $request->rows])); ?>" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
                                                    <?php echo e($i); ?>

                                                </a>
                                                </li>
                                                <?php else: ?>
                                                <li class="paginate_button page-item">
                                                    <a href="<?php echo e(route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $i, 'rows' => $request->rows])); ?>" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
                                                        <?php echo e($i); ?>

                                                    </a>
                                                </li>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                                <?php endfor; ?>
                                                <li class="paginate_button page-item next" id="example1_next">
                                                    <a href="<?php echo e(route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => ceil($request->rows/$size)-1, 'rows' => $request->rows])); ?>" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                                                        Last
                                                    </a>
                                                </li>
                                                <?php if((@$page) >= ceil($request->rows/$size)-1): ?>
                                                <li class="paginate_button page-item disabled" id="example1_next">
                                                    <a type="button" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                                                        ›
                                                    </a>
                                                </li>
                                                <?php else: ?>
                                                <li class="paginate_button page-item next" id="example1_next">
                                                    <a href="<?php echo e(route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $page+1, 'rows' => $request->rows])); ?>" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                                                        ›
                                                    </a>
                                                </li>
                                                <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Kerjaan\Bjb\Aplikasi AMT\Back Office\App\Local\bulk_kosongan\app\Modules\BulkTransaksi\Providers/../views/transaksi-list/detail.blade.php ENDPATH**/ ?>