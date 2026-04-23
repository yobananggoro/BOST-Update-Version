<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
</ul>

<ul class="navbar-nav ml-auto">
    <!-- <li class="nav-item dropdown">
        <has-notification />
    </li>  -->
    <li class="nav-item">
        <a href="<?php echo e(route('profile')); ?>" class="nav-link" rel="content">
            <i class="fas fa-user"></i>&nbsp;
            <span class="hidden-xs"><?php echo e(auth()->user()->profile->nama); ?></span>
        </a>
    </li>

    <li class="nav-item">
        <a href="<?php echo e(url('/logout')); ?>" class="nav-link"
           onclick="event.preventDefault();document.getElementById('form-logout').submit();">
            <i class="fas fa-power-off"></i> <?php echo e(__('label.logout')); ?>

        </a>

        <?php echo e(Form::open(['url' => '/logout', 'method' => 'post', 'id' => 'form-logout'])); ?>

        <?php echo e(Form::close()); ?>

    </li>
</ul><?php /**PATH D:\Data\Pemograman\laragon\www\apuppt\resources\views/layouts/partials/header.blade.php ENDPATH**/ ?>