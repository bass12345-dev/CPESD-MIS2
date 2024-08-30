    <!-- Data Table area Start-->

    <div class="data-table-list">
        <div class="basic-tb-hd">
            <h2>{{$title}}</h2>
            <div class="row">
                <div class="col-md-8" style="display:flex;">
                    <!-- <input id='calendar' class="form-control yearpicker" /> -->
                     <div class="nk-int-st"  style="margin-left:5px;">
                        <label>Select Month and Year</label>
                     <input type="month" name="select_month" class="form-control">
                     </div>
                     <div class="nk-int-st">
                        <button class="btn btn-success" id="by-year"  style="margin-left:5px; margin-top:23px;">Generate Report</but>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped" >
                <thead>
                    <tr>
                        <th>Establishment</th>
                        <th>Compliance Percentage</th>
                        <th>Compliance Status</th>
                        <th>Total Rank and File Inside</th>
                        <th>Total Rank and File Employee</th>
                        <th>Survey</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>