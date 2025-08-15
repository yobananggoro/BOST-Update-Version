
<?php $__env->startSection('title', 'Account Balance [AB]'); ?>
<?php $__env->startSection('content'); ?>
<div class="col-sm-5">
    <div class="card card-default">
        <form action="<?php echo e(route('account-balance.store')); ?>" method="post" id="formAccount" class="form-horizontal">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <input type="hidden" name="accuse" id="accuse" value="<?php echo e(@$accuse); ?>" />
                <div class="form-group">
                    <label>Account</label>
                    <div class="row">
                        <div class="col-sm-12"> 
                            <input type="text" id="extAcctNumber" class="form-control number" name="extAcctNumber" value="<?php echo e(@$extAcctNumber); ?>" maxlength="13" placeholder="External Account">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" id="branch" class="form-control number" name="branch" value="<?php echo e(@$branch); ?>" maxlength="4" placeholder="Branch">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" id="cif" class="form-control ucase" name="cif" value="<?php echo e(@$cif); ?>" maxlength="6" placeholder="Cif">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" id="suffix" class="form-control number" name="suffix" value="<?php echo e(@$suffix); ?>" maxlength="3" placeholder="Suffix">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer clearfix">
                <div class="col-12">
                    <div class="margin">
                        <div class="btn-group">
                            <button id="btnEnter" class="btn btn-primary">Detail</button>
                        </div>
                        <div class="btn-group">
                            <a type="button" href="<?php echo e(url('account-balance')); ?>" class="btn btn-danger">Reset</a>
                        </div>
                        <div class="btn-group">
                            <button type="button" id="btnToggleAccount" class="btn btn-warning float-right">Toogle</button>
                        </div>
                        <div class="btn-group float-right">
                            <button type="button" id="listRekening" class="btn btn-default" data-toggle="modal" data-target="#modal-xl" style="width: 150px; position: right">List Rekening</button>
                        </div>
                    </div>
                </div>
            </div>  
        </form>
    </div>
</div>
<div class="col-sm-5">
    <div class="card card-default" <?php if(@$cif): ?> style="display:" <?php else: ?> style="display: none" <?php endif; ?>>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <table cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td style="width: 130px">Account</td>
                                <td style="width: 25px"> :</td>
                                <td style="width: 200px"><?php echo e(@$acctNumber); ?> </td>
                                <td style="width: 250px; text-align: right"><b><?php echo e(@$custShortName); ?></b></td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td> :</td>
                                <td><?php echo e(@$cif); ?></td>
                                <td style="width: 250px; text-align: right"><b><?php echo e(@$custFullName); ?></b></td>
                            </tr>
                            <tr>
                                <td>Account Type</td>
                                <td> :</td>
                                <td><?php echo e(@$acctType); ?></td>
                            </tr>
                            <tr>
                                <td>Account Desc</td>
                                <td> :</td>
                                <td><?php echo e(@$acctTypeDesc); ?></td>
                            </tr>
                            <tr>
                                <td>Currency</td>
                                <td> :</td>
                                <td><?php echo e(@$currency); ?></td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td> :</td>
                                <td><?php echo e(@$balance); ?></td>
                            </tr>
                            <tr>
                                <td>Available Balance</td>
                                <td> :</td>
                                <td><?php echo e(@$availableBalance); ?></td>
                            </tr>
                            <tr>
                                <td>Ledger Balance</td>
                                <td> :</td>
                                <td><?php echo e(@$ledgerBalance); ?></td>
                            </tr>
                            <tr>
                                <td>Shadow Debits</td>
                                <td> :</td>
                                <td><?php echo e(@$shadowDebits); ?></td>
                            </tr>
                            <tr>
                                <td>Shadow Credits</td>
                                <td> :</td>
                                <td><?php echo e(@$shadowCredits); ?></td>
                            </tr>
                            <tr>
                                <td>Status Balance</td>
                                <td> :</td>
                                <td><?php echo e(@$statusBalance); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('account::ab.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Kerjaan\Bjb\Aplikasi AMT\Back Office\App\Local\bulk_kosongan\app\Modules\Account\Providers/../views/ab/default.blade.php ENDPATH**/ ?>