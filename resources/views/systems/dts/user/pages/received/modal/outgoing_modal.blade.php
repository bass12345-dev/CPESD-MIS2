<!-- Modal -->
<div class="modal fade" id="outgoing_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="staticBackdropLabel">Outgoing Document/s</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <h1>Tracking Number</h1>
            <ul class="display_tracking_number1 ms-4">
            </ul>
          </div>
          <div class="col-md-8">

            <form id="outgoing_form">
              <div class="form-row mb-2">
                <input type="hidden" name="history_track2">

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

                <div class="form-group col-md-12 mb-2">
                  <label for="inputEmail4">Note</label>
                  <textarea class="form-control" style="height: 150px;" name="note"></textarea>
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