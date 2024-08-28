<div class="card flex-fill p-3">
    <div class="card-header">
        <h5 class="card-title mb-0">Contractor Information</h5>
        <button class="btn btn-primary edit-information" disabled>Edit Info</button>
        <button class="btn btn-danger cancel-edit hidden">Cancel Edit</button>
        <button class="btn btn-success submit hidden">Submit</button>
    </div>
    <input type="hidden" name="contractor_id" value="{{$row->contractor_id}}">
    <table class="table table-hover table-striped table-information " id="table-information" style="width: 100%; ">

        <tr>
            <td>Contractor Name</td>
            <td class="text-start">
                <span class="title1">{{$row->contractor_name}}</span>
                <input type="hidden" class="form-control" name="contractor_name" value="{{$row->contractor_name}}">
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
            <td>Phone Number</td>
            <td class="text-start">
                <span class="title1">{{$row->phone_number}}</span>
                <input type="hidden" class="form-control " name="phone_number" value="{{$row->phone_number}}">
            </td>
        </tr>

        <tr>
            <td>Phone Number Owner</td>
            <td class="text-start">
                <span class="title1">{{$row->phone_number_owner}}</span>
                <input type="hidden" class="form-control " name="phone_number_owner"
                    value="{{$row->phone_number_owner}}">
            </td>
        </tr>
        <tr>
            <td>Telephone Number</td>
            <td class="text-start">
                <span class="title1">{{$row->telephone_number}}</span>
                <input type="hidden" class="form-control " name="telephone_number" value="{{$row->telephone_number}}">
            </td>
        <tr>
            <td>Email Address</td>
            <td class="text-start">
                <span class="title1">{{$row->email_address}}</span>
                <input type="hidden" class="form-control " name="email_address" value="{{$row->email_address}}">
            </td>
        </tr>
        <tr>
            <td>Proprietor</td>
            <td class="text-start">
                <span class="title1">{{$row->proprietor}}</span>
                <input type="hidden" class="form-control " name="proprietor" value="{{$row->proprietor}}">
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td class="text-start">
                <span class="title1">{{ucfirst($row->status)}}</span>
                <select class="form-control" name="status" hidden>
                    <?php $is_selected = $row->status == 'active' ? 'selected' : '';  $is_selected2 = $row->status == 'inactive' ? 'selected' : ''; ?>
                    <option value="active" {{$is_selected}}>Active</option>
                    <option value="inactive" {{$is_selected2}}>InActive</option>
                </select>
        </tr>


    </table>
</div>