<div class="row">
   <div class="col-sm-3">
      <div class="card">
         <div class="card-body l-bg-cherry ">
            <div class="row">
               <div class="col mt-0">
                  <h5 class="card-title text-white">Total Pending Documents</h5>
               </div>
               <div class="col-auto">
                  <div class="stat text-primary">
                     <i class="fas fa-file align-middle"></i>
                  </div>
               </div>
            </div>
            <h1 class="mt-1 mb-3 text-white">{{$count['pending']}}</h1>
         </div>
      </div>
   </div>

   <div class="col-sm-3">
      <div class="card">
         <div class="card-body bg-success ">
            <div class="row">
               <div class="col mt-0">
                  <h5 class="card-title text-white">Total Completed Documents</h5>
               </div>
               <div class="col-auto">
                  <div class="stat text-primary">
                     <i class="fas fa-file align-middle"></i>
                  </div>
               </div>
            </div>
            <h1 class="mt-1 mb-3 text-white">{{$count['completed']}}</h1>
         </div>
      </div>
   </div>

   <div class="col-sm-3">
      <div class="card">
         <div class="card-body bg-warning ">
            <div class="row">
               <div class="col mt-0">
                  <h5 class="card-title text-white">Total Cancelled Documents</h5>
               </div>
               <div class="col-auto">
                  <div class="stat text-primary">
                     <i class="fas fa-file align-middle"></i>
                  </div>
               </div>
            </div>
            <h1 class="mt-1 mb-3 text-white">{{$count['cancelled']}}</h1>
         </div>
      </div>
   </div>

   <div class="col-sm-3">
      <div class="card">
         <div class="card-body bg-secondary">
            <div class="row">
               <div class="col mt-0">
                  <h5 class="card-title text-white">Total Outgoing Documents</h5>
               </div>
               <div class="col-auto">
                  <div class="stat text-primary">
                     <i class="fas fa-file align-middle"></i>
                  </div>
               </div>
            </div>
            <h1 class="mt-1 mb-3 text-white">{{$count['outgoing']}}</h1>
         </div>
      </div>
   </div>
   

</div>
<div class="row">
   <div class="col-xl-12 col-xxl-12 d-flex">
      <div class="w-100">
         <div class="row">
            <div class="col-sm-4">
               <div class="card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title">All Documents</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="fas fa-file align-middle"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3">{{$count['count_documents']}}</h1>
                  </div>
               </div>
            </div>
            <div class="col-sm-4">
               <div class="card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title">Offices</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="fas fa-building align-middle"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3">{{$count['count_document_types']}}</h1>
                  </div>
               </div>
            </div>

            <div class="col-sm-4">
               <div class="card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title">Users</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="align-middle" data-feather="users"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3">{{$count['count_users']}}</h1>
                  </div>
               </div>
            </div>


         </div>

         <div class="row">
            <div class="col-sm-4">
               <div class="card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title">Document Types</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="fas fa-file-text align-middle"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3">{{$count['count_offices']}}</h1>
                  </div>
               </div>
            </div>

            <div class="col-sm-3">
               <div class="card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title">Final Actions</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="fas fa-check align-middle"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3">{{$count['final_actions']}}</h1>
                  </div>
               </div>
            </div>

            <div class="col-sm-5">
               <div class="card bg-danger count-total-final">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title text-white">Total Final Receiver's Pending</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="fas fa-check align-middle"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3 text-white">{{$count['final_receiver']}}</h1>
                  </div>
               </div>
            </div>


         </div>
      </div>
   </div>
</div>

