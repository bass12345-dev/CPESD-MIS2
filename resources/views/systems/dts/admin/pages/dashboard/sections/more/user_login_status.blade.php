

         
                  <div class="card log-status"  >
                     <div class="card-header bg-danger text-white">
                       Users Logged in Status And Pending Documents 
                       <!-- <button class="btn btn-primary" onclick="print_status();"><i class="fas fa-print"></i></button> -->
                     </div>
                     <ul class="list-group list-group-flush" id="user_logged_in_status">
                       <?php foreach($inactive as $row): ?>
                        <li class="list-group-item ">
                           <?php echo $row; ?>
                      </li>
                       <?php endforeach; ?>
                     </ul>
                  </div>
            

            