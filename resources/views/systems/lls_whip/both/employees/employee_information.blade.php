<div class="card flex-fill p-3">
    <div class="card-header">
        <h5 class="card-title mb-0">Employee Information</h5>
        <button class="btn btn-primary edit-information" disabled>Edit Info</button>
        <button class="btn btn-danger cancel-edit hidden">Cancel Edit</button>
        <button class="btn btn-success submit hidden">Submit</button>
    </div>
    <table class="table table-hover table-striped table-information " id="table-information" style="width: 100%; ">
        <tr>
            <td>First Name</td>
            <td class="text-start">
                <span class="title1">{{$row->first_name}}</span>
                <input type="hidden" name="employee_id" value="{{$row->employee_id}}" hidden>
                <input type="hidden" class="form-control" name="first_name" value="{{$row->first_name}}">
            </td>
        </tr>
        <tr>
            <td>Middle Name</td>
            <td class="text-start">
                <span class="title1">{{$row->middle_name}}</span>
                <input type="hidden" class="form-control" name="middle_name" value="{{$row->middle_name}}">
            </td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td class="text-start">
                <span class="title1">{{$row->last_name}}</span>
                <input type="hidden" class="form-control" name="last_name" value="{{$row->last_name}}">
            </td>
        </tr>
        <tr>
            <td>Extension</td>
            <td class="text-start">
                <span class="title1">{{$row->extension}}</span>
                <input type="hidden" class="form-control" name="extension" value="{{$row->extension}}">
            </td>
        </tr>

        <tr>
            <td>Province</td>
            <td class="text-start">
                <input type="hidden" name="province_code" value="{{$row->province_code}}" hidden>
                <span class="title1">{{$row->province}}</span>
                <select class="form-control" name="province" id="province_select" hidden>
                </select>
            </td>
        </tr>

        <tr>
            <td>City</td>
            <td class="text-start">
            <input type="hidden" name="city_code" value="{{$row->city_code}}" hidden>
            <input type="hidden" name="city_name" value="{{$row->city}}" hidden>
                <span class="title1">{{$row->city}}</span>
                <select class="form-control" name="city" id="city_select" hidden disabled>
                </select>
            </td>
        </tr>
        <tr>
            <td>Barangay</td>
            <td class="text-start">
            <input type="hidden" name="barangay_code" value="{{$row->barangay_code}}" hidden>
            <input type="hidden" name="barangay_name" value="{{$row->barangay}}" hidden>
                <span class="title1">{{$row->barangay}}</span>
                <select class="form-control" name="barangay" id="barangay_select" hidden disabled>
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
            <td>Gender</td>
            <td class="text-start">
                <span class="title1">{{ ucfirst($row->gender)}}</span>
                <select class="form-control" name="gender" hidden>
                    <?php $is_selected = $row->gender == 'male' ? 'selected' : '';  $is_selected2 = $row->gender == 'female' ? 'selected' : ''; ?>
                    <option value="male" {{$is_selected}}>Male</option>
                    <option value="female" {{$is_selected2}}>Female</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>Birth Date</td>
            <td class="text-start">
                <span class="title1">{{$row->birthdate}}</span>
                <input type="hidden" class="form-control " name="birthdate" value="<?php echo date("Y-m-d", strtotime($row->birthdate)) ?>">
            </td>
        </tr>

        <tr>
            <td>Contact Number</td>
            <td class="text-start">
                <span class="title1">{{$row->contact_number}}</span>
                <input type="hidden" class="form-control" name="contact_number" value="{{$row->contact_number}}">
            </td>
        </tr>
        
       


    </table>
</div>