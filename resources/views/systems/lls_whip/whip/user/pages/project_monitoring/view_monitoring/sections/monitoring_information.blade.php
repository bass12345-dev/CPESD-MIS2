<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="card flex-fill p-3">
        <div class="card-header">
            <h5 class="card-title mb-0">Project Monitoring Information</h5>
            <h5 class="card-title mb-0">Monitoring #{{$row->whip_code}}</h5>
            <button class="btn btn-primary edit-information" disabled>Edit Info</button>
            <button class="btn btn-danger cancel-edit hidden" >Cancel Edit</button>
            <button class="btn btn-success submit hidden" >Submit</button>
        </div>
        <input type="hidden" name="project_monitoring_id" value="{{$row->project_monitoring_id}}">
        <input type="hidden" name="project_id" value="{{$row->project_id}}">
        <table class="table table-hover table-striped table-information " id="table-information" style="width: 100%; ">
       
            <tr>
                <td>Project</td>
                <td class="text-start"><span class="title">{{$row->project_title}}</span></td>
            </tr>
            <tr>
                <td>Contractor</td>
                <td class="text-start"><span class="title">{{$row->contractor_name}}</span></td>
            </tr>

            <tr>
                <td>Address</td>
                <td class="text-start"><span class="title">{{$row->barangay.' '.$row->street}}</span>   <input class="hidden" name="project_address" value="{{$row->barangay}}"></td>
            </tr>
            <tr>
                <td>Project Started</td>
                <td class="text-start"><span class="title">{{date('M d Y', strtotime($row->date_started))}}</span></td>
            </tr>

            <tr>
                <td>Date Of monitoring</td>
                <td class="text-start"><span class="title1">{{date('M d Y', strtotime($row->date_of_monitoring))}}</span><input type="hidden" class="form-control date" name="date_of_monitoring" value="{{$row->date_of_monitoring}}"></td>
            </tr>

            <tr>
                <td>Specific Activity</td>
                <td class="text-start"><span class="title1">{{$row->specific_activity}}</span> <textarea class="form-control hidden" name="specific_activity">{{$row->specific_activity}}</textarea> </td>
            </tr>

            <tr>
                <td>Annotations</td>
                <td class="text-start"><span class="title1">{{$row->annotations}}</span>  <textarea class="form-control hidden" name="annotations">{{$row->annotations}}</textarea></td>
            </tr>
           
        </table>
    </div>
</div>
