<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <b>Filter</b>
            </div>
            <form action="<?php echo e(url('remote-otorisasibulk/filter')); ?>" method="post" role="form" class="form-horizontal">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <input type="hidden" name="status_bulk" value="VERIFIED_AND_WAITING_APPROVAL">
                    <?php if(auth()->user()->profile->rolename == "SUPER ADMIN"): ?>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">UserID Maker</label>
                        <div class="col-sm-4">
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
                                    
                                    <option value="<?php echo e($value['kode']); ?>" <?php echo e($value['kode'] == $request->branch ? 'selected':''); ?>><?php echo e($value['nama']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">UserID Maker</label>
                        <div class="col-sm-4">
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
                                    
                                    <option value="<?php echo e($value['kode']); ?>" <?php echo e($value['kode'] == auth()->user()->profile->unit_kerja_kode ? 'selected':''); ?>><?php echo e($value['nama']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <input type="hidden" name="branch" value="<?php echo e(auth()->user()->profile->unit_kerja_kode); ?>">
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-info"><i class="fas fa-search"></i> Filter</button>
                    </div>
                    <div class="btn-group">
                        <a href="<?php echo e(url('remote-otorisasibulk')); ?>" type="button" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><?php /**PATH D:\Data\Kerjaan\Bjb\Aplikasi AMT\Back Office\App\Local\bulk_kosongan\app\Modules\BulkTransaksi\Providers/../views/remote-otorsasibulk/filter.blade.php ENDPATH**/ ?>