<div class="card">
   <div class="card-header">
      <h5 class="card-title mb-0">Add Office</h5>
   </div>
   <div class="card-body">
      <form id="add_office">
         <div class="form-row mb-2">
            <div class="form-group col-md-12 mb-3">
               <label for="inputEmail4">Office Name</label>
               <input type="hidden" name="office_id">
               <input type="text" name="office" class="form-control" required>
            </div>
         </div>
         <button type="submit" class="btn btn-primary submit">Submit</button>
         <button type="button" class="btn btn-danger cancel_update" hidden>Cancel update</button>
      </form>
   </div>
</div>