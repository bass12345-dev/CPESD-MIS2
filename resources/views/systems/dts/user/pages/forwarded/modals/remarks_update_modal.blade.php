<!-- Modal -->
<div class="modal fade" id="update_remarks_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Update Remarks</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form id="update_remarks_form">
               <div class="form-row mb-2">
                  <input type="hidden" value="{{session('user_id')}}" name="id">
                   <input type="hidden" name="history_id">
                   <input type="hidden" name="remarks_document_id">
                   <div class="form-group col-md-12 mb-2">
                     <label for="inputEmail4">Remarks</label>
                     <textarea class="form-control" name="remarks_update" style="height: 150px;" ></textarea>
                  </div>
               </div>
               <button type="submit" class="btn btn-primary">Submit</button>
            </form>

      </div>
      
    </div>
  </div>
</div>