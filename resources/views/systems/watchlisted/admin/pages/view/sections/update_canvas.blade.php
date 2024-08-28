<div class="offcanvas offcanvas-start" style="width: 50%" tabindex="-1" id="update_canvas"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h3 class="offcanvas-title update-information"></h3>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="update_information">
            <div class="form-row mb-2">

                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <input type="hidden" name="person_id" value="{{$person_data->person_id}}">
                        <label for="inputEmail4">First Name<span class="text-danger">*</span></label>
                        <input type="text" name="firstName" value="{{$person_data->first_name}}" class="form-control"
                            required>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputEmail4">Last Name<span class="text-danger">*</span></label>
                        <input type="text" name="lastName" value="{{$person_data->last_name}}" class="form-control"
                            required>
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputEmail4">Middle Name<span class="text-danger">*</span></label>
                        <input type="text" name="middleName" value="{{$person_data->middle_name}}" class="form-control">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputEmail4">Extension</label>
                        <input type="text" name="extension" value="{{$person_data->extension}}" class="form-control">
                    </div>

                </div>
                <div class="form-group col-md-12 mb-3">
                    <label for="inputEmail4">Barangay</label>
                    <select class="form-control" name="address" required>
                        <option value="" selected>Select Barangay</option>
                        <?php foreach ($barangay as $row):
    $selected = $person_data->address == $row ? 'selected' : '';
                    ?>
                        <option value="{{$row}}" {{$selected}}>{{$row}}</option>
                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="form-group col-md-12 mb-3">
                    <label for="inputEmail4">Phone Number</label>
                    <input type="number" name="phoneNumber" value="{{$person_data->phone_number}}" class="form-control">
                </div>
                <div class="form-group col-md-12 mb-3">
                    <label for="inputEmail4">Email Address</label>
                    <input type="email" name="emailAddress" value="{{$person_data->email_address}}"
                        class="form-control">
                </div>
                <div class="form-group col-md-12 mb-3">
                    <label for="inputEmail4">Age</label>
                    <input type="number" name="age" value="{{$person_data->age}}" class="form-control">
                </div>


                <div class="form-group col-md-12 mb-3">
                    <label for="inputEmail4">Gender</label>
                    <select class="form-control" name="gender">
                        <?php
$selected_male = $person_data->gender == 'male' ? 'selected' : '';
$selected_female = $person_data->gender == 'female' ? 'selected' : '';
                  ?>
                        <option value="">Select Gender</option>
                        <option value="male" {{$selected_male}}>Male</option>
                        <option value="female" {{$selected_female}}>Female</option>
                    </select>

                </div>


            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</div>