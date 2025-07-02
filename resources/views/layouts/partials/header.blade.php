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
        <a href="{{ route('profile') }}" class="nav-link" rel="content">
            <i class="fas fa-user"></i>&nbsp;
            <span class="hidden-xs">{{ auth()->user()->profile->nama }}</span>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ url('/logout') }}" class="nav-link"
           onclick="event.preventDefault();document.getElementById('form-logout').submit();">
            <i class="fas fa-power-off"></i> {{ __('label.logout') }}
        </a>

        {{ Form::open(['url' => '/logout', 'method' => 'post', 'id' => 'form-logout']) }}
        {{ Form::close() }}
    </li>
</ul>