<div class="modal fade" id="update_refer_to_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title h5">Update Referral</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update_refer_to_form" class="p-2">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="rfa_id">
                        <label>To : </label>
                        <select class="custom-select input responsibility wizard-required" id="refer_to_id"
                            name="refer_to_id" style="width: 100%;">
                            <option value="">Refer to</option>

                            <?php foreach ($refer_to as $row) { ?>
                            <option value="<?php    echo $row->user_id ?>">
                                <?php    echo $row->first_name . ' ' . $row->last_name; ?></option>
                            <?php } ?>
                        </select>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn   sub-button btn-update-cso-status">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>