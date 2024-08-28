<!-- Modal -->
<div class="modal fade" id="update_document" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Update Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form id="update_document_form">
               <div class="form-row mb-2">
                  <div class="form-group col-md-12 mb-3">
                     <label for="inputEmail4">Tracking Number</label>
                     <input type="text" class="form-control" name="t_number" value="" readonly="" >
                  </div>
                  
                   <div class="form-group col-md-12 mb-3">
                     <label for="inputEmail4">Document name</label>
                     <input type="text" name="document_name" class="form-control" required >
                  </div>

                  <div class="form-group col-md-12 mb-3">
                     <label for="inputEmail4">Origin</label>
                     <select class="form-control" name="origin" required>
                        <option value="">Select Office Origin</option>
                        <?php
                           foreach ($offices as $row) :
                          
                              echo "<option value='".$row->office_id."' >".$row->office."</option>";
                              # code...
                           endforeach;
                         ?>
                     </select>      
                  </div>

                  <div class="form-group col-md-12 mb-3">
                     <label for="inputEmail4">Document Type</label>
                     <select class="form-control" name="document_type" required>
                        <option value="">Select Document Type</option>
                        <?php
                           foreach ($document_types as $row) :

                              echo "<option value='".$row->type_id."'>".$row->type_name."</option>";
                              # code...
                           endforeach;
                         ?>
                     </select>      
                  </div>

                  <div class="form-group col-md-12 mb-3">
                     <label for="inputEmail4" >Description</label>
                     <textarea class="form-control" name="description" style="height: 10rem;" required></textarea>
                  </div>

                  <!-- <div class="form-group col-md-12 mb-3">
                     <label for="inputEmail4">Type</label>
                     <select class="form-control" name="type" >
                      <option value="complex">Complex</option>
                        <option value="simple">Simple</option>
                     </select>
                  </div>

                  <div class="form-group col-md-12 mb-3" id= "remarks" hidden>
                     <label for="inputEmail4" >Remarks</label>
                     <textarea class="form-control" name="remarks" style="height: 10rem;" ></textarea>
                  </div>
 -->
               </div>
               <button type="submit" class="btn btn-primary">Submit</button>
            </form>
         
      </div>
      
      
    </div>
  </div>
</div>