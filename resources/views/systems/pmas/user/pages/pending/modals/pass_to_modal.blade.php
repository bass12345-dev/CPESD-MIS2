<div class="modal fade" id="pass_to_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pass-to-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="pass_to_form">
                    <input type="hidden" name="pmas_id">
                    <div class="form-group">
                        <select class="custom-select input responsibility wizard-required" id="pass_to_id"
                            name="pass_to_id" style="width: 100%;" required>
                            <option value="">Pass to</option>

                            <?php foreach ($pass_to as $row) { ?>
                            <option value="<?php    echo $row->user_id ?>">
                                <?php    echo $row->first_name . ' ' . $row->last_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn sub-button mt-1 pr-4 pl-4 btn-refer pull-right pass-button">
                        Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>