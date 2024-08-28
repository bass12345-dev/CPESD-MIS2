<div class="modal fade" id="print_option_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Print Option</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body p-4">
            <input type="hidden" name="cso_idd">
            <div class="row ">
               <div class="col-md-8 mb-2">
                  <?php
                     foreach ($cso_print_options as $row) {

                        $option = '';
                        $id = '';
                        if ($row == 'print_cso_information') {
                           $option = 'CSO Information';
                        } else if ($row == 'print_cso_project') {
                           $option = 'CSO Project';
                           $id = 'id="cso_project_option"';
                        } else if ($row == 'print_cso_officers') {
                           $option = 'Officers';

                        }
                                             
                        
                   ?>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="checkbox" name="options" <?php   echo $id ?>
                        value="<?php   echo $row ?>">
                     <label class="form-check-label" for="inlineCheckbox1"><?php   echo $option ?></label>
                  </div>


                  <?php } ?>

               </div>
               <div class="col-md-4" id="select_year_section" hidden>
                  <select id="select_year_cso_project" class="form-control">
                     <option value="0" selected>Select Year</option>
                     <option value="2023">2023</option>
                     <option value="2024">2024</option>
                     <option value="2025">2025</option>
                  </select>
               </div>
            </div>
            <div class="row mt-3">
               <button type="button" class="btn sub-button btn-block" id="generate_for_print">Generate</button>
               <button type="button" class="btn btn-success btn-block" id="print_button" onclick="print(); " hidden><i
                     class="fa fa-print"></i> Print</button>
            </div>
            <div class="row mt-3 print_generated p-3">
            </div>
         </div>
      </div>
   </div>
</div>