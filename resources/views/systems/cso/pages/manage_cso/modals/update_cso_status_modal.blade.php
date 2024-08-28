<div class="modal fade" id="update_cso_status_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Update CSO Status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form id="update_cso_status_form" class="p-2">
            <div class="modal-body">
              <input type="hidden" name="cso_id">
               <div class="form-group ">
                  <label for="input_barangay">Status<span class="text-danger">*</span></label>
                  <select  class=" custom-select" id="cso_status_update" name="cso_status_update"   style="border: 1px solid;" required>
                     <option  value="active" >Active</option>
                     <option  value="inactive" >InActive</option>
                  </select>
               </div>
              
            </div>
            <div class="modal-footer" id="update_cso_footer">
               <button type="button" class="btn btn-danger update-cso-close" data-dismiss="modal">Close</button>
               <button type="submit" class="btn  btn-update-center sub-button btn-update-cso-status" name="btn-update-center " >Save changes</button>
            </div>
         </form>
      </div>
   </div>
</div>