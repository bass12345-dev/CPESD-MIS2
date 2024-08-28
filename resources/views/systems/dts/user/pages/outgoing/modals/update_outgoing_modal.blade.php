<!-- Modal -->
<div class="modal fade" id="update_outgoing_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Update Outgoing Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="update_outgoing_form">
          <div class="form-row mb-2">
            <div class="form-group col-md-12 mb-3">
              <input type="hidden" name="outgoing_id">
              <label for="inputEmail4">Remarks</label>
              <textarea name="remarks" class="form-control"></textarea>
            </div>
          </div>
          <div class="form-group col-md-12 mb-2">

            <label for="inputEmail4">To : </label>
            <select class="form-control" name="office" required>
              <option value="">Select..</option>
              <?php foreach ($offices as $row) : ?>
                <?php $is_disabled = $row->office_id == 21 ? 'disabled' : ''   ?>
                <option value="{{$row->office_id}}" {{$is_disabled}}>{{$row->office}}</option>
              <?php endforeach; ?>

            </select>

          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>