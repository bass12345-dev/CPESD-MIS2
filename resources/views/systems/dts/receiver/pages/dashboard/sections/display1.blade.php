<div class="row">
   <div class="col-xl-12 col-xxl-12 d-flex">
      <div class="w-100">
         <div class="row">
            <div class="col-sm-4">
               <div class="card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title text-black">All Documents</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="align-middle" data-feather="file"></i>
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
                           <h5 class="card-title text-black">Received</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="align-middle" data-feather="arrow-down"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3">{{$count['received']}}</h1>
                  </div>
               </div>
            </div>
            <div class="col-sm-4">
               <div class="card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col mt-0">
                           <h5 class="card-title text-black">Incoming</h5>
                        </div>
                        <div class="col-auto">
                           <div class="stat text-primary">
                              <i class="align-middle" data-feather="arrow-left"></i>
                           </div>
                        </div>
                     </div>
                     <h1 class="mt-1 mb-3">{{$count['incoming']}}</h1>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>