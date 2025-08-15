<a href="{{ url('/') }}" class="brand-link">
    <img src="{{ asset('img/' . config('app.logo')) }}" alt="{{ config('app.name') }}" class="brand-image">
    <span class="brand-text font-weight-light"><b>{{ config('app.name') }}</b></span>
</a>

<div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/home') }}" class="nav-link {{ isHome() }}" rel="page-content">
                    <i class="nav-icon fa fa-home"></i>
                    <p>Home</p>
                </a>
            </li>
            {!! Navbar::render() !!} 
        </ul>
    </nav>
</div>