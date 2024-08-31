<!-- Data Table area Start-->
<div class="data-table-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="data-table-list">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="basic-tb-hd">
                                <h2>List of Employees</h2>
                                <button class="btn btn-primary add-employee" data-toggle="modal"
                                    data-target="#add_employee_modal">Add Employee</button>
                                <button class="btn btn-danger multi-delete" id="multi-delete">Delete</button>
                                <button class="btn btn-success reload-employee-table">Refresh</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ic-cmp-int pull-right" style="width: 400px;">
                                <div class="form-ic-cmp">
                                    <i class="notika-icon notika-calendar"></i>
                                </div>
                                <div class="nk-int-st">
                                    <input type="text" class="form-control" name="daterange_filter"
                                        placeholder="Establishment Name" required>
                                </div>
                                <div class="form-ic-cmp">
                                    <button id="submit-filter" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">

                        <table id="data-table-basic" class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Address</th>
                                    <th>Position</th>
                                    <th>Nature of Employment</th>
                                    <th>Status Of Employment</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Level Of Employment</th>
                                    <th>Action</th>
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