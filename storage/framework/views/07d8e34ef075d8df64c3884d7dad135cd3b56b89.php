
<?php $__env->startSection('title', 'Email Simba List'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('EmailSimba::filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="card card-default">
    <div class="card-body">
        <table class="table table-striped tablesaw" data-tablesaw-mode="stack">
            <thead>
                <tr>
                    <?php if(hasModulePermission('email-simba')): ?>
                    <th><?php echo e(__('label.action')); ?></th>
                    <?php endif; ?>
                    <th>Branch Code</th>
                    <th>Email</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php if($data != null): ?>
                <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <?php if(hasModulePermission('email-simba')): ?>
                    <td><?php echo Html::linkUpdateDelete('email-simba', ['id' => $d['uuid'], 'label' => $d['email']]); ?></td>
                    <?php endif; ?>
                    <td><?php echo e($d['branchCode']); ?></td>
                    <td><?php echo e($d['email']); ?></td>
                    
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        <div class="row">
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
                            <a href="/email-simba?page=<?php echo e(@$data['currentPage'] - 1); ?>" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
                                ‹
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <li class="paginate_button page-item next" id="example1_next">
                            <a href="/email-simba?page=0" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
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
                            <a href="/email-simba?page=<?php echo e($i); ?>" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
                                <?php echo e($i + 1); ?>

                            </a>
                        </li>  
                        <?php else: ?>
                        <li class="paginate_button page-item">
                            <a href="/email-simba?page=<?php echo e($i); ?>" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
                                <?php echo e($i + 1); ?>

                            </a>
                        </li>    
                        <?php endif; ?>
                        
                        <?php endif; ?>
                        <?php endfor; ?>
                        <li class="paginate_button page-item next" id="example1_next">
                            <a href="/email-simba?page=<?php echo e(@$data['totalPages'] -1); ?>" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
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
                            <a href="/email-simba?page=<?php echo e(@$data['currentPage'] + 1); ?>" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
                                ›
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="col-6 text-right">
                <?php echo Html::linkCreate('email-simba'); ?>

            </div>
        </div>

        <div class="col-md-6">
            <p>Total Data <?php echo e(@$data['totalItems']); ?> Page  <?php echo e(@$data['currentPage'] + 1); ?> Total Page <?php echo e(@$data['totalPages']); ?></p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/EmailSimba/Providers/../views/default.blade.php ENDPATH**/ ?>