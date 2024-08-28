<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="">
            <span class="align-middle">System Manager</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>
            <?php $segments = Request::segments();?>

            
            <li class="sidebar-item <?= $segments[2] == 'dashboard' ? 'active' : '' ?>">
                <a class="sidebar-link" href="{{url('/admin/sysm/dashboard')}}">
                    <i class=" fas fa-file align-middle"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item <?= $segments[2] == 'manage-users' ||  $segments[2] == 'user'  ? 'active' : '' ?>">
                <a class="sidebar-link" href="{{url('/admin/sysm/manage-users')}}">
                    <i class=" fas fa-file align-middle"></i> <span class="align-middle">Manage User</span>
                </a>
            </li>
            <li class="sidebar-item <?= $segments[2] == 'login-history' ? 'active' : '' ?>">
                <a class="sidebar-link" href="{{url('/admin/sysm/login-history')}}">
                    <i class=" fas fa-file align-middle"></i> <span class="align-middle">Login History</span>
                </a>
            </li>


          



        </ul>


    </div>
</nav>