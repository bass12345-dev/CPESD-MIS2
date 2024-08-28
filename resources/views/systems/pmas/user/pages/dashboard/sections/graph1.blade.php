<div class="row mt-2">
    <div class="col-lg-12 mt-sm-30 mt-xs-30">
        <div class="card">
            <div class="card-body">
                <div class="col-md-6 pull-left ">
                    <div class="loader-alert"></div>
                </div>
                <div class="col-md-6 pull-right ">
                    <select class="custom-select" id="user_year" onchange="load_user_graph(this)">
                        @include('components.option')
                    </select>
                </div>
                <canvas id="user-bar-chart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>