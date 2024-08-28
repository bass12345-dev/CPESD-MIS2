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
                        <a href="{{url('/user/rfa/dashboard')}}"><i class="ti-pie-chart"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="<?= $segments[2] == 'pending' ? 'active' : '' ?>"><a href="{{url('/user/rfa/pending')}}"><i class="fa fa-history"></i>
                            <span>Pending/Encoded RFA</span><span
                                class="badge badge-danger count_pending_rfa">0</span></a></li>
                    <li class="<?= $segments[2] == 'clients' ? 'active' : '' ?>"><a
                            href="{{url('/user/rfa/clients')}}"><i class="fa fa-history"></i>
                            <span>Clients</span></a></li>
                    <li class="<?= $segments[2] == 'completed' ? 'active' : '' ?>"><a
                        href="{{url('/user/rfa/completed')}}"><i class="fa fa-history"></i>
                        <span>Completed RFA</span></a></li>
                    <li class="<?= $segments[2] == 'referred' ? 'active' : '' ?>"><a
                            href="{{url('/user/rfa/referred')}}"><i class="fa fa-history"></i> <span>Referred
                                To You</span><span class="badge badge-danger count_reffered_rfa">0</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>