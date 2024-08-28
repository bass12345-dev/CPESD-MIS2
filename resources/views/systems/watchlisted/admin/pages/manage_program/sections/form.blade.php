<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Register Programs</h5>
    </div>
    <div class="card-body">
        <form id="add_form">
            <div class="form-row mb-2">
                <div class="form-group col-md-12 mb-3">
                    <label for="inputEmail4">Program Name</label>
                    <input type="hidden" name="id">
                    <input type="text" name="program" class="form-control">
                </div>
                <div class="form-group col-md-12 mb-3">
                    <label for="inputEmail4">Program Description</label>
                    <textarea name="program_description" class="form-control" style="height: 10rem;"></textarea>

                </div>

            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-danger cancel_update" hidden>Cancel Update</button>
        </form>
    </div>
</div>