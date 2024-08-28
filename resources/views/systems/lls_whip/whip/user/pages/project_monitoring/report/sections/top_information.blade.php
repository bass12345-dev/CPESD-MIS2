<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card flex-fill" style="padding-left: 50px;">
        <div class="logo-area " style="margin-bottom: 20px;">
            <h4 class="text-center">WORKERS HIRED IN INFRASTRACTURE PROJECTS (WHIP) MONITORING
            </h4>
            <h5 class="text-center">City Ordinance No. 868-2020 and Republic Act No. 6685</h5>
        </div>
        <input type="hidden" name="project_monitoring_id" value="{{$row->project_monitoring_id}}">
        <table class="table table-hover table-striped table-information " id="report-information"
            style="width: 100%;  ">
            <tr>
                <td style="width: 15%;">Project Title</td>
                <td class="text-start">
                    <h4 class="title">{{ strtoupper($row->project_title) }}</h4>
                </td>
            </tr>
            <tr>
                <td>Contractor</td>
                <td class="text-start">
                    <h4 class="title">{{ strtoupper($row->contractor_name)}}</h4>
                </td>
            </tr>
            <tr>
                <td>Project Location</td>
                <td class="text-start"><span class="title">{{$row->barangay . ' ' . $row->street}}</span></td>
            </tr>
            <tr>
                <td>Project Nature</td>
                <td class="text-start"><span class="title">{{$row->barangay . ' ' . $row->street}}</span></td>
            </tr>
            <tr>
                <td>Project Cost</td>
                <td class="text-start"><span class="title">{{$row->barangay . ' ' . $row->street}}</span></td>
            </tr>
            <tr>
                <td>Date Started</td>
                <td class="text-start"><span class="title">{{date('M d Y', strtotime($row->date_started))}}</span></td>
            </tr>

            <tr>
                <td>Date of monitoring</td>
                <td class="text-start"><span
                        class="title1">{{date('M d Y', strtotime($row->date_of_monitoring))}}</span><input type="hidden"
                        class="form-control date" name="date_of_monitoring" value="{{$row->date_of_monitoring}}"></td>
            </tr>

            <tr>
                <td>Specific Activity</td>
                <td class="text-start"><span class="title1">{{$row->specific_activity}}</span> <textarea
                        class="form-control hidden" name="specific_activity">{{$row->specific_activity}}</textarea>
                </td>
            </tr>


        </table>
        <h4 class="text-center">RESULT / FINDINGS FROM THE MONITORING</h4>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card flex-fill p-3">
                <!-- Data Table area Start-->
                <div class="data-table-list">

                    <div class="table-responsive">
                        <table id="nature_table" class="table table-striped">
                            <thead>
                                <tr>

                                    <th>Description</th>
                                    <th>skilled</th>
                                    <th>Percentage</th>
                                    <th>Impression</th>
                                </tr>
                                <tr>
                                    <td>Actual No. of Hired Worker</td>
                                    <td>7</td>
                                    <td>100%</td>
                                    <td rowspan="4"  style="display:flex; justify-content: center;align-items: center;"><h1>Compliant</h1></td>
                                </tr>
                                <tr>
                                    <td>No. of Workers Hired Outside Oroquieta</td>
                                    <td>7</td>
                                    <td>100%</td>
                                    
                                </tr>
                                <tr>
                                <td>No. of Workers Hired Within Oroquieta</td>
                                    <td>7</td>
                                    <td>100%</td>
                                    
                                </tr>
                                <tr>
                                <td>No. of Workers Hired Within the Oroquieta</td>
                                    <td>7</td>
                                    <td>100%</td>
                                    
                                </tr>
                                
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>