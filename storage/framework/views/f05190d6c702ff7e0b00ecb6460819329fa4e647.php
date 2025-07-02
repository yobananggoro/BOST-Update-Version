<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <base href="<?php echo e(config('app.url')); ?>">
    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css', request()->isSecure())); ?>">
    <!-- <link rel="stylesheet" href="<?php echo e(asset('css/tempusdominus-bootstrap-4.min.css', request()->isSecure())); ?>"> -->
    <?php echo Assets::Css(); ?>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <title><?php echo $__env->yieldContent('title'); ?> :: <?php echo e(config('app.name')); ?></title>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="loading-page">
        <div class="loading-content">
            <div class="spinner"></div>
            <h5 class="text-center loading-text">Loading...</h5><br>
        </div>
    </div>
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <?php echo $__env->make('layouts.partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </nav>
        <aside class="main-sidebar sidebar-light-warning elevation-4">
            <?php echo $__env->make('layouts.partials.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </aside>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <!-- <h1 class="m-0 text-dark"><?php echo $__env->yieldContent('title'); ?></h1> -->
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active"><?php echo $__env->yieldContent('title'); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <?php echo $__env->make('layouts.partials.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </section>
        </div>
        <footer class="main-footer">
            <?php echo $__env->make('layouts.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </footer>
    </div>
    <script src="<?php echo e(asset('js/app.js', request()->isSecure())); ?>"></script>
    <?php echo Assets::js();; ?>

    <script>
        $(function() {
            window.onload = function() {
                let wrapper = document.querySelector('.content.wrapper');
                let zoomFactor = 0.8;
                let originalHeight = 752.047;

                wrapper.style.minHeight = (originalHeight / zoomFactor) + 'px';
            };
        });
    </script>
    
    
    
    
    

    
</body>

</html><?php /**PATH /var/www/html/backoff/resources/views/layouts/app.blade.php ENDPATH**/ ?>