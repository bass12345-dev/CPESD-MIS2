<div class="row">
   <div class="col-md-6">
      <div class="card flex-fill p-3">
         <div class="card-header">
            <h5 class="card-title mb-0">Information</h5>
         </div>
         <table class="table table-hover table-striped " style="width: 100%; ">
            <tr>
               <td>Document Name</td>
               <td class="text-start">{{$doc_data['document_name']}}</td>
            </tr>
            <tr>
               <td>Tracking Number</td>
               <td>{{$doc_data['tracking_number']}}</td>
            </tr>
            <tr>
               <td>Encoded/Added By</td>
               <td>{{$doc_data['encoded_by']}}</td>
            </tr>
            <tr>
               <td>Origin</td>
               <td>{{$doc_data['office']}}</td>
            </tr>

            <tr>
               <td>Document Type</td>
               <td>{{$doc_data['document_type']}}</td>
            </tr>
            <tr>
               <td>Description</td>
               <td>{{$doc_data['description']}}</td>
            </tr>
            <tr>
               <td>Type</td>
               <td>{{$doc_data['destination_type']}}</td>
            </tr>
            <tr>
               <td>Qr Code</td>
               <td><img src="{{$doc_data['qr']}}"></td>
            </tr>
            <tr>
               <td>Status</td>
               <td><?php echo $doc_data['status'] ?></td>
            </tr>
            
         </table>

      </div>
   </div>
   <div class="col-md-6">
   <div class="card flex-fill p-3">
   <div class="card-header">
            <h5 class="card-title mb-0">Outgoing History</h5>
         </div>
      <table class="table table-hover table-striped " id="datatables-buttons" style="width: 100%; "  >
            <thead>
               <tr>
                
                  <th >Person Responsible</th>
                  <th >Office</th>
                  <th >Remarks</th>
                  <th>Status</th>
                  <th>Outgoing Date</th>
                  <th>Date Returned</th>

               </tr>
            </thead>
            <tbody>
            <?php foreach ($outgoing_history as $row) : ?>
               <tr>
                  <td>{{$row->first_name}} {{$row->middle_name}} {{$row->last_name}} {{$row->extension}}</td>
                  <td>{{$row->office}}</td>
                  <td><a href="javascript:;" id="view_remarks" data-remarks="{{$row->remarks}}">View Remarks</a></td>
                  <td><?php
                        $status = $row->status == 'return' ? '<span class="badge bg-success">Returned</span>' : '<span class="badge bg-danger">Pending</span>';
                        echo $status;
                  ?></td>
                  <td>{{date('M d Y h:i A', strtotime($row->outgoing_date))}}</td>
                  <td><?php echo $row->outgoing_date_received != null ? date('M d Y h:i A', strtotime($row->outgoing_date)) :  '-'; ?></td>
               </tr>
            <?php 
            endforeach; ?>
            </tbody>
      </table>
   </div>
   </div>
</div>