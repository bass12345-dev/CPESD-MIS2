<div class="col-lg-6 col-md-6">
    <div class="form-wizard">
        <form id="add_rfa_form">
            <input type="hidden" value="{{ $data != null ? $data->rfa_id : ''}}" name="update_rfa_id" >
            <fieldset class="wizard-fieldset show">
                <h5>Requet For Assistance Form</h5>
                <div class="form-group">
                    <label>Reference No.</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <input type="text" name="year" class="form-control" value="<?php echo date('Y', time()) ?>"
                                readonly>
                        </div>
                        <div class="input-group-prepend">
                            <input type="text" name="month" class="form-control" value="<?php echo date('m', time()) ?>"
                                readonly>
                        </div>
                        <input type="number" class="form-control  wizard-required input " name="reference_number"
                            readonly>
                    </div>
                    <div class="wizard-form-error"></div>
                </div>
                <div class="form-group clearfix">
                    <button type="button" class="form-wizard-next-btn float-right" id="first-next">Next</button>
                </div>
            </fieldset>


            <fieldset class="wizard-fieldset">
                <h5>Requet For Assistance Form</h5>
                <div class="form-group">

                    <div class="form-group">
                        <div class="col-12">Name Of Client</div>
                        <input type="text" class="form-control input" name="name_of_client" required
                            onkeydown="return false;" />
                        <input type="hidden" class="form-control input" name="client_id" />
                    </div>
                    <div class="wizard-form-error"></div>
                </div>

                <div class="form-group">

                    <div class="form-group">
                        <div class="col-12">Type of Request</div>
                        <select class="custom-select input responsibility wizard-required" name="type_of_request"
                            style="width: 100%;" required>
                            <option value="">Select Type of Request</option>

                            <?php foreach ($type_of_request as $row) { ?>
                            <option value="<?php    echo $row->type_of_request_id ?>">
                                <?php    echo $row->type_of_request_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="wizard-form-error"></div>
                </div>
                <div class="form-group">

                    <div class="form-group">
                        <div class="col-12">Type Of Transaction</div>
                        <select class="custom-select input" id="input_barangay" name="type_of_transaction" required>
                            <option value="">Select Type of Transaction</option>
                            <?php foreach ($type_of_transactions as $row) { ?>
                            <option value="<?php    echo $row ?>"><?php    echo $row ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="wizard-form-error"></div>
                </div>


                <div class="form-group" id="refer_to" hidden>

                    <select class="custom-select input responsibility wizard-required" id="refer_to_id"
                        name="refer_to_id" style="width: 100%;">
                        <option value="">Refer to</option>

                        <?php foreach ($refer_to as $row) { ?>
                        <option value="<?php    echo $row->user_id ?>">
                            <?php    echo $row->first_name . ' ' . $row->last_name; ?></option>
                        <?php } ?>
                    </select>


                </div>



                <div class="form-group clearfix">
                    <button type="submit" class="form-wizard-submit float-right btn-add-rfa"> Submit</button> <a
                        href="javascript:;" class="form-wizard-previous-btn float-left">Previous</a>
                </div>
            </fieldset>

        </form>
    </div>
</div>