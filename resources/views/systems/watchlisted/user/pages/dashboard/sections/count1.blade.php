<div class="row">
   <div class="col-xl-12 col-xxl-12 d-flex">
      <div class="w-100">
         <div class="row">
            <div class="col-sm-4">
               <div class="card bg-danger">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title text-white">Approve</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="align-middle" data-feather="alert-circle"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3 text-white">{{$count_approved}}</h1>
                  </div>
               </div>
            </div>
            <div class="col-sm-4">
               <div class="card bg-warning">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title text-white">To Approve</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="align-middle" data-feather="alert-circle"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3 text-white">{{$count_pending}}</h1>
                  </div>
               </div>
            </div>
            <div class="col-sm-4">
               <div class="card bg-success">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title text-white">Removed</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="align-middle" data-feather="alert-circle"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3 text-white">{{$removed}}</h1>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-xl-12 col-xxl-12 d-flex">
      <div class="w-100">
         <div class="row">
            <div class="col-sm-6">
               <div>
                  <div class="card" >
                     <div class="card-header bg-primary text-white">
                        Per Barangay Approved
                     </div>
                     <ul class="list-group list-group-flush">
                        <?php foreach ($barangay as $row) :?>
                        <li class="list-group-item"><?php echo $row; ?></li>
                        <?php endforeach; ?>
                     </ul>
                  </div>
               </div>

            </div>

         </div>
      </div>
   </div>
</div>