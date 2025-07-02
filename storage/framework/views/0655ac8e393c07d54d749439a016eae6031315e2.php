<?php
$segment = request()->segment(2);
$title = 'create'; $method = 'post'; $action = 'hak-akses.store';
if ($segment !== 'create' ) { $title = 'edit'; $method = 'put'; $action = ['hak-akses.update', $permission->id]; }
?>

<?php $__env->startSection('title', __('label.' . $title) . ' Hak Akses'); ?>
<?php $__env->startSection('content'); ?>
<?php echo e(Form::open(['route' => $action, 'method' => $method, 'class' => 'form-horizontal form-data', 'autocomplete' => 'off'])); ?>

<div class="card card-success">
    <div class="card-body">
        <?php if($segment !== 'create'): ?>
        <?php echo e(Form::hidden('id', $permission->id)); ?>

        <?php endif; ?>
        
        <?php echo e(Form::fgText('Hak Akses', 'name', $permission->name, ['class' => 'form-control ucase'], null, 'text', true)); ?>

        <?php echo e(Form::fgSelect('Akses Transaksi', 'is_transactions', to_dropdown($akses_transaksi), $permission->is_transactions == "true" ? "t":"f", ['class' => 'form-control'], null, true)); ?>


        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Menu & Pengelolaan</label>
            <div class="col-md-10">
                <div class="row">
                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <div class="col-md-12 mb-2 bg-info">
                        <div class="checkbox-inline">
                            <label for="<?php echo e($module->label); ?>">
                                <?php ($checked = $permission->modules && $permission->modules->where('id', $module->id)->count()); ?>
                                <?php echo e(Form::checkbox('modules[]', $module->id, $checked, ['class' => 'access access' . $loop->index])); ?>

                                <?php echo e($module->label); ?>

                                
                                
                            </label>
                        </div>
                        <?php if(isset($permissions[$module->uri])): ?>
                        <div class="col-md-12 mb-2 bg-warning">
                            <div class="row">
                                <?php $__currentLoopData = $permissions[$module->uri]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-3">
                                    <div class="checkbox-inline mt-2">
                                        <label for="<?php echo e($perm); ?>">
                                            <?php ($checked = $permission->permissions && $permission->permissions->where('name', $perm)->count()); ?>
                                            <?php echo e(Form::checkbox('permissions[]', $perm, $checked, ['class' => 'access-child' . $loop->parent->index . ' access-child' . $loop->parent->index . '-' . $loop->index])); ?>

                                            <?php echo e(\Illuminate\Support\Str::title(str_replace('-', ' ', $perm))); ?>

                                        </label>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        
        <?php if(count($additionals)): ?>
        <div class="form-group row">
            <label for="" class="col-md-2 col-form-label">Tambahan Pengelolaan</label>
            <div class="col-md-10">
                <div class="row bg-warning">
                    <?php $__currentLoopData = $additionals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $additional): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3">
                        <div class="checkbox-inline mt-2">
                            <label for="<?php echo e($additional); ?>">
                                <?php ($checked = $permission->permissions && $permission->permissions->where('name', $additional)->count()); ?>
                                <?php echo e(Form::checkbox('permissions[]', $additional, $checked)); ?>

                                <?php echo e(\Illuminate\Support\Str::title(str_replace('-', ' ', $additional))); ?>

                            </label>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="card-footer clearfix">
        <?php echo e(Form::fgFormButton('hak-akses', $segment)); ?>

    </div>
</div>
<?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/HakAkses/Providers/../views/form.blade.php ENDPATH**/ ?>