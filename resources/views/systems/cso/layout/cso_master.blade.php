<!doctype html>
<html class="no-js" lang="en">
<head>
    @include('global_includes.meta')
    @include('systems.rfa.includes.css')
    
</head>
<body>
    @include('components.pmas_rfa.preloader')
    <div class="page-container">       
        @include('systems.cso.layout.includes.sidebar')
        <div class="main-content">           
            @include('systems.rfa.includes.topbar')
                @include('components.pmas_rfa.pmas_breadcrumbs')
                <div class="main-content-inner">
                    @yield('content')
            </div>
        </div>
    </div>     
@include('global_includes.js.global_js')
@include('systems.rfa.includes.js')
@include('systems.rfa.includes.custom_js.layout_js')
@yield('js')
@include('global_includes.js.custom_js.alert_loader')
</body>
</html>

