<div class="modal fade" id="update_cso_information_modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update CSO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="update_cso_information_form" class="p-2">
                <div class="modal-body">

                    <div class="form-group">
                        <input type="hidden" name="cso_idd">
                        <div class="col-12">CSO Name<span class="text-danger">*</span></div>
                        <input type="text" class="form-control input" name="cso_name" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <div class="col-12">CSO Code<span class="text-danger">*</span></div>
                        <input type="text" class="form-control input" name="cso_code" placeholder="" required>
                    </div>
                    <div class="form-group ">
                        <label for="input_barangay">CSO Type<span class="text-danger">*</span></label>
                        <select class=" custom-select" id="cso_type" name="cso_type" style="border: 1px solid;"
                            required>
                            <option value="" selected>Select type</option>
                            <?php foreach ($type_of_cso as $row) { ?>
                            <option value="<?php    echo strtoupper($row); ?>"><?php    echo $row; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="col-12 ml-3">Address<span class="text-danger">*</span></div>
                        <div class="form-group col-md-3">
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Purok</span>
                                </div>
                                <input type="number" class="form-control input" name="purok" aria-label="Username"
                                    aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-group col-md-9">
                            <div class="input-group " style="height: 45px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" for="input_barangay">Barangay</span>
                                </div>
                                <select class="custom-select" id="barangay" name="barangay"
                                    style="border: 1px solid;height: 45px;">
                                    <option value="" selected>Select Barangay</option>
                                    <?php foreach ($barangay as $row) { ?>
                                    <option value="<?php    echo $row; ?>"><?php    echo $row; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Contact Person</label><span class="text-danger">*</span>
                        <input type="text" class="form-control input" name="contact_person" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Contact Number</label><span class="text-danger">*</span>
                        <input type="text" value="09" class="form-control input" name="contact_number" placeholder=""
                            data-mask="09000000000">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Telephone Number</label><span class="text-danger">*</span>
                        <input type="text" class="form-control input" name="telephone_number" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label><span class="text-danger">*</span>
                        <input type="text" class="form-control input" name="email_address" placeholder="">
                    </div>

                </div>
                <div class="modal-footer" id="update_cso_footer">
                    <button type="button" class="btn btn-danger update-cso-close" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn  btn-update-cso sub-button " name="btn-update-cso ">Save
                        changes</button>
                </div>
            </form>
        </div>
    </div>
</div>