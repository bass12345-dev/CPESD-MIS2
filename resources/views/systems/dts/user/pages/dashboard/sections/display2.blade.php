<div class="row">
   <div class="col-xl-12 col-xxl-12 d-flex">
      <div class="w-100">
         <div class="row">
            <div class="col-sm-7">
               <div>
                  <div class="card">
                     <div class="card-header bg-primary text-white">
                           Document Added Today - {{$today}}
                     </div>
                     <table class="table">
                        <thead>
                           <tr>
                              <th class="text-center">#</th>
                              <th class="text-center">Tracking Number</th>
                              <th class="text-center">Document Name</th>
                              <th class="text-center">Type</th>
                              <th class="text-center">Transaction Type</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $i =1; foreach($count['added_today'] as $row) {
                               ?>
                           <tr>
                              <th class="text-center">{{$i++}}</th>
                              <td class="text-center">{{$row->tracking_number}}</td>
                              <td><a href="{{url('/dts/user/view?tn='.$row->tracking_number)}}" data-toggle="tooltip" data-placement="top" title="View <?php echo $row->tracking_number ?>"><?php echo $row->document_name; ?></a></td>
                              <td class="text-center">{{$row->type_name}}</td>
                              <td class="text-center">{{$row->destination_type}}</td>
                           </tr>
                          <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>

            </div>
            <div class="col-sm-5">
              
                  <div class="card documents_forwarded">
                     <div class="card-header bg-danger text-white">
                        Documents Forwarded
                        
                     </div>
                     <ul class="list-group list-group-flush">
                        <?php foreach($forwarded_to_users as $row): ?>
                        <li class="list-group-item text-danger">{{$row}}</li>
                        <?php endforeach; ?>
                        <li class="list-group-item text-danger"><a href="{{url('/dts/user/forwarded')}}">See all</a></li>
               
                     </ul>
                     
                  </div>
              

            </div>

         </div>
      </div>
   </div>
</div>