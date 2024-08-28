<div class="card">
    
    <div class="card-body">
        <form id="add_document">
            <div class="form-row mb-2">

                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputEmail4">First Name<span class="text-danger">*</span></label>
                        <input type="text" name="firstName" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputEmail4">Last Name<span class="text-danger">*</span></label>
                        <input type="text" name="lastName" class="form-control" required>
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputEmail4">Middle Name</label>
                        <input type="text" name="middleName" class="form-control">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputEmail4">Extension</label>
                        <input type="text" name="extension" class="form-control">
                    </div>

                </div>
                <div class="form-group col-md-12 mb-3">
                    <label for="inputEmail4">Barangay<span class="text-danger">*</span></label>
                    <select class="form-control" name="address" required>
                        <option value="" selected>Select Barangay</option>
                        <?php foreach ($barangay as $row) : ?>
                            <option value="{{$row}}">{{$row}}</option>
                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="form-group col-md-12 mb-3">
                    <label for="inputEmail4">Phone Number</label>
                    <input type="number" name="phoneNumber" class="form-control">
                </div>
                <div class="form-group col-md-12 mb-3">
                    <label for="inputEmail4">Email Address</label>
                    <input type="email" name="emailAddress" class="form-control">
                </div>
                <div class="form-group col-md-12 mb-3">
                    <label for="inputEmail4">Age</label>
                    <input type="number" name="age" class="form-control">
                </div>

                <div class="form-group col-md-12 mb-3">
                    <label for="inputEmail4">Gender <span class="text-danger">*</span></label>
                    <select class="form-control" name="gender" required>
                        <option value="" selected>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>


            </div>
            <button type="submit" class="btn btn-primary" disabled>Submit</button>
        </form>
    </div>
</div>