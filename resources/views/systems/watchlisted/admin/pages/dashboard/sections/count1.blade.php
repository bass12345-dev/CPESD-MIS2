
<div class="row">
   <div class="col-xl-12 col-xxl-12 d-flex">
      <div class="w-100">
         <div class="row">
            <div class="col-sm-3">
               <div class="card bg-danger">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title text-white">Approved</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="align-middle" data-feather="alert-circle"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3 text-white">{{$watchlisted[0]->approved}}</h1>
                  </div>
               </div>
            </div>
            <div class="col-sm-3">
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
                     <h1 class="mt-1 mb-3 text-white">{{$watchlisted[0]->pending}}</h1>
                  </div>
               </div>
            </div>

            <div class="col-sm-3">
               <div class="card bg-success">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title text-white">Removed</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="align-middle" data-feather="check"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3 text-white">{{$watchlisted[0]->removed}}</h1>
                  </div>
               </div>
            </div>
            <div class="col-sm-3">
               <div class="card bg-primary">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title text-white">Programs</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="align-middle" data-feather="edit"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3 text-white">{{$programs}}</h1>
                  </div>
               </div>
            </div>


         </div>
      </div>
   </div>
</div>