<script>

$(document).ready(function () {
      $('.js-example-basic-single').select2();
   });

   $('#date_and_time').datetimepicker({
      "allowInputToggle": true,
      "showClose": true,
      "showClear": true,
      "showTodayButton": true,
      "format": "YYYY/MM/DD hh:mm:ss A",
   });
   $('#id_1').datetimepicker({
      "allowInputToggle": true,
      "showClose": true,
      "showClear": true,
      "showTodayButton": true,
      "format": "YYYY/MM/DD hh:mm:ss A",
   });
   $('#id_2').datetimepicker({
      "allowInputToggle": true,
      "showClose": true,
      "showClear": true,
      "showTodayButton": true,
      "format": "YYYY/MM/DD hh:mm:ss A",
   });


    
   $(".numbers").keyup(function (e) {
      checkNumbersOnly($(this));
   });

   function checkNumbersOnly(myfield) {
      if (/[^\d\.]/g.test(myfield.val())) {
         myfield.val(myfield.val().replace(/[^\d\.]/g, ''));
      }
   }

   $('#select_under_activity_form').on('submit', function (e) {
      e.preventDefault();
      $('input[name=select_under_type_id]').val($('#select_under_type').find('option:selected').val());
      $('#select_under_activity_modal').modal('hide')
   });


   $(document).on('click', 'button.close-under-type', function () {
      var text = $('#type_of_activity_select').find('option:selected').text();
      var select_type = $('#select_under_type').find('option:selected').val();
      if (!select_type) {
         alert('Please Select Type of' + text);
      } else {
         $('#select_under_activity_modal').modal('hide');
         $("#select_under_type option").remove();
      }
   });

   $(document).on('change', 'select#type_of_activity_select', function (e) {
      $("#select_under_type option").remove();
      var id = $('#type_of_activity_select').find('option:selected').val();
      var text = $('#type_of_activity_select').find('option:selected').text().toString().toLowerCase().trim();
      $('input[name=select_under_type_id]').val('');

      if (!id) {
         alert('Please Select Type Of Activity');
      } else {
         $.ajax({
            url: base_url + '/user/act/pmas/get_under_type_of_activity',
            data: {
               id: id
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
               loader();
            },
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            
            error: err => {
               console.log(err);
               alert("An error occured");
               JsLoadingOverlay.hide();
            },
            success: function (result) {
               if (text == '<?php echo $training_text ?>') {
                  $('#select_under_activity_modal').modal('show');
                  var $dropdown = $("#select_under_type");
                  $dropdown.append($("<option />").val('').text('Select Type'));
                  $.each(result, function () {
                     $dropdown.append($("<option />").val(this.under_type_act_id).text(this.under_type_act_name));
                  });
               }
               JsLoadingOverlay.hide();
            }
         })
      }
      switch (text) {
         case '<?php echo $training_text ?>':
            $('#under_type_activity_select').removeAttr('hidden').fadeIn("slow");
            $('.for_training').removeAttr('hidden').fadeIn("slow");
            $('.for_project_monitoring').attr('hidden', 'hidden');
            $('.for_project_meeting').attr('hidden', 'hidden');

            break;
         case '<?php echo $rgpm_text ?>':
            $('#under_type_activity_select').attr('hidden', 'hidden');
            $('.for_training').attr('hidden', 'hidden');
            $('.for_project_monitoring').removeAttr('hidden').fadeIn("slow");
            $('.for_project_meeting').attr('hidden', 'hidden');

            break;
         case '<?= $rmm ?>':
            $('#under_type_activity_select').attr('hidden', 'hidden');
            $('.for_training').attr('hidden', 'hidden');
            $('.for_project_monitoring').attr('hidden', 'hidden');
            $('.for_project_meeting').removeAttr('hidden').fadeIn("slow");
            break;

         default:
            $('#under_type_activity_select').attr('hidden', 'hidden');
            $('.for_training').attr('hidden', 'hidden');
            $('.for_project_monitoring').attr('hidden', 'hidden');
            $('.for_project_meeting').attr('hidden', 'hidden');
            break;
      }


   });

</script>