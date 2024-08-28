<div class="card flex-fill p-3">
   <div class="card-header">
      <h5 class="card-title mb-0"> User Information</h5>
   </div>
   <table class="table table-hover table-striped " style="width: 100%; ">
      <tr>
         <td>Full Name</td>
         <td class="text-start">{{$title}}</td>
      </tr>
      <tr>
         <td>Address</td>
         <td class="text-start">{{$user->address}}</td>
      </tr>
      <tr>
         <td>Username</td>
         <td class="text-start">{{$user->username}}</td>
      </tr>
      <tr>
         <td>Email</td>
         <td class="text-start">{{$user->email_address}}</td>
      </tr>
      <tr>
         <td>Phone Number</td>
         <td class="text-start">{{$user->contact_number}}</td>
      </tr>
      <tr>
         <td>Status</td>
         <td class="text-start">
            <?php echo $user->user_status == 'active' ? '<span class="badge bg-success p-2">Active</span>' : '<span class="badge bg-danger p-2">Inactive</span>' ?>
         </td>
      </tr>
      
   </table>

</div>