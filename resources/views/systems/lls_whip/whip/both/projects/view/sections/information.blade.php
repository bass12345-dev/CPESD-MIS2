<div class="card flex-fill p-3">
    <div class="card-header">
        <h5 class="card-title mb-0">Project Information</h5>
        <button class="btn btn-primary edit-information" disabled>Edit Info</button>
        <button class="btn btn-danger cancel-edit hidden">Cancel Edit</button>
        <button class="btn btn-success submit hidden">Submit</button>
    </div>
    <input type="hidden" name="project_id" value="{{$row->project_id}}">
    <table class="table table-hover table-striped table-information " id="table-information" style="width: 100%; ">
        <tr>
            <td>Contractor Name</td>
            <td class="text-start">
                <span class="title1">{{$row->contractor_name}}</span>
                <input type="hidden" name="contractor_id" value="{{$row->contractor_id}}" hidden>
                <input type="hidden" class="form-control" name="contractor" value="{{$row->contractor_name}}">
            </td>
        </tr>
        <tr>
            <td>Project Title</td>
            <td class="text-start">
                <span class="title1">{{$row->project_title}}</span>
                <input type="hidden" class="form-control" name="project_title" value="{{$row->project_title}}">
            </td>
        </tr>
        <tr>
            <td>Project Nature</td>
            <td class="text-start">
                <span class="title1">{{$row->project_nature}}</span>
                <select name="project_nature" class="form-control" hidden>
                    <option value="">Select Project Nature</option>
                    <?php
                        foreach ($project_nature as $key) :
                        
                        $is_selected = $key->project_nature_id == $row->project_nature_id ? 'selected' : '';
                    ?>
                    <option value="{{$key->project_nature_id}}" {{$is_selected}}>{{$key->project_nature}}</option>

                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Project Cost</td>
            <td class="text-start">
                <span class="title1"> &#8369 <?php echo  number_format($row->project_cost, 2, '.', '') ?></span>
                <input type="hidden" class="form-control" name="project_cost" value="{{$row->project_cost}}">
            </td>
        </tr>
        <tr>
            <td>Barangay</td>
            <td class="text-start">
                <span class="title1">{{$row->barangay}}</span>
                <select name="barangay" class="form-control" hidden>
                <option value="">Select Project Nature</option>
                    <?php
                        foreach (config('custom_config.barangay') as $key) :
                        
                        $is_selected = $key == $row->barangay ? 'selected' : '';
                    ?>
                    <option value="{{$key}}" {{$is_selected}}>{{$key}}</option>

                    <?php endforeach; ?>
                    </select>
            </td>
        </tr>
        <tr>
            <td>Street</td>
            <td class="text-start">
                <span class="title1">{{$row->street}}</span>
                <input type="hidden" class="form-control" name="street" value="{{$row->street}}">
            </td>
        </tr>
        <tr>
            <td>Date Started</td>
            <td class="text-start">
                <span class="title1">{{$row->date_started}}</span>
                <input type="hidden" class="form-control" name="project_date_started" value="{{$row->date_started}}" >
            </td>
        </tr>
        <tr>
            <td>Project Status</td>
            <td class="text-start">
                <span class="title1"> <?php echo $row->project_status == 'ongoing' ? '<span class="badge notika-bg-danger">'.ucfirst($row->project_status).'</span>':  '<span class="badge notika-bg-success">'.ucfirst($row->project_status).'</span>' ?></span>
                <select class="form-control" name="status" hidden>
                    <?php $is_selected = $row->project_status == 'ongoing' ? 'selected' : ''; $is_selected2 = $row->project_status == 'completed' ? 'selected' : ''; ?>
                    <option value="ongoing" {{$is_selected}}>Ongoing</option>
                    <option value="completed" {{$is_selected2}}>Completed</option>
                </select>
        </tr>


            <tr>
                <td>Date Completed</td>
                <td class="text-start">
                    <span class="title1">{{$row->date_completed}}</span>
                    <input type="hidden" class="form-control" name="project_date_completed" value="{{$row->date_completed}}" >
                </td>
            </tr>
   
        

    </table>
</div>