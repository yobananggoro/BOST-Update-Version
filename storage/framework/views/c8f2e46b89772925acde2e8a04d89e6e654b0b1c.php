<a href="<?php echo e(url('/')); ?>" class="brand-link">
    <img src="<?php echo e(asset('img/' . config('app.logo'))); ?>" alt="<?php echo e(config('app.name')); ?>" class="brand-image">
    <span class="brand-text font-weight-light"><b><?php echo e(config('app.name')); ?></b></span>
</a>

<div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="<?php echo e(url('/home')); ?>" class="nav-link <?php echo e(isHome()); ?>" rel="page-content">
                    <i class="nav-icon fa fa-home"></i>
                    <p>Home</p>
                </a>
            </li>
            <?php echo Navbar::render(); ?> 
        </ul>
    </nav>
</div><?php /**PATH D:\Data\Pemograman\laragon\www\usercodes\resources\views/layouts/partials/navbar.blade.php ENDPATH**/ ?>