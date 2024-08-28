<div class="modal fade" id="add_remarks_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Remarks</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="add_remarks_form">
            <div class="modal-body">
               <input type="hidden" class="form-control" id="transact_id" name="transact_id" placeholder="" required>
               <div class="form-group">
                  <label for="exampleInputPassword1">Remarks</label>
                  <div id="please_wait_remarks_alert"></div>
                  <textarea class="form-control" id="tiny"></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <button type="submit" class="btn  btn-add-remarks sub-button"  >Submit</button>
            </div>
         </form>
      </div>
   </div>
</div>