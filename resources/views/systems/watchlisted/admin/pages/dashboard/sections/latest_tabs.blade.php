<div class="row">
   <div class="col-xl-12 col-xxl-12 d-flex">
      <div class="w-100">
         <div class="row">
            <div class="col-sm-7">
               <div>
               <ul class="nav nav-tabs" role="tablist">
                     <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="simple-tab-0" data-bs-toggle="tab" href="#simple-tabpanel-0" role="tab" aria-controls="simple-tabpanel-0" aria-selected="true"> Added Today</a>
                     </li>
                     <li class="nav-item" role="presentation">
                        <a class="nav-link" id="simple-tab-1" data-bs-toggle="tab" href="#simple-tabpanel-1" role="tab" aria-controls="simple-tabpanel-1" aria-selected="false">Approved Today</a>
                     </li>

                     <li class="nav-item" role="presentation">
                        <a class="nav-link" id="simple-tab-1" data-bs-toggle="tab" href="#simple-tabpanel-2" role="tab" aria-controls="simple-tabpanel-2" aria-selected="false">Latest Approved</a>
                     </li>
                     
                     </ul>
                     <div class="tab-content pt-5" id="tab-content">
                     <div class="tab-pane active" id="simple-tabpanel-0" role="tabpanel" aria-labelledby="simple-tab-0">
                            @include('systems.watchlisted.admin.pages.dashboard.sections.tabs.added_today')
                     </div>
                     <div class="tab-pane" id="simple-tabpanel-1" role="tabpanel" aria-labelledby="simple-tab-1">
                            @include('systems.watchlisted.admin.pages.dashboard.sections.tabs.approved_today')
                     </div>
                     <div class="tab-pane" id="simple-tabpanel-2" role="tabpanel" aria-labelledby="simple-tab-1">
                            @include('systems.watchlisted.admin.pages.dashboard.sections.tabs.latest_today')
                     </div>
                     </div>
                
               </div>

            </div>
     
            
         </div>
      </div>
   </div>
</div>