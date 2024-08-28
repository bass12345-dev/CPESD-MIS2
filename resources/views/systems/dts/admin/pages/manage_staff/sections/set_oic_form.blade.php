<div class="row">
    <div class="col-md-6">

        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Current OIC</h5>
            </div>
            <div class="card-body text-center">
                <br>
                <h2 class="card-title oic_name" style="color:#000;"></h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body ">

                <form id="update_oic_form">
                    <div class="form-group col-md-12 mb-3">
                        <label class="mb-2">Update Office In Charge</label>
                        <div class="mb-2">
                            <input type="hidden" value="" name="oic_id">
                            <select class="form-control" name="user_id" required>
                                <option value="">Select OIC</option>
                                <?php foreach ($users as $row) {
                                ?>
                                    <option value="{{$row->user_id}}">{{$row->first_name}} {{$row->middle_name}}
                                        {{$row->last_name}} {{$row->extension}}
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>