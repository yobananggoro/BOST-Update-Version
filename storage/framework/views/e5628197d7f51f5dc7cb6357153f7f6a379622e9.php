
<?php $__env->startSection('title', 'User List'); ?>
<?php $__env->startSection('content'); ?>
<div class="card card-default">
    <form method="post" action="<?php echo e(url('users/isAction')); ?>">
        <?php echo csrf_field(); ?>
        <div class="card-body">
            <table id="dtTables1" class="table table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" onchange="checkAll(this)"></th>
                        <?php if(in_array(auth()->user()->profile->rolename, ['SUPER ADMIN', 'Staf ITS ', 'Staf IT'])): ?>
                        <th>Aksi</th>
                        <?php endif; ?>
                        <th>No.</th>
                        <th>Login</th>
                        <th>User ID</th>
                        <th>Nama</th>
                        <th>Nip</th>
                        <th>Unit Kerja</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><input type="checkbox" name='id[]' id="checkItem" value="<?php echo e($d->id); ?>"></td>
                        <?php if(in_array(auth()->user()->profile->rolename, ['SUPER ADMIN', 'Staf ITS ', 'Staf IT'])): ?>
                        <td><a href="<?php echo e(route('users.edit', $d->id)); ?>" type="button" class="btn btn-sm btn-default"><i class="fa fa-pencil-alt"></i></a></td>
                        <?php endif; ?>
                        <td><?php echo e($loop->iteration); ?>.</td>
                        <td class="text-center">
                            
                            <?php if(Cache::has('user-is-online-' . $d->id)): ?>
                            <span class="badge badge-success">Online</span>
                            <?php else: ?>
                            <span class="badge badge-danger">Offline</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($d->username); ?></td>
                        <td><?php echo e($d->profile->nama); ?></td>
                        <td><?php echo e($d->profile->nip); ?></td>
                        <td><?php echo e($d->profile->unitKerja->nama); ?></td>
                        <td><?php echo e($d->profile->rolename); ?></td>
                        <td><?php echo e($d->status == 1 ? 'Opened' : 'Locked'); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            
            <button type="submit" class="btn btn-sm btn-info" name="submit" value="Open" style="width: 80px"><i class="fa fa-key"></i> Open</button>
            <button type="submit" class="btn btn-sm btn-danger" name="submit" value="Lock" style="width: 80px"><i class="fa fa-lock"></i> Lock</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Pemograman\laragon\www\usercodes\app\Modules\User\Providers/../views/users.blade.php ENDPATH**/ ?>