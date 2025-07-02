
<?php $__env->startSection('title', 'Detail Transaksi'); ?>
<?php $__env->startSection('content'); ?>
<div class="col-sm-6">
    <div class="card card-default">
        <div class="card-header text-center" style="font-size: 18px; font-weight: bold">Detail Transaksi</div>
        <div class="card-body">
            <div class="col-sm-12" style="font-size: 18px">
                <table cellspacing="0" cellpadding="0">
                    <tbody>
                        <?php $__currentLoopData = $response_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keySrc => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($value['isDebits'] == true): ?>
                                <tr>
                                    <td style="width: 200px; font-weight: bold">
                                        Rekening Sumber
                                    </td>
                                    <td style="width: 25px"> :</td>
                                    <td style="width: 500px">
                                        <b>
                                            <?php if($value['rc'] == '00'): ?>
                                                <?php echo e(@$value['accountNumber']); ?>

                                            <?php else: ?>
                                                <?php echo e(@$value['branch']); ?> - <?php echo e(@$value['cif']); ?> - <?php echo e(@$value['suffix']); ?>

                                            <?php endif; ?>
                                        </b>
                                    </td>
                                </tr>
                                <?php if($value['rc'] == '00'): ?>
                                    <tr>
                                        <td style="font-weight: bold">Nama</td>
                                        <td> :</td>
                                        <td><?php echo e(@$value['accountName']); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td style="font-weight: bold">Mata Uang</td>
                                    <td> :</td>
                                    <td><?php echo e(@$value['currency']); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Nominal</td>
                                    <td> :</td>
                                    <td><?php echo e(number_format(@$value['amount'])); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold">Terbilang</td>
                                    <td> :</td>
                                    <td><i><?php echo e(terbilang(@$value['amount'], null, null, @$value['currency'])); ?></i></td>
                                </tr>
                                <?php if($value['rc'] == '00'): ?>
                                    <tr>
                                        <td style="font-weight: bold">Status Debit</td>
                                        <td> :</td>
                                        <td><?php echo e(@$value['rcMsg']); ?></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td style="font-weight: bold">Status Debit</td>
                                        <td> :</td>
                                        <td><?php echo e(@$value['rcMsg'][0]['messageDesc']); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td>
                                        <hr>
                                    </td>
                                    <td>
                                        <hr>
                                    </td>
                                    <td>
                                        <hr>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <!-- <tr>
                            <td>
                                <hr>
                            </td>
                            <td>
                                <hr>
                            </td>
                            <td>
                                <hr>
                            </td>
                        </tr> -->
                        <?php $__currentLoopData = $response_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyDst => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($value['isDebits'] == false): ?>
                        <tr>
                            <td style="width: 200px; font-weight: bold">
                                Rekening Tujuan
                            </td>
                            <td style="width: 25px"> :</td>
                            <td style="width: 500px">
                                <b>
                                    <?php if($value['isDebits'] == '00'): ?>
                                    <?php echo e(@$value['accountNumber']); ?> /
                                    <?php endif; ?>
                                    <?php echo e(@$value['branch']); ?> - <?php echo e(@$value['cif']); ?> - <?php echo e(@$value['suffix']); ?>

                                </b>
                            </td>
                        </tr>
                        <?php if($value['rc'] == '00'): ?>
                        <tr>
                            <td style="font-weight: bold">Nama</td>
                            <td> :</td>
                            <td><?php echo e(@$value['accountName']); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td style="font-weight: bold">Mata Uang</td>
                            <td> :</td>
                            <td><?php echo e(@$value['currency']); ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Nominal</td>
                            <td> :</td>
                            <td><?php echo e(number_format(@$value['amount'])); ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Terbilang</td>
                            <td> :</td>
                            <td><i><?php echo e(terbilang(@$value['amount'], null, null, @$value['currency'])); ?></i></td>
                        </tr>
                        <?php if($value['rc'] == '00'): ?>
                        <tr>
                            <td style="font-weight: bold">Status Kredit</td>
                            <td> :</td>
                            <td><?php echo e(@$value['rcMsg']); ?></td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <td style="font-weight: bold">Status Kredit</td>
                            <td> :</td>
                            <td style="color: red"><?php echo e(@$value['rcMsg'][0]['messageDesc']); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td>
                                <hr>
                            </td>
                            <td>
                                <hr>
                            </td>
                            <td>
                                <hr>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="font-weight: bold">Refference</td>
                            <td> :</td>
                            <td><?php echo e(@$data['reff']); ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Nominal Total</td>
                            <td> :</td>
                            <td><?php echo e(number_format(@$data['nominal'])); ?></td>
                        </tr>
                        <!-- <tr>
                            <td style="font-weight: bold">Terbilang</td>
                            <td> :</td>
                            <td><i><?php echo e(terbilang(@$data['nominal'])); ?></i></td>
                        </tr> -->
                        <tr>
                            <td style="font-weight: bold">Keterangan</td>
                            <td> :</td>
                            <td><?php echo e(@$additional_info['narative1']); ?></td><br>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><?php echo e(@$additional_info['narative2']); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><?php echo e(@$additional_info['narative3']); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><?php echo e(@$additional_info['narative4']); ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">Status Transaksi</td>
                            <td> :</td>
                            <td><?php echo e($status_validasi_posting[$data->status_transaksi]); ?></td>
                        </tr>
                        <?php if(@$data->status_transaksi == 3): ?>
                        <?php if(@$data->response_http == 200): ?>
                        <tr>
                            <td style="font-weight: bold">Informasi Transaksi</td>
                            <td> :</td>
                            <td><?php echo e(@json_decode(@$data->response_message, true)['responseDesc']); ?></td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <td style="font-weight: bold">Informasi Transaksi</td>
                            <td> :</td>
                            <td><?php echo e(@json_decode(@$data->response_message, true)['error']); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php else: ?>
                        <tr>
                            <td style="font-weight: bold">Informasi Transaksi</td>
                            <td> :</td>
                            <td><?php echo e(@$data->response_message != null ? json_decode(@$data->response_message, true)['responseDesc'] : @$data->response_message); ?>

                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <a href="<?php echo e(url('transaksi-list')); ?>" type="button" class="btn btn-sm btn-default float-left"
                style="width: 80px">Kembali</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/backoff/app/Modules/Pemindahbukuan/Providers/../views/transaksi-list/detailPostingAGI.blade.php ENDPATH**/ ?>