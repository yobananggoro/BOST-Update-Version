<html>

<head>
    <style>
        .table-bordered {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 9px;
            font-family: "Times New Roman", Times, serif;
            width: 100%;
        }

        .table-bordered th {
            border: 1px solid black;
            border-collapse: collapse;
            background-color: lightgrey
        }

        .table-bordered td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        .table-borderless {
            font-size: 12px;
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</head>

<body>
    <h5 style="text-align: center">LAPORAN TRANSAKSI PER OPERATOR</h5>
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
            <td>Dicetak</td>
            <td>:</td>
            <td>Jam <?php echo e($printDate->toTimeString()); ?> Tgl. <?php echo e(date('d-m-Y', strtotime($printDate->toDateString()))); ?></td>
        </tr>
    </table><br>

    <table class="table-bordered">
        <thead>
            <tr>
                <th style="width:10px">No.</th>
                <th style="width:40px">Trx Code</th>
                <th style="width:70px">Cheque No</th>
                <th style="width:70px">Account</th>
                <th>Account Name</th>
                <th>Account Status</th>
                <th>Amount</th>
                <th>Trx Status</th>
                <th>Posting Date</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            preg_match('/^(\d{4}-\d{2}-\d{2})-(\d{2})\.(\d{2})\.(\d{2})\.(\d{6})$/', $d['postingDt'], $matches);
            if ($matches) {
            $tanggal = $matches[1]; // 2025-04-29
            $jam = $matches[2]; // 10
            $menit = $matches[3]; // 18
            $detik = $matches[4]; // 10

            $postdt = DateTime::createFromFormat('Y-m-d H:i:s', "$tanggal $jam:$menit:$detik");
            }
            ?>
            <tr>
                <?php if($d['trxType'] != 'dc'): ?>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($d['trxType'] == 'd' ? $d['trxCodeDebit'].' (D) ' : $d['trxCodeCredit'].' (C) '); ?></td>
                <td><?php echo e($d['chequeNumber']); ?></td>
                <td><?php echo e($d['trxType'] == 'd' ? $d['srcAccountNumber'] : $d['dstAccountNumber']); ?></td>
                <td><?php echo e($d['accountName']); ?></td>
                <td><?php echo e($d['accountStatus']); ?></td>
                <td><?php echo e(number_format($d['trxAmount'],2)); ?></td>
                <td><?php echo e($d['trxStatus']); ?></td>
                <td><?php echo e($postdt->format('d-m-Y H:i:s')); ?></td>
                <?php else: ?>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($d['trxCodeDebit'].' (D) '); ?><br><?php echo e($d['trxCodeCredit'].' (C) '); ?></td>
                <td></td>
                <td><?php echo e($d['srcAccountNumber']); ?><br><?php echo e($d['dstAccountNumber']); ?></td>
                <td><?php echo e($d['accountName']); ?></td>
                <td><?php echo e($d['accountStatus']); ?></td>
                <td><?php echo e(number_format($d['trxAmount'],2)); ?></td>
                <td><?php echo e($d['trxStatus']); ?></td>
                <td><?php echo e($postdt->format('d-m-Y H:i:s.u')); ?></td>
                <?php endif; ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body><?php /**PATH /var/www/html/backoff/app/Modules/BulkTransaksi/Providers/../views/transaksi-list/pdf.blade.php ENDPATH**/ ?>