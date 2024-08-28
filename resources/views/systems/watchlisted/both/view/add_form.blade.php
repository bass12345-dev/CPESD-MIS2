<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"></h5>
    </div>
    <div class="card-body">
        <form id="add_form">
            <div class="form-row mb-2">


                <div class="form-group col-md-12 mb-3">
                    <input type="hidden" name="person_id" value="{{$person_data->person_id}}">
                    <input type="hidden" name="record_id">
                    <label for="inputEmail4">Add Record</label>
                    <textarea name="record_description" class="form-control" style="height: 10rem;"></textarea>
                </div>

            </div>
            <button type="submit" class="btn btn-primary submit">Submit</button>
            <button type="button" class="btn btn-danger cancel_update" hidden>Cancel Update</button>
        </form>
    </div>
</div>