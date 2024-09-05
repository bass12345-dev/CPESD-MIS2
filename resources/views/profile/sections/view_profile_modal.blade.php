<!-- Modal -->
<div class="modal fade" id="view_profile_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">View Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="m-sm-3">
                            <form id="update_user_form">
                                <div class="row ">
                                    <div class="col-md-6 mb-3">
                                        <input type="hidden" value="{{$user_data->user_id}}" name="id">
                                        <label class="form-label">First Name<span class="text-danger">*</span></label>
                                        <input class="form-control form-control-lg" type="text" value="{{$user_data->first_name}}" name="first_name" required />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Middle Name</label>
                                        <input class="form-control form-control-lg" type="text" value="{{$user_data->middle_name}}" name="middle_name" />
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Last Name<span class="text-danger">*</span></label>
                                        <input class="form-control form-control-lg" type="text" value="{{$user_data->last_name}}" name="last_name" required />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Jr Sr ... Extension</label>
                                        <input class="form-control form-control-lg" type="text" value="{{$user_data->extension}}" name="extension" />
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Contact Number</label>
                                        <input class="form-control form-control-lg" type="number" value="{{$user_data->contact_number}}" name="contact_number" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Address </label>
                                        <input class="form-control form-control-lg" type="email" value="{{$user_data->email_address}}" name="email" />
                                    </div>
                                </div>


                                <div class="row ">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Barangay<span class="text-danger">*</span></label>
                                        <select class="form-control" name="address" required>
                                            <option value="">Select Barangay</option>
                                            <?php
                                            foreach ($barangay as $row):

                                                $selected = $row == $user_data->address ? "selected" : "";

                                            ?>
                                                <option value="{{$row}}" {{$selected}}>{{$row}}</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                </div>




                                <div class="d-grid gap-2 mt-3">
                                    <button type="submit" class="btn btn-lg btn-primary">Update</button>


                                </div>

                            
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>