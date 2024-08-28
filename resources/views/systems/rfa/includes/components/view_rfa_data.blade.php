<div class="col-md-12 ">
   <div class="data-tables">
      <table class="tablesaw table-bordered table-hover table" >
         <tr>
            <td colspan = "2">
               <a  href    = "javascript:;" class = "mt-2  mb-2 btn sub-button text-center  btn-rounded btn-md btn-block"><i class = "fa fa-user" aria-hidden = "true"></i>RFA Information</a>
           
            </td>
         </tr>
         <tr>
            <td >Reference No.</td>
            <td class="reference_no">{{$title}}</td>
         </tr>
         <tr>
            <td >Name of Client</td>
            <td class="name_of_client">{{$data->client_first_name . ' ' . $data->client_middle_name . ' ' . $data->client_last_name . ' ' . $data->client_extension;}}</td>
         </tr>
         <tr>
            <td >Type Of Request</td>
            <td class="type_of_request">{{$data->type_of_request_name}}</td>
         </tr>
         <tr>
            <td>Type Of Transaction</td>
            <td class="type_of_transaction">{{$data->type_of_transaction}}</td>
         </tr>
         <tr>
            <td >Date & Time Filed</td>
            <td class="date_and_time">{{date('F d Y h:i:A', strtotime($data->rfa_date_filed))}}</td>
         </tr>
        <!--   <tr>
            <td >Approved Date & Time</td>
            <td class="approve_date"></td>
         </tr> -->
           <tr>
            <td >Status</td>
            <td class="status">
                <?php echo $data->rfa_status == 'pending' ? '<span class="badge bg-danger text-white p-2">'.ucfirst($data->rfa_status).'</span>' : '<span class="badge bg-success text-white p-2 mr-2">'.ucfirst($data->rfa_status).'</span><span>'.date('F d Y h:i:A', strtotime($data->approved_date)).'</span>' ?>
            </td>
         </tr>
         <tr>
            <td >Encoded By</td>
            <td class="encoded_by">{{$data->first_name.' '.$data->middle_name.' '.$data->last_name.' '.$data->extension}}</td>
         </tr>
         <tr>
            <td >Referred To</td>
            <td class="referred_to">{{$data->reffered_first_name.' '.$data->reffered_middle_name.' '.$data->reffered_last_name.' '.$data->reffered_extension}}</td>
         </tr>
      </table>


   </div>
</div>