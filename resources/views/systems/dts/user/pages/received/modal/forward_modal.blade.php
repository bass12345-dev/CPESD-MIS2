<!-- Modal -->
<div class="modal fade" id="forward_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="staticBackdropLabel">Forward Document/s</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <h1>Tracking Number</h1>
            <ul class="display_tracking_number ms-4">
            </ul>
          </div>
          <div class="col-md-8">
            <form id="forward_form2">
              <div class="form-row mb-2">
                <input type="hidden" name="history_track1">
                <div class="form-group col-md-12 mb-2">
                  <label for="inputEmail4">To : </label>
                  <select class="form-control" name="forward1" required>
                    <option value="">Select..</option>
                    <option value="fr" class="bg-danger text-white">To Final Receiver</option>
                    <?php foreach ($users as $row) : ?>
                      <?php $is_disabled = $row->user_id == session('user_id') ? 'disabled' : ''   ?>
                      <option value="{{$row->user_id}}" {{$is_disabled}}>{{$row->first_name}} {{$row->middle_name}} {{$row->last_name}} {{$row->extension}} </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-md-12 mb-2">
                  <label for="inputEmail4">Remarks</label>
                  <textarea class="form-control" style="height: 150px;" name="remarks1"></textarea>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>