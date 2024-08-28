    <!-- Start Header Top Area -->
    <div class="header-top-area">
        <div class="container">
            <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <div class="header-top-menu">
                        <ul class="nav navbar-nav notika-top-nav">
                            <li class="nav-item dropdown">
                                <a href="{{url('/home')}}" ><i class="notika-icon notika-left-arrow"></i></></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
                    <div class="logo-area" >
                        <a href="" style="color: #fff;" class="text-center">
                            <h4>LABOR LOCALIZATION - {{session('user_type') == 'user' ? 'User' : 'Administrator  '}}</h4>
                        </a>
                    </div>
                </div>
          
            </div>
        </div>
    </div>
    <!-- End Header Top Area -->