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
                        <a href="{{url('/admin/rfa/dashboard')}}"><i class="ti-pie-chart"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="<?= $segments[2] == 'pending' ? 'active' : '' ?>"><a
                            href="{{url('/admin/rfa/pending')}}"><i class="fa fa-history"></i>
                            <span>Pending RFA</span><span class="badge badge-danger count_pending_rfa">0</span></a></li>
                    <li class="<?= $segments[2] == 'report' ? 'active' : '' ?>"><a
                            href="{{url('/admin/rfa/report')}}"><i class="fa fa-history"></i>
                            <span>RFA Report</span></a></li>
                    <li class="<?= $segments[2] == 'clients' ? 'active' : '' ?>"><a
                            href="{{url('/admin/rfa/clients')}}"><i class="fa fa-history"></i>
                            <span>Clients</span></a></li>
                    <li class="<?= $segments[2] == 'activity-logs' ? 'active' : '' ?>"><a
                            href="{{url('/admin/rfa/activity-logs')}}"><i class="fa fa-history"></i>
                            <span>Activity Logs</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>