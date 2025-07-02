<html>
<head>
    <style>
        .table-bordered{
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 12px;
            font-family: "Times New Roman", Times, serif;
            /* margin-left: auto; */
            /* margin-right: auto; */
            width: 100%;
        } 
        .table-bordered th{
            border: 1px solid black;
            border-collapse: collapse;
            background-color: lightgrey
        }
        .table-bordered td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        
        .table-borderless{
            font-size: 12px;
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</head>
<body>
    <h5 style="text-align: center">LAPORAN TRANSAKSI PER OPERATOR<br>Per Tanggal: <?php echo e($request->startDate); ?> s.d <?php echo e($request->endDate); ?></h5>
    
    <table class="table-borderless">
        <tr>
            <td style="width: 80px">Nama Kantor</td>
            <td>:</td>
            <td><?php echo e($user->profile->unitKerja->nama); ?></td>
        </tr>
        <tr>
            <td>User</td>
            <td>:</td>
            <td><?php echo e($user->username); ?> | <?php echo e($user->profile->nip); ?> | <?php echo e($user->profile->nama); ?></td>
        </tr>
        <tr>
            <td>Mata Uang</td>
            <td>:</td>
            <td>IDR - Rupiah</td>
        </tr>
        <tr>
            <td>Dicetak</td>
            <td>:</td>
            <td>Jam <?php echo e($printDate->toTimeString()); ?> Tgl. <?php echo e(date('d-m-Y', strtotime($printDate->toDateString()))); ?></td>
        </tr>
    </table>
    <br>
    <table class="table-bordered">
        <thead>
            <tr style="text-align: center">
                <th style="width: 10px">No.</th>
                <th style="width: 120px">Reff Code</th>
                <th style="width: 120px">Trx Name</th>
                <th style="width: 130px">Time Stamps</th>
                <th style="width: 30px">Trans</th>
                <th style="width: 110px">Account</th>
                <th>Short Name</th>
                <th style="width: 30px">Ccy</th>
                <th>Posting Amount</th>
                <th>User ID</th>
                <th>User Oto</th>
                <th>Status Trx</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            if($value['trxType'] == 'D'){
                $totalDebet[] = $value['trxAmount'];
            }
            
            if($value['trxType'] == 'C'){
                $totalCredit[] = $value['trxAmount'];
            }
            
            if($value['trxType'] == 'DC'){
                $totalDebet[] = $value['trxAmount'];
                $totalCredit[] = $value['trxAmount'];
            }
            ?>
            <tr style="text-align: center">
                <td><?php echo e($key+1); ?>.</td>
                <td><?php echo e($value['trxRef']); ?></td>
                <td><?php echo e($value['trxName']); ?></td>
                <td><?php echo e($value['trxDate']); ?></td>
                <?php if($value['trxType'] != 'DC'): ?>
                    <td><?php echo e(isset($value['addtInfo']['rc']) ? $value['addtInfo']['txCode'] : '-'); ?></td>
                    <td><?php echo e(isset($value['addtInfo']['rc']) ? $value['addtInfo']['branch'].'-'.$value['addtInfo']['cif'].'-'.$value['addtInfo']['suffix'] : null); ?></td>
                    <td><?php echo e(isset($value['addtInfo']['rc']) ? $value['addtInfo']['accountName'] : null); ?></td>
                    <td><?php echo e(isset($value['addtInfo']['rc']) ? $value['addtInfo']['currency'] : null); ?></td> 
                <?php else: ?>
                    <td><?php echo isset($value['addtInfo']['responseCode']) ? $value['addtInfo']['data']['drCode'].'<br>'.$value['addtInfo']['data']['crCode'] : '-'; ?></td>
                    <td><?php echo e($value['trxSrcAcct']); ?><br><?php echo e($value['trxDstAcct']); ?></td>
                    <td><?php echo isset($value['addtInfo']['responseCode']) ? to_camel($value['addtInfo']['data']['sourceAccountName']).'<br>'.to_camel($value['addtInfo']['data']['destinationAccountName']) : null; ?></td>
                    <td><?php echo isset($value['addtInfo']['responseCode']) ? $value['addtInfo']['data']['sourceCurrency'].'<br>'.$value['addtInfo']['data']['destinationCurrency']  : null; ?></td>
                <?php endif; ?>
                <td style="text-align: right"><?php echo e(number_format($value['trxAmount'])); ?> [<b><?php echo e($value['trxType']); ?></b>]</td>
                <td><?php echo e($value['createdBy']); ?></td>
                <td><?php echo e($value['overrideBy']); ?></td>
                <td><?php echo e($value['isSuccess'] == true ? 'Sukses' : 'Gagal'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <br>
    <table class="table-borderless" style="margin-left: 50px">
        <tr>
            <td style="width: 80px">Subtotal Debet</td>
            <td>:</td>
            <td style="font-weight: bold">Rp. <?php echo e(number_format(array_sum($totalDebet))); ?></td>
        </tr>
        <tr>
            <td>Subtotal Kredit</td>
            <td>:</td>
            <td style="font-weight: bold">Rp. <?php echo e(number_format(array_sum($totalCredit))); ?></td>
        </tr>
    </table>
    <table class="table-borderless" style="width: 100%">
        <tr>
            <td style="text-align: center; height: 100px">Petugas</td>
            <td style="text-align: center; height: 100px">Supervisor / Manager Operasional</td>
        </tr>
        <tr>
            <td style="text-align: center">(...................................)</td>
            <td style="text-align: center">(...................................)</td>
        </tr>
    </table>
</p</body>
</html><?php /**PATH /var/www/html/backoff/app/Modules/Pemindahbukuan/Providers/../views/report-transaksi/pdf.blade.php ENDPATH**/ ?>