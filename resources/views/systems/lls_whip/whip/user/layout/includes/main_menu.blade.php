    <!-- Main Menu area start-->
    <div class="main-menu-area mg-tb-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php $segments = Request::segments();?>
                    <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                        <li><a data-toggle="tab" class="<?= $segments[2] == 'dashboard' ? 'active' : '' ?>" href="#Home1"><i class="notika-icon notika-house"></i> Home</a>
                        </li>
                        <li><a data-toggle="tab" class="<?= $segments[2] == 'add-new-contractor' || $segments[2] == 'contractors-list' ? 'active' : '' ?>" href="#mailbox1"><i class="notika-icon notika-mail"></i>Contractors</a>
                        </li>
                        <li><a data-toggle="tab" class="<?= $segments[2] == 'add-new-project' || $segments[2] == 'projects-list' || $segments[2] == 'add-monitoring' || $segments[2] == 'pending-projects-monitoring' || $segments[2] == 'project-monitoring-info' || $segments[2] == 'approved-projects-monitoring' ? 'active' : '' ?>" href="#all_projects"><i class="notika-icon notika-mail"></i>Projects</a>
                        </li>
                        <li><a data-toggle="tab" class="<?= $segments[2] == 'whip-positions' ? 'active' : '' ?>" href="#positions"><i class="notika-icon notika-mail"></i>Positions</a>
                        </li>
                        <li><a data-toggle="tab" href="#employees" class="<?= $segments[2] == 'employees-record' ? 'active' : '' ?>"><i class="notika-icon notika-mail"></i>Employees Record</a>
                        </li>
                        <!-- <li><a data-toggle="tab" href="#compliant"><i class="notika-icon notika-mail"></i>Compliant</a>
                        </li> -->
                    </ul>
                    <div class="tab-content custom-menu-content">
                        <div id="Home1" class="tab-pane in <?= $segments[2] == 'dashboard' ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('user/whip/dashboard')}}" class="<?= $segments[2] == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
                                </li>
                                <li><a href="analytics.html">Analytics</a>
                                </li>

                            </ul>
                        </div>
                        <div id="mailbox1" class="tab-pane <?= $segments[2] == 'add-new-contractor' || $segments[2] == 'contractors-list'  ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('user/whip/add-new-contractor')}}" class="<?= $segments[2] == 'add-new-contractor' ? 'active' : '' ?>">Add New</a>
                                </li>
                                <li><a href="{{url('user/whip/contractors-list')}}" class="<?= $segments[2] == 'contractors-list' ? 'active' : '' ?>">Contractors List</a>
                                </li>

                            </ul>
                        </div>
                        <div id="all_projects" class="tab-pane <?= $segments[2] == 'add-new-project' || $segments[2] == 'projects-list' || $segments[2] == 'add-monitoring' || $segments[2] == 'pending-projects-monitoring' || $segments[2] == 'approved-projects-monitoring'  ? 'active' : ''  ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('user/whip/add-new-project')}}" class="<?= $segments[2] == 'add-new-project' ? 'active' : '' ?>">Add New Project</a>
                                </li>
                                <li><a href="{{url('user/whip/projects-list')}}" class="<?= $segments[2] == 'projects-list' ? 'active' : '' ?>">Projects List</a>
                                </li>
                                <li><a href="{{url('user/whip/add-monitoring')}}" class="<?= $segments[2] == 'add-monitoring' ? 'active' : '' ?>">Add New Monitoring</a>
                                </li>
                                <li><a href="{{url('user/whip/pending-projects-monitoring')}}" class="<?= $segments[2] == 'pending-projects-monitoring' ? 'active' : '' ?>">Pending Projects Monitoring</a>
                                </li>
                                <li><a href="{{url('user/whip/approved-projects-monitoring')}}" class="<?= $segments[2] == 'approved-projects-monitoring' ? 'active' : '' ?>">Approved Projects Monitoring</a>
                                </li>
                            </ul>
                        </div>
                        <div id="positions" class="tab-pane <?= $segments[2] == 'whip-positions'  ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('user/whip/whip-positions')}}" class="<?= $segments[2] == 'whip-positions' ? 'active' : '' ?>">Manage Positions</a>
                                </li>
                            </ul>
                        </div>
                        <div id="employees" class="tab-pane <?= $segments[2] == 'employees-record'  ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('user/whip/employees-record')}}" class="<?= $segments[2] == 'employees-record' ? 'active' : '' ?>">Manage Employees Record</a>
                                </li>
                            </ul>
                        </div>
                        <!-- <div id="compliant" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('admin/whip/compliant-reports')}}">Compliant Report</a>
                                </li>
                            </ul>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>

    <!-- Main Menu area End-->