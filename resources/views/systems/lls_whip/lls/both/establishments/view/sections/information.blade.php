<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="card flex-fill p-3">
        <div class="card-header">
            <h5 class="card-title mb-0">Establishment Information</h5>
            <button class="btn btn-primary edit-information" disabled>Edit Info</button>
            <button class="btn btn-danger cancel-edit hidden" >Cancel Edit</button>
            <button class="btn btn-success submit hidden" >Submit</button>
        </div>
        <input type="hidden" name="establishment_id" value="{{$row->establishment_id}}">
        <table class="table table-hover table-striped table-information " id="table-information" style="width: 100%; ">
       
            <tr>
                <td>Establishment Code</td>
                <td class="text-start"><span >{{$row->establishment_code}}</span></td>
            </tr>
            <tr>
                <td>Establishment Name</td>
                <td class="text-start"><span class="title">{{$row->establishment_name}}</span><input type="hidden" class="form-control" name="establishment_name" value="{{$row->establishment_name}}"></td>
            </tr>

            <tr>
                <td>Street</td>
                <td class="text-start"><span class="title">{{$row->street}} </span><input type="hidden" class="form-control" name="street" value="{{$row->street}}"></td>
            </tr>

            <tr>
                <td>Barangay</td>
                <td class="text-start"><span class="title">{{$row->barangay}}</span>
                    <select class="form-control" name="barangay" hidden required>
                        <option value="">Select Barangay</option>
                             <?php foreach ($barangay as $row1) :
                                $selected = $row->barangay == $row1 ? 'selected' : '';
                            ?>
                        <option value="{{$row1}}" {{$selected}}>{{$row1}}</option>
                            <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Phone Number</td>
                <td class="text-start"><span class="title">{{$row->contact_number}}</span><input type="hidden" class="form-control" name="phone_number" value="{{$row->contact_number}}"></td>
            </tr>

            <tr>
                <td>Email</td>
                <td class="text-start"><span class="title">{{$row->email_address}}</span><input type="hidden" class="form-control" name="email_address" value="{{$row->email_address}}"></td>
            </tr>
            <tr>
                <td>Authorized Personnel</td>
                <td class="text-start"><span class="title">{{$row->authorized_personnel}}</span><input type="hidden" class="form-control" name="authorized_personnel" value="{{$row->authorized_personnel}}"></td>
            </tr>
            <tr>
                <td>Position</td>
                <td class="text-start"><span class="title">{{$row->position}}</span><input type="hidden" class="form-control" name="position" value="{{$row->position}}"></td>
            </tr>
           
            <tr>
                <td>Status</td>
                <td><?php echo $row->status == 'active' ? '<span class="badge notika-bg-success title">Active</span>' : '<span class="badge notika-bg-danger title">Inactive</span>' ?>
                    <select class="form-control"id="select_status" required hidden>
                        <option value="active" {{$row->status == 'active' ? 'selected' : ''}}>Active</option>
                        <option value="inactive" {{$row->status == 'inactive' ? 'selected' : ''}}>InActive</option>
                    </select>
                </td>
            </tr>
        </table>
    </div>
</div>
