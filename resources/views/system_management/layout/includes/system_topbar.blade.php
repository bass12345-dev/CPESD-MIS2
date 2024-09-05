<nav class="navbar navbar-expand navbar-light navbar-bg">
<?php $segments = Request::segments();?>
    <a class="sidebar-toggle js-sidebar-toggle <?= $segments[2] == 'view' ? 'd-none' : '' ?>">
        <i class="hamburger align-self-center"></i>
    </a>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-link d-none d-sm-inline-block" href="{{url('/home')}}" >
                    <span class="text-danger">Back to Home</span>
                </a>
            </li>
        </ul>
    </div>
</nav>