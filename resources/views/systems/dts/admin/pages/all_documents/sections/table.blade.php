<div class="card flex-fill ">
    @include('components.dts.filter_by_month')
   <div class="card-header">
     
      <button class="btn btn-danger" id="delete"> Delete</button>
      <a class="btn btn-warning" id="cancel_documents"> Cancel</a>
      <a class="btn btn-primary" id="print_slips"> Print Tracking Slip</a>
      <button class="btn btn-success " id="complete">Complete</button>
   </div>

   <table class="table table-hover table-striped m-2 " id="datatable_with_select" style="width: 100%; ">
      <thead>
         <tr>
            <th></th>
            <th>#</th>
            <th>Tracking Number</th>
            <th>Document Name</th>
            <th>Document Type</th>
            <th>Created</th>
            <th>Status</th>
            <th>Actions</th>
         </tr>
      </thead>
      <tfoot>
         <tr>
            <th></th>
            <th>#</th>
            <th>Tracking Number</th>
            <th>Document Name</th>
            <th>Document Type</th>
            <th>Created</th>
            <th>Status</th>
            <th>Actions</th>
         </tr>
      </tfoot>
   </table>
</div>

