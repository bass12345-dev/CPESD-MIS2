<div class="card">
                     <div class="card-header bg-primary text-white">
                        Completed Today - {{$today}}
                     </div>
                     <table class="table">
                        <thead>
                           <tr>
                              <th scope="col">#</th>
                              <th scope="col">Tracking Number</th>
                              <th scope="col">Document Name</th>
                              <th scope="col">Document Type</th>
                              <th scope="col">Transaction Type</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $i =1; foreach($count['completed_today'] as $row) {
                               ?>
                           <tr>
                              <th scope="row">{{$i++}}</th>
                              <td>{{$row->tracking_number}}</td>
                              <td><a href="{{url('/admin/dts/view?tn='.$row->tracking_number)}}" data-toggle="tooltip" data-placement="top" title="View <?php echo $row->tracking_number ?>"><?php echo $row->document_name; ?></a></td>
                              <td>{{$row->type_name}}</td>
                              <td>{{$row->destination_type}}</td>
                           </tr>
                          <?php } ?>
                        </tbody>
                     </table>
                  </div>