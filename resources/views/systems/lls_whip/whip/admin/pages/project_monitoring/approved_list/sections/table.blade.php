    <!-- Data Table area Start-->
    <div class="data-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table-list">
                        <div class="basic-tb-hd">
                            <h2>{{$title}}</h2>
                            @include('components.dts.filter_by_month')
                        </div>
                        <div class="table-responsive">
                            <table id="data-table-basic" class="table table-striped">
                            <thead>
                                    <tr>
                                        
                                        <th>#</th>
                                        <th>Project</th>
                                        <th>Contractor</th>
                                        <th>Address</th>
                                        <th>Date Of Monitoring</th>
                                        <th>Specific Activity</th>
                                        <th>Person Responsible</th>
                                      
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Data Table area End-->