<div class="modal fade" id="refer_to_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog modal-dialog-centered "  role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Refer to</h5>
            &nbsp;
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               
               <div class="col-md-12">
                  <div class="card">
                     
                     <form id="update_refer_form">
                        <input  type="hidden" class="form-control"  name="rfa_id"  placeholder="" required>
                        <div class="form-group">
                          
                          <select class="custom-select input responsibility wizard-required" id="refer_to_id" name="refer_to_id" style="width: 100%;" required>
                              <option value="">Refer to</option> 
               
                             <?php foreach ($refer_to as $row) { ?>
                              <option  value="<?php echo $row->user_id ?>"><?php echo $row->first_name.' '.$row->last_name; ?></option>
                              <?php } ?>
                        </select>
                          
                                
                        </div>

                        <div class="form-group">
                           <div class="col-12">Action Taken</div>
                              <textarea class="form-control" id="action_to_be_taken" name="action_taken"></textarea>
                          
                                
                        </div>
                        <button  type="submit" class="btn sub-button mt-1 pr-4 pl-4 btn-refer pull-right"> Submit</button>
                        <div class="alert-add-under-activity"></div>
                        <!--  -->
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>