<div class="card flex-fill p-3">
   <div class="card-header">
      <h5 class="card-title mb-2">Information</h5>
      <?php
      if (session('watch_id') == $person_data->user_id || session('user_type') == 'admin') {
         echo '<button class="btn btn-primary update_information_button" data-bs-toggle="offcanvas" data-bs-target="#update_canvas">Update Information</button>';
      }
      ?>

   </div>
   <input type="hidden" type="person_id" value="{{$person_data->person_id}}">
   <table class="table table-hover table-striped " style="width: 100%; ">
      <tr>
         <td>Full Name</td>
         <td class="name">{{$person_data->first_name}} {{$person_data->middle_name}} {{$person_data->last_name}} {{$person_data->extension}}</td>
      </tr>
      <tr>
         <td>Email Address</td>
         <td class="email">{{$person_data->email_address}}</td>
      </tr>
      <tr>
         <td>Phone Number</td>
         <td class="phone_number">{{$person_data->phone_number}}</td>
      </tr>
      <tr>
         <td>Address</td>
         <td class="address">{{$person_data->address}}</td>
      </tr>
      <tr>
         <td>Age</td>
         <td class="age">{{$person_data->age}}</td>
      </tr>
      <tr>
         <td>Gender</td>
         <td class="gender"><?php

                              $display_gender = $person_data->gender == null ? 'please update gender' :  $person_data->gender;
                              echo ucfirst($display_gender);

                              ?></td>
      </tr>
      <tr>
         <td>Added</td>
         <td>{{ date('M d Y', strtotime($person_data->created_at)) }}</td>
      </tr>

      <tr>
         <td>Encoded By</td>
         <td>{{ $person_data->user_first_name.' '.$person_data->user_middle_name.' '.$person_data->user_last_name.' '.$person_data->user_extension }}</td>
      </tr>
      <tr>
         <td>Status</td>
         <?php
         $status  = '';
         $bg      = '';

         switch ($person_data->status) {
            case 'not-approved':
               $status = 'To Approved';
               $bg = 'bg-warning';
               break;
            case 'inactive':
               $status = 'Removed';
               $bg = 'bg-success';
               break;
            case 'active':
               $status = 'Approved';
               $bg = 'bg-danger';

            default:

               break;
         }
         ?>
         <td><span class="{{$bg}} p-2 text-black badge " style="font-size: 17px;">{{ $status }}</span></td>
      </tr>


   </table>

</div>