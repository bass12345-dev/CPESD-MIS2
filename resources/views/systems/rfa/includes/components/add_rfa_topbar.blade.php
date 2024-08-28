<div class="header-area">
    <div class="row align-items-center">
        <!-- nav and search button -->
        <div class="col-md-6 col-sm-8 clearfix">
            <span style="font-size:23px;">
                <a href="{{ url()->previous() }}" class="back-button" style="color: #000;">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </span>
        </div>
        <!-- profile info & task notification -->
        @include('systems.rfa.includes.components.logout')
    </div>
</div>