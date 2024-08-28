<div class="card flex-fill p-3">
         <div class="card-header">
            <h5 class="card-title mb-0">History</h5>
         </div>
         <table class="table table-hover table-striped " id="datatables-buttons" style="width: 100%; "  >
            <thead>
               <tr>
                
                  <th >Date Released</th>
                  <th >User </th>
                  <th >Date Received</th>
                  <th >User</th>
                  <th>Duration   </th>
                  <th>Remarks</th>
                  <th>Final Action</th>

               </tr>
            </thead>
            <tbody>

               <?php foreach ($history as $row) : ?>
               <tr>
                  <td>{{$row['date_released']}}</td>
                  <td>{{$row['user1']}}</td>
                  <td>{{$row['date_received']}}</td>
                  <td><?php echo $row['user2'] == 'final' ? '<span class="text-danger">Final Receiver</span>' : $row['user2'] ?></td>
                  <td>{{$row['duration']}}</td>
                   <td><a href="javascript:;" id="view_remarks" data-remarks="{{$row['remarks']}}" data-bs-toggle="modal" data-bs-target="#staticBackdrop">View Remarks</a></td>
                   <td><?php echo $row['final_action_taken'] == NULL ? ' - ' : '<span class="badge p-2 bg-primary">'.$row['final_action_taken'].'</span>'  ?></td>
               </tr>
            <?php endforeach; ?>
            </tbody>
         </table>
      </div>