<div class="offcanvas offcanvas-end" style="width: 50%" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h3 class="offcanvas-title"></h3>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form id="forward_form">
               <div class="form-row mb-2">
                
                   <input type="hidden" name="history_id">
                   <input type="hidden" name="tracking_number">
                   <div class="form-group col-md-12 mb-2">
                     <label for="inputEmail4">To : </label>
                     <select class="form-control" name="forward" required>
                       <option value="">Select..</option>
                       <option value="fr" class="bg-danger text-white">To Final Receiver</option>
                       <?php  foreach ($users as $row) : ?>
                        <?php $is_disabled = $row->user_id == session('user_id') ? 'disabled' : '';
                        ?>
                        <option value="{{$row->user_id}}" {{$is_disabled}} >{{$row->first_name}} {{$row->middle_name}} {{$row->last_name}} {{$row->extension}}  </option>
                       <?php endforeach; ?>

                       </select>
                     </select>
                  </div>
               </div>
               <button type="submit" class="btn btn-primary">Submit</button>
            </form>
    
  </div>
</div>