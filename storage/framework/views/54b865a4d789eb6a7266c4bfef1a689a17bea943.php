
<?php $__env->startSection('title', 'Report Transaksi'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <div class="btn-group">
                    <b>Filter</b>
                </div>
            </div>
            <form action="<?php echo e(url('report-transaksi/getReport')); ?>" method="post" id="formInput" class="form-horizontal">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-4">
                            <div class="input-group"> 
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" id="startDate" name="startDate" value="<?php echo e(@$request->startDate); ?>" onchange="getRequest(this)" class="form-control datepick" placeholder="Start Date">
                            </div>
                        </div> 
                        <div class="col-sm-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" id="endDate" name="endDate" value="<?php echo e(@$request->endDate); ?>" onchange="getRequest(this)" class="form-control datepick" placeholder="End Date">
                            </div>
                        </div>
                    </div>
                    <?php if(auth()->user()->profile->rolename == "SUPER ADMIN"): ?>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">User ID</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" id="userid" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="<?php echo e(old('userid', @$request->userid)); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Branch</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select name="branch" id="branch" class="form-control select2" onchange="getRequest(this)">
                                    <option value="">- Pilih -</option>
                                    <?php $__currentLoopData = $branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value['kode']); ?>" <?php echo e($value['kode'] == $request->branch ? 'selected':''); ?>><?php echo e($value['nama']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select> 
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">User ID</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <?php if(auth()->user()->profile->rolename != "USER"): ?>
                                <input type="text" id="userid" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="<?php echo e(old('userid', @$request->userid)); ?>">
                                <?php else: ?>
                                <input type="text" id="userid" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="<?php echo e(auth()->user()->username); ?>" readonly>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Branch</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" maxlength="4" value="<?php echo e(auth()->user()->profile->unitKerja->nama); ?>" readonly>
                                <div style="display: none">
                                    <input type="hidden" id="branch" name="branch" class="form-control" maxlength="4" value="<?php echo e(auth()->user()->profile->unit_kerja_kode); ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button type="submit" id="btnEnter" class="btn btn-sm btn-info"><i class="fas fa-search"></i> Filter</button>
                    </div>
                    <div class="btn-group">
                        <a href="<?php echo e(url('report-transaksi')); ?>" type="button" id="btnEnter" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reset</a>
                    </div>
                    <div class="btn-group float-right">
                        <?php if(@$request->userid != ''): ?>
                        <button id="btnPrintPDF" class="btn btn-sm btn-success" form="formPdf"><i class="fas fa-print"></i> Export PDF</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
            <form action="<?php echo e(url('report-transaksi/pdf')); ?>" method="post" target="_blank" id="formPdf" class="form-horizontal">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="startDate_" name="startDate" value="<?php echo e(@$request->startDate); ?>" readonly>
                <input type="hidden" id="endDate_" name="endDate" value="<?php echo e(@$request->endDate); ?>" readonly>
                <input type="hidden" id="userID_" name="userid" maxlength="4" value="<?php echo e(@$request->userid); ?>" readonly>
                <?php if(auth()->user()->profile->rolename == "SUPER ADMIN"): ?>
                <input type="hidden" id="branch_" name="branch" maxlength="4" value="<?php echo e(@$request->branch); ?>" readonly>
                <?php else: ?>
                <input type="hidden" id="branch_" name="branch" maxlength="4" value="<?php echo e(auth()->user()->profile->unit_kerja_kode); ?>" readonly>
                <?php endif; ?>

            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card card-default">
            <div class="card-body">
                <table id="dataTables" class="table table-bordered table-striped">
                    <thead>
                        <tr style="text-align: center">
                            <th style="width: 10px">No.</th>
                            <th style="width: 110px">Reff Code</th>
                            <th style="width: 120px">Trx Name</th>
                            <th style="width: 130px">Time Stamps</th>
                            <th style="width: 50px">Trans</th>
                            <th style="width: 110px">Account</th>
                            <th>Short Name</th>
                            <th style="width: 30px">Ccy</th>
                            <th>Posting Amount</th>
                            <th>User ID</th>
                            <th>User Oto</th>
                            <th>Status Trx</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($data != ''): ?>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        <tr style="text-align: center">
                            <td><?php echo e($key+1); ?>.</td>
                            <td><?php echo e($value['trxRef']); ?></td>
                            <td><?php echo e($value['trxName']); ?></td>
                            <td><?php echo e($value['trxDate']); ?></td>
                            
                            <?php if($value['trxType'] != 'DC'): ?>
                            <td><?php echo e(isset($value['addtInfo']['rc']) ? $value['addtInfo']['txCode'] : '-'); ?></td>
                            <td><?php echo e(isset($value['addtInfo']['rc']) ? $value['addtInfo']['branch'].'-'.$value['addtInfo']['cif'].'-'.$value['addtInfo']['suffix'] : null); ?></td>
                            <td><?php echo e(isset($value['addtInfo']['rc']) ? $value['addtInfo']['accountName'] : null); ?></td>
                            <td><?php echo e(isset($value['addtInfo']['rc']) ? $value['addtInfo']['currency'] : null); ?></td> 
                            <?php else: ?>
                                <?php if($value['addtInfo']['responseCode'] == '00'): ?>
                                <td><?php echo isset($value['addtInfo']['responseCode']) ? $value['addtInfo']['data']['drCode'].'<br>'.$value['addtInfo']['data']['crCode'] : '-'; ?></td>
                                <td><?php echo e($value['trxSrcAcct']); ?><br><?php echo e($value['trxDstAcct']); ?></td>
                                <td><?php echo isset($value['addtInfo']['responseCode']) ? to_camel($value['addtInfo']['data']['sourceAccountName']).'<br>'.to_camel($value['addtInfo']['data']['destinationAccountName']) : null; ?></td>
                                <td><?php echo isset($value['addtInfo']['responseCode']) ? $value['addtInfo']['data']['sourceCurrency'].'<br>'.$value['addtInfo']['data']['destinationCurrency']  : null; ?></td>
                                <?php else: ?>
                                <td>-</td>
                                <td><?php echo e($value['trxSrcAcct']); ?><br><?php echo e($value['trxDstAcct']); ?></td></td>
                                <td>-</td>
                                <td>-</td>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <td style="text-align: right"><?php echo e(number_format($value['trxAmount'])); ?> [<b><?php echo e($value['trxType']); ?></b>]</td>
                            <td><?php echo e($value['createdBy']); ?></td>
                            <td><?php echo e($value['overrideBy']); ?></td>
                            <td><?php echo e($value['isSuccess'] == true ? 'Sukses' : 'Gagal'); ?></td>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/Pemindahbukuan/Providers/../views/report-transaksi/default.blade.php ENDPATH**/ ?>