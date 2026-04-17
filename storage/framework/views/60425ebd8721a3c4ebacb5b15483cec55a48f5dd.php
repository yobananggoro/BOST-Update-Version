<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <b>Filter</b>
            </div>
            <form action="<?php echo e(url('remote-otorisasi/filter')); ?>" method="post" role="form" class="form-horizontal">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Nama Transaksi</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <select name="tipe_transaksi" class="form-control">
                                    <option value="">- Pilih -</option>
                                    <?php $__currentLoopData = $tipe_transaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e($key == $request->tipe_transaksi ? 'selected':''); ?>><?php echo e($value); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">User Maker</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" id="userID" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="<?php echo e(old('userid', @$request->userid)); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Nomor Refference</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" id="noReff" name="reff" class="form-control ucase" value="<?php echo e(old('reff', @$request->reff)); ?>">
                            </div>
                        </div>
                    </div>
                    <?php if(auth()->user()->profile->rolename == "SUPER ADMIN"): ?>
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
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-info"><i class="fas fa-search"></i> Filter</button>
                    </div>
                    <div class="btn-group">
                        <a href="<?php echo e(url('remote-otorisasi')); ?>" type="button" id="btnEnter" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><?php /**PATH D:\Data\Pemograman\laragon\www\usercodes\app\Modules\Pemindahbukuan\Providers/../views/remote-otorisasi/filter.blade.php ENDPATH**/ ?>