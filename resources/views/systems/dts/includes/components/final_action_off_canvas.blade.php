<div class="offcanvas offcanvas-end" style="width: 50%" tabindex="-1" id="offcanvasExample1" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h3 class="offcanvas-title"></h3>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="complete_form">
            <div class="row">
                <div class="col-md-4">
                    <div class="card p-3 border">

                        <h1>Tracking Number</h1>
                        <hr>
                        <ul class="display_tracking_number2 ms-4">
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-row mb-2">
                        <input type="hidden" name="c_t_number">
                        <input type="hidden" name="user_type">
                        <div class="form-group col-md-12 mb-2">
                            <label for="inputEmail4">Final Action </label>
                            <select class="form-control" name="final_action_taken" required>
                                <option value="">Select..</option>
                                <?php foreach ($final_actions as $row) : ?>
                                    <option value="{{$row->action_id}}">{{$row->action_name}} </option>
                                    <?php endforeach; ?>`
                            </select>
                        </div>
                        <div class="form-group col-md-12 mb-2">
                            <label for="inputEmail4">Remarks</label>
                            <textarea class="form-control" name="remarks2"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>