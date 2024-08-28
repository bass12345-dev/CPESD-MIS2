<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="">
            <span class="align-middle">PESO Watchlisted User</span>
        </a>

        <?php $segments = Request::segments(); ?>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item <?= $segments[2] == 'dashboard' ? 'active' : '' ?>">
                <a class="sidebar-link" href="{{url('/user/watchlisted/dashboard')}}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item <?= $segments[2] == 'approved' ? 'active' : '' ?>">
                <a class="sidebar-link" href="{{url('/user/watchlisted/approved')}}">
                    <i class=" fas fa-file align-middle"></i> <span class="align-middle">Approved</span>
                </a>
            </li>

            <li class="sidebar-item <?= $segments[2] == 'pending' ? 'active' : '' ?>">
                <a class="sidebar-link" href="{{url('/user/watchlisted/pending')}}">
                    <i class="fas fa-file align-middle"></i> <span class="align-middle">Pending</span>
                </a>
            </li>

            <li class="sidebar-item <?= $segments[2] == 'removed' ? 'active' : '' ?>">
                <a class="sidebar-link" href="{{url('/user/watchlisted/removed')}}">
                    <i class="fas fa-file align-middle"></i> <span class="align-middle">Removed</span>
                </a>
            </li>

            <li class="sidebar-item <?= $segments[2] == 'add' ? 'active' : '' ?>">
                <a class="sidebar-link" href="{{url('/user/watchlisted/add')}}">
                    <i class="align-middle" data-feather="plus"></i> <span class="align-middle">Add</span>
                </a>
            </li>

            <li class="sidebar-item <?= $segments[2] == 'search' ? 'active' : '' ?>">
                <a class="sidebar-link" href="{{url('/user/watchlisted/search')}}">
                    <i class="align-middle" data-feather="search"></i> <span class="align-middle">Search</span>
                </a>
            </li>
        </ul>
    </div>
</nav>