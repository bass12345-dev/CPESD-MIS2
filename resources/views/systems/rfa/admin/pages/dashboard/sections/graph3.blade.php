
<div class="row mt-2">
    <div class="col-lg-12 mt-sm-30 mt-xs-30">
        <div class="card">
            <div class="card-body">
            <div class="col-md-6 pull-right ">
                    <select class="custom-select" id="admin_year1" onchange="load_graph1(this)">
                        @include('components.option')
                    </select>
                </div>
                <canvas id="admin-bar-gender-by-month-chart" height="100">></canvas>
            </div>
        </div>
    </div>
</div>

