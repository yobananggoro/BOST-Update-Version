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
                    
                    <div <?php if($module->uri != '#' && !empty($module->parent_id)): ?> class="col-md-12 mb-2 bg-danger" <?php else: ?> class="col-md-12 mb-2 bg-primary" <?php endif; ?>>
                        <div class="checkbox-inline">
                            <label for="<?php echo e($module->label); ?>">
                                <?php ($checked = $permission->modules && $permission->modules->where('id', $module->id)->count()); ?>
                                <?php echo e(Form::checkbox('modules[]', $module->id, $checked, ['class' => 'access access' . $loop->index])); ?>

                                <?php echo e($module->label); ?>

                            </label>
                            <label for="<?php echo e($module->label); ?>" class="float-right">
                                [ 
                                    <?php if(empty($module->parent_id)): ?>
                                        Parent
                                    <?php else: ?>
                                        Child of 
                                        <?php echo e(optional(
                                                $modules->firstWhere('id', $module->parent_id)
                                            )->label); ?>

                                    <?php endif; ?>
                                ]
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
    </div>

    <div class="card-footer clearfix">
        <?php echo e(Form::fgFormButton('hak-akses', $segment)); ?>

    </div>
</div>
<?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Kerjaan\Bjb\Aplikasi AMT\Back Office\App\Local\bulk_kosongan\app\Modules\HakAkses\Providers/../views/form.blade.php ENDPATH**/ ?>