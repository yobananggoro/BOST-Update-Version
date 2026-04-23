
<?php $__env->startSection('title', 'Sistem Monitoring Balance ATM'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('simba::filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="card card-default">
    <div class="card-header">
            <?php if(@$data['errorMessage'] != null || @$data['errorMessage']): ?>
            <p style="text-align: right; font-size: 15pt;">
                Error : <?php echo e(@$data['errorMessage']); ?>

            </p> 
            <?php endif; ?>
            <p style="text-align: right; font-size: 15pt;">
                Balance Minimum Limit : <?php echo e(number_format(@$data['balanceMin'],2)); ?>

            </p>
    </div>
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Lokasi ATM</th>
                    <th>Id ATM</th>
                    <th>Branch Code</th>
                    <th>Balance</th>
                    <th>Last Update</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(@$data != null): ?>
                <?php $__currentLoopData = @$data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($d['description']); ?></td>
                    <td><?php echo e($d['idAtm']); ?></td>
                    <td><?php echo e($d['branchCode']); ?></td>
                    <td><?php echo e(number_format($d['balance'])); ?></td>
                    <td><?php echo e($d['updatedAt']); ?></td>
                    <?php if($d['balance'] > $data['balanceMin']): ?>
                    <td style="color: white; background-color: green">
                        AMAN
                    </td>
                    <?php else: ?>
                    <td style="color: white; background-color: red">
                        RENDAH
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        <?php if($data != null): ?>
        <div class="col-md-6">
            <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate" style="align-content: flex-end">
                <ul class="pagination">
                    <?php if((@$data['currentPage']) <= 0 ): ?>
                    <li class="paginate_button page-item previous disabled" id="example1_previous">
                        <a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
                            ‹
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="paginate_button page-item previous" id="example1_previous">
                        <a href="/simba?page=<?php echo e(@$data['currentPage'] - 1); ?>" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
                            ‹
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <li class="paginate_button page-item next" id="example1_next">
                        <a href="/simba?page=0" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                            First
                        </a>
                    </li>
                    <?php for($i = 0; $i < @$data['totalPages']; $i++): ?>
                    <?php
                    $startpage = $data['currentPage'] - 2;
                    $endpage   = $data['currentPage'] + 2;
                    ?>
                    <?php if($i >= $startpage && $i <=$endpage): ?>
                    
                    <?php if($i == @$data['currentPage']): ?>
                    <li class="paginate_button page-item active">
                        <a href="/simba?page=<?php echo e($i); ?>" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
                            <?php echo e($i + 1); ?>

                        </a>
                    </li>  
                    <?php else: ?>
                    <li class="paginate_button page-item">
                        <a href="/simba?page=<?php echo e($i); ?>" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
                            <?php echo e($i + 1); ?>

                        </a>
                    </li>    
                    <?php endif; ?>
                    
                    <?php endif; ?>
                    <?php endfor; ?>
                    <li class="paginate_button page-item next" id="example1_next">
                        <a href="/simba?page=<?php echo e(@$data['totalPages'] -1); ?>" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                            Last
                        </a>
                    </li>
                    <?php if((@$data['currentPage'] + 1) >= @$data['totalPages']): ?>
                    <li class="paginate_button page-item disabled" id="example1_next">
                        <a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                            ›
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="paginate_button page-item next" id="example1_next">
                        <a href="/simba?page=<?php echo e(@$data['currentPage'] + 1); ?>" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                            ›
                        </a>
                    </li>
                    <?php endif; ?>
                    
                </ul>
            </div>
        </div>
        <div class="col-md-6" style="text-align: left">
            <p>Total Data <?php echo e(@$data['totalItems']); ?> Page  <?php echo e(@$data['currentPage'] + 1); ?> Total Page <?php echo e(@$data['totalPages']); ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Pemograman\laragon\www\usercodes\app\Modules\Simba\Providers/../views/default.blade.php ENDPATH**/ ?>