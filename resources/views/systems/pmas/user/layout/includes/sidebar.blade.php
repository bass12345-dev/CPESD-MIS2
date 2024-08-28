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
                        <a href="{{url('/user/pmas/dashboard')}}"><i class="ti-pie-chart"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="<?= $segments[2] == 'pending' ? 'active' : '' ?>"><a href="{{url('/user/pmas/pending')}}"><i class="fa fa-history"></i>
                            <span>Pending Transactions</span><span
                                class="badge badge-danger count_pending">0</span></a></li>
                    <li class="<?= $segments[2] == 'completed' ? 'active' : '' ?>"><a
                        href="{{url('/user/pmas/completed')}}"><i class="fa fa-history"></i>
                        <span>Completed Transactions</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>