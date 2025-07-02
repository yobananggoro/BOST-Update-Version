<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <b>Filter</b>
            </div>
            <form action="<?php echo e(url('list-bulkupload/filter')); ?>" method="post" role="form" class="form-horizontal">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <?php if(auth()->user()->profile->rolename == "SUPER ADMIN"): ?>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">UserID Maker</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" id="userID" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="<?php echo e(old('userid', @$request->userid)); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Branch</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select name="branch" class="form-control select2">
                                    <option value="">- Pilih -</option>
                                    <?php $__currentLoopData = $branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <!-- <option value=""><?php echo e($value['nama']); ?></option> -->
                                    <option value="<?php echo e($value['kode']); ?>" <?php echo e($value['kode'] == $request->branch ? 'selected':''); ?>><?php echo e($value['nama']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">UserID Maker</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <?php if(!in_array(auth()->user()->profile->rolename, ['Administrasi Dana Dan Jasa', 'Administrasi Kredit', 'Administrasi Operasional'])): ?>
                                <input type="text" id="userID" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="<?php echo e(old('userid', @$request->userid)); ?>">
                                <?php else: ?>
                                <input type="text" id="userID" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="<?php echo e(auth()->user()->username); ?>" readonly>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Branch</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select class="form-control select2" disabled>
                                    <?php $__currentLoopData = $branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <!-- <option value=""><?php echo e($value['nama']); ?></option> -->
                                    <option value="<?php echo e($value['kode']); ?>" <?php echo e($value['kode'] == auth()->user()->profile->unit_kerja_kode ? 'selected':''); ?>><?php echo e($value['nama']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <input type="hidden" name="branch" value="<?php echo e(auth()->user()->profile->unit_kerja_kode); ?>">
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Status Transaksi</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select name="status_bulk" class="form-control">
                                    <option value="" selected>- Pilih -</option>
                                    <?php $__currentLoopData = $status_bulk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e($key == $request->status_bulk ? 'selected':''); ?>><?php echo e($value); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-info"><i class="fas fa-search"></i> Filter</button>
                    </div>
                    <div class="btn-group">
                        <a href="<?php echo e(url('list-bulkupload')); ?>" type="button" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><?php /**PATH /var/www/html/backoff/app/Modules/BulkTransaksi/Providers/../views/transaksi-list/filter.blade.php ENDPATH**/ ?>