<div class="row">
    <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <div class="card-actions float-end">
                    <div class="position-relative">
                        @include('components.dts.select_year')
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-6">
                <h5 class="card-title mb-0">Document Types</h5>
                    <div class="card-body d-flex w-100">
                        <div class="align-self-center chart chart-lg">
                            @include('components.submit_loader')
                            <canvas id="chartjs-dashboard-line" height="400"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                <h5 class="card-title mb-0">Documents Per Month</h5>
                    <div class="card-body d-flex w-100">
                        <div class="align-self-center chart chart-lg">
                            @include('components.submit_loader')
                            <canvas id="chartjs-dashboard-line1" height="400"></canvas>
                        </div>
                    </div>

                </div>
                
            </div>

        </div>
    </div>
</div>