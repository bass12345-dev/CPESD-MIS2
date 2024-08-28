    <!-- Main Menu area start-->
    <div class="main-menu-area mg-tb-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php $segments = Request::segments();?>
                    <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                        <li><a data-toggle="tab" class="<?= $segments[2] == 'dashboard' || $segments[2] == 'analytics' ? 'active' : '' ?>" href="#Home1"><i class="notika-icon notika-house"></i> Home</a>
                        </li>
                        <li><a data-toggle="tab" class="<?= $segments[2] == 'add-new-contractor' || $segments[2] == 'contractors-list' ? 'active' : '' ?>" href="#mailbox1"><i class="notika-icon notika-mail"></i>Contractors</a>
                        </li>
                        <li><a data-toggle="tab" class="<?= $segments[2] == 'pending-monitoring' || $segments[2] == 'projects-list' || $segments[2] == 'approved-monitoring' ? 'active' : '' ?>" href="#all_projects"><i class="notika-icon notika-mail"></i>Projects</a>
                        </li>
                        <li><a data-toggle="tab" class="<?= $segments[2] == 'project-nature' ? 'active' : '' ?>" href="#project_nature"><i class="notika-icon notika-mail"></i>Project Nature</a>
                        </li>
                        <li><a data-toggle="tab" class="<?= $segments[2] == 'whip-positions' ? 'active' : '' ?>" href="#positions"><i class="notika-icon notika-mail"></i>Positions</a>
                        </li>
                        <li><a data-toggle="tab" class="<?= $segments[2] == 'employment-status' ? 'active' : '' ?>" href="#status"><i class="notika-icon notika-mail"></i>Employment Status</a>
                        </li>
                        <li><a data-toggle="tab" class="<?= $segments[2] == 'employees-record' ? 'active' : '' ?>" href="#employees"><i class="notika-icon notika-mail"></i>Employees Record</a>
                        </li>
                        
                        <!-- <li><a data-toggle="tab" class="<?= $segments[2] == 'dashboar' ? 'active' : '' ?>" href="#compliant"><i class="notika-icon notika-mail"></i>Compliant</a>
                        </li> -->

                    </ul>
                    <div class="tab-content custom-menu-content">
                        <div id="Home1" class="tab-pane in <?= $segments[2] == 'dashboard' || $segments[2] == 'analytics' ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('admin/whip/dashboard')}} " class="<?= $segments[2] == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
                                </li>
                                <li><a href="{{url('admin/whip/analytics')}}" class="<?= $segments[2] == 'analytics' ? 'active' : '' ?>">Analytics</a>
                                </li>

                            </ul>
                        </div>
                        <div id="mailbox1" class="tab-pane <?= $segments[2] == 'add-new-contractor' || $segments[2] == 'contractors-list'  ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('admin/whip/add-new-contractor')}}" class="<?= $segments[2] == 'add-new-contractor' ? 'active' : '' ?>">Add New</a>
                                </li>
                                <li><a href="{{url('admin/whip/contractors-list')}}" class="<?= $segments[2] == 'contractors-list' ? 'active' : '' ?>">Contractors List</a>
                                </li>

                            </ul>
                        </div>
                        <div id="all_projects" class="tab-pane <?= $segments[2] == 'pending-monitoring' || $segments[2] == 'projects-list' || $segments[2] == 'approved-monitoring'  ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                
                                <li><a href="{{url('admin/whip/projects-list')}}" class="<?= $segments[2] == 'projects-list' ? 'active' : '' ?>">Projects List</a>
                                </li>
                                <li><a href="{{url('admin/whip/pending-monitoring')}}" class="<?= $segments[2] == 'pending-monitoring' ? 'active' : '' ?>">Pending Monitoring</a>
                                </li>
                                <li><a href="{{url('admin/whip/approved-monitoring')}}" class="<?= $segments[2] == 'approved-monitoring' ? 'active' : '' ?>">Approved Monitoring</a>
                                </li>
                            </ul>
                        </div>
                        <div id="project_nature" class="tab-pane <?= $segments[2] == 'project-nature'  ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('admin/whip/project-nature')}}" class="<?= $segments[2] == 'project-nature' ? 'active' : '' ?>">Manage Project Nature</a>
                                </li>
                            </ul>
                        </div>
                        <div id="positions" class="tab-pane <?= $segments[2] == 'whip-positions'  ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('admin/whip/whip-positions')}}" class="<?= $segments[2] == 'whip-positions' ? 'active' : '' ?>">Manage Positions</a>
                                </li>
                            </ul>
                        </div>
                        <div id="status" class="tab-pane <?= $segments[2] == 'employment-status'  ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('admin/whip/employment-status')}}" class="<?= $segments[2] == 'employment-status' ? 'active' : '' ?>">Manage Employment Status</a>
                                </li>
                            </ul>
                        </div>
                        <div id="employees" class="tab-pane <?= $segments[2] == 'employees-record'  ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('admin/whip/employees-record')}}" class="<?= $segments[2] == 'employees-record' ? 'active' : '' ?>">Manage Employees Record</a>
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