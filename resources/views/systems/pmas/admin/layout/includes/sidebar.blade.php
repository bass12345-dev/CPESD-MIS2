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
                        <a href="{{url('/admin/pmas/dashboard')}}"><i class="ti-pie-chart"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="<?= $segments[2] == 'pending' ? 'active' : '' ?>"><a
                            href="{{url('/admin/pmas/pending')}}"><i class="fa fa-history"></i>
                            <span>Pending</span><span class="badge badge-danger count_pending">0</span></a></li>
                    <li class="<?= $segments[2] == 'report' ? 'active' : '' ?>"><a
                            href="{{url('/admin/pmas/report')}}"><i class="fa fa-history"></i>
                            <span>PMAS Report</span></a>
                    </li>
                    <li
                        class="<?= $segments[2] == 'responsibility-center' || $segments[2] == 'responsible-section' || $segments[2] == 'type-of-activity' || $segments[2] == 'cso' ? 'active' : ''?>">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-eye"></i><span>See More</span>
                        </a>
                        <ul class="collapse">
                            <li class="<?= $segments[2] == 'cso' ? 'active' : ''?>"><a
                                    href="{{url('/admin/pmas/cso')}}"><i class="fa fa-sitemap"></i> <span>CSO
                                    </span></a></li>
                            <li class="<?= $segments[2] == 'responsibility-center' ? 'active' : ''?>"><a
                                    href="{{url('/admin/pmas/responsibility-center')}}"><i
                                        class="fa fa-chevron-right"></i> <span>Responsibilty Center</span></a></li>
                            <li class="<?= $segments[2] == 'responsible-section' ? 'active' : ''?>"><a
                                    href="{{url('/admin/pmas/responsible-section')}}"><i
                                        class="fa fa-chevron-right"></i> <span>Responsible Section</span></a></li>
                            <li class="<?= $segments[2] == 'type-of-activity' ? 'active' : ''?>"><a
                                    href="{{url('/admin/pmas/type-of-activity')}}"><i
                                        class="fa fa-chevron-right"></i> <span>Type of Activity</span></a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>