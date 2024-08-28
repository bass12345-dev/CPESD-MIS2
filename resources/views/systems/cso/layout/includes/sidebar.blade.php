<div class="sidebar-menu ">
    <div class="sidebar-header">
        <div class="logo">
            <a href=""><img src="{{asset('assets/logo/peso_logo.png')}}" alt="logo"></a>
        </div>
    </div>
    <div class="main-menu ">
        <div class="menu-inner">
            <nav>
            <?php $segments = Request::segments(); ?>
                <ul class="metismenu" id="menu">
                    <li class="<?= $segments[2] == 'dashboard' ? 'active' : '' ?>">
                        <a href="{{url('/user/cso/dashboard')}}"><i class="ti-pie-chart"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="<?= $segments[2] == 'manage-cso' ? 'active' : '' ?>"><a href="{{url('/user/cso/manage-cso')}}"><i class="fa fa-history"></i>
                            <span>Manage CSO</span></a></li>
                    <li class="<?= $segments[2] == 'activity-logs' ? 'active' : '' ?>"><a
                        href="{{url('/user/cso/activity-logs')}}"><i class="fa fa-history"></i>
                        <span>Activity Logs</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>