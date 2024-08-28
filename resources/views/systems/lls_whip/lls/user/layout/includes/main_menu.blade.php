    <!-- Main Menu area start-->
    <div class="main-menu-area mg-tb-40">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 first_col_lls">
                <?php $segments = Request::segments();?>
                    <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro first">
                        <li><a data-toggle="tab" class="<?= $segments[2] == 'dashboard' ? 'active' : '' ?>" href="#Home" class="active"><i class="notika-icon notika-house"></i>
                                Home</a>
                        </li>
                        <li><a data-toggle="tab" class="<?= $segments[2] == 'add-new-establishment' || $segments[2] == 'establishments-list'  || $segments[2] == 'establishment' ? 'active' : '' ?>" href="#mailbox"><i class="fas fa-building"></i>Establishments</a>
                        </li>
                        <li><a data-toggle="tab" href="#positions" class="<?= $segments[2] == 'establishments-positions' ? 'active' : '' ?>"><i class="fas fa-users"></i>Positions</a>
                        </li>
                        <li><a data-toggle="tab" href="#employees" class="<?= $segments[2] == 'employees-record' ? 'active' : '' ?>"><i class="fas fa-users"></i>Employees Record</a>
                        </li>
                       
                    </ul>
                    <div class="tab-content custom-menu-content">
                        <div id="Home" class="tab-pane in <?= $segments[2] == 'dashboard' ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown active">
                                <li><a href="{{url('user/lls/dashboard')}}" class="<?= $segments[2] == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
                                </li>


                            </ul>
                        </div>
                        <div id="mailbox" class="tab-pane <?= $segments[2] == 'add-new-establishment' || $segments[2] == 'establishments-list'  ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('user/lls/add-new-establishment')}}" class="<?= $segments[2] == 'add-new-establishment' ? 'active' : '' ?>">Add New</a>
                                </li>
                                <li><a href="{{url('user/lls/establishments-list')}}" class="<?= $segments[2] == 'establishments-list' ? 'active' : '' ?>">Establishments List</a>
                                </li>



                            </ul>
                        </div>
                        <div id="positions" class="tab-pane in  <?= $segments[2] == 'establishments-positions' ? 'active' : '' ?> notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown ">
                                <li><a href="{{url('user/lls/establishments-positions')}}" class="<?= $segments[2] == 'establishments-positions' ? 'active' : '' ?>">Manage Positions</a>
                                </li>

                            </ul>
                        </div>
                        <div id="employees" class="tab-pane in <?= $segments[2] == 'employees-record' ? 'active' : '' ?>  notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="{{url('user/lls/employees-record')}}" class="<?= $segments[2] == 'employees-record' ? 'active' : '' ?>">Manage Employees Record</a>
                                </li>

                            </ul>
                        </div>
         

                    </div>
                </div>

            </div>
        </div>
    </div>
    <hr>
    </div>

    <!-- Main Menu area End-->