<div class="row mt-2">
    <div class="col-lg-6 mt-sm-30 mt-xs-30">
        <div class="card">
            <div class="card-body">
                <div class="col-md-6 pull-left ">
                    <div class="loader-alert"></div>
                </div>
                <div class="col-md-6 pull-right ">
                    <select class="custom-select" id="admin_year" onchange="load_graph(this)">
                    @include('components.option')
                    </select>
                </div>
                <canvas id="admin-bar-chart" width="800" height="800"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mt-sm-30 mt-xs-30">
        <div class="card">
            <div class="card-body">
                <canvas id="admin-cso-chart" width="800" height="800"></canvas>
            </div>
        </div>
    </div>

</div>