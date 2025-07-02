<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    
    <link rel="shortcut icon" href="<?php echo e(asset('img/logo.png')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css', request()->isSecure())); ?>">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    
    <title><?php echo $__env->yieldContent('title'); ?> :: Back Office</title>
</head>
<body class="hold-transition login-page">
<div class="login-box mt-n5">
    <div class="login-logo">
        <img src="<?php echo e(asset('img/logo.png')); ?>" alt="" width="140" height="80">
    </div>

    <?php echo $__env->make('layouts.partials.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="card">
        <div class="card-body login-card-body">
            <h4 class="login-box-msg"><?php echo e(config('app.display_name')); ?></h4>
            
            <?php echo $__env->yieldContent('content'); ?>
        </div>

    <div class="card-footer text-center">
        <ul class="list-unstyled" style="font-size: 0.8em">
            <li>Gunakan User ID dan Password Domain BANKJABAR</li>
            <hr>
            <li>Untuk reset password dapat menghubungi IT Help Desk di extension 5101 – 5119</li>
        </ul>
    </div>
    </div>
</div>
<script src="<?php echo e(asset('js/app.js', request()->isSecure())); ?>"></script>
</body>
</html><?php /**PATH /var/www/html/backoff/resources/views/layouts/auth.blade.php ENDPATH**/ ?>