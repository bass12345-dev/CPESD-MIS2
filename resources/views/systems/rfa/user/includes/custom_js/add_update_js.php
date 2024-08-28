<script>
    
   $('input[name=name_of_client]').click(function (e) {
      e.preventDefault();
      $('#search_name_modal').modal('show');
   });
   $(document).on('click', 'button#add_client', function (e) {
      $('#add_client_modal').modal('show');
   });

   
   $('input[name=name_of_client]').click(function (e) {
      e.preventDefault();
      $('#search_name_modal').modal('show');
   });
   $(document).on('click', 'button#add_client', function (e) {
      $('#add_client_modal').modal('show');
   });

   $(document).on('click', 'button#search_client', function (e) {
      var first_name = $('input[name=search_first_name]').val();
      var last_name = $('input[name=search_last_name]').val();
      $('#search_name_result_table').DataTable().destroy();
      if (first_name == '' && last_name == '') {
         alert('please input First Name or Last Name');
      } else {
         search_name_result(first_name, last_name)
      }
   });


   
   function search_name_result(first_name, last_name) {
      $.ajax({
         url: base_url + '/user/act/rfa/s-c',
         type: "POST",
         data: {
            first_name: first_name,
            last_name: last_name
         },
         dataType: "json",
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         success: function (data) {
            $('#search_name_result').removeAttr('hidden');
            $('#search_name_result_table').DataTable({
               "ordering": false,
               search: true,
               "data": data,
               'columns': [{
                  data: 'first_name',
               }, {
                  data: 'last_name',
               }, {
                  data: 'middle_name',
               }, {
                  data: 'extension',
               }, {
                  data: null,
                  render: function (data, type, row) {
                     return '<ul class="d-flex justify-content-center">\ <li class="mr-3 "><a href="javascript:;" class="text-success action-icon" data-id="' + data['rfa_client_id'] + '" \ data-name="' + data['first_name'] + ' ' + data['middle_name'] + ' ' + data['last_name'] + ' ' + data['extension'] + '"  \ id="confirm-client"><i class="fa fa-check"></i></a></li>\ <li><a href="javascript:;" \ \ data-id="' + data['rfa_client_id'] + '"  \ data-name="' + data['first_name'] + ' ' + data['middle_name'] + ' ' + data['last_name'] + ' ' + data['extension'] + '"  \ data-address="' + data['address'] + '"  \ data-number="' + data['contact_number'] + '"  \ data-age="' + data['age'] + '"  \ data-status="' + data['employment_status'] + '"  \ id="view-client-data"  class="text-secondary action-icon"><i class="ti-eye"></i></a></li>\ </ul>';
                  }
               },]
            });
         }
      });
   }


   $(document).on('click', 'a#confirm-client', function (e) {
      $('#search_name_modal').modal('hide');
      $('input[name=search_first_name]').val('');
      $('input[name=search_last_name]').val('');
      $('#search_name_result').attr("hidden", true);
      $('input[name=name_of_client]').val($(this).data('name'));
      $('input[name=client_id]').val($(this).data('id'));
   });
   $(document).on('click', 'a#view-client-data', function (e) {
      $('#view_client_information_modal').modal('show');
      $('.complete_name').text($(this).data('name'));
      $('.address').text($(this).data('address'));
      $('.contact_number').text($(this).data('number'));
      $('.age').text($(this).data('age'));
      $('.employment_status').text($(this).data('status'));
   });
   $(document).on('click', 'button#close_search_client', function (e) {
      $('#search_name_result').attr("hidden", true);
   });

   $(document).on('change', 'select[name=type_of_transaction]', function () {
      if ($('select[name=type_of_transaction]').val() == 'simple') {
         $('#refer_to').attr('hidden', false)
      } else {
         $('#refer_to').attr('hidden', true)
      }
   });


   $('#add_client_form').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
         type: "POST",
         url: base_url + '/user/act/rfa/a-c',
         data: new FormData(this),
         contentType: false,
         cache: false,
         processData: false,
         dataType: 'json',
         beforeSend: function () {
            $('.btn-add-client').text('Please wait...');
            $('.btn-add-client').attr('disabled', 'disabled');
         },
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         success: function (data) {
            if (data.response) {
               $('#add_client_modal').modal('hide');
               $('#add_client_form')[0].reset();
               $('.btn-add-client').text('Save Changes');
               $('.btn-add-client').removeAttr('disabled');
               toast_message_success(data.message)
            } else {
               $('.btn-add-client').text('Save Changes');
               $('.btn-add-client').removeAttr('disabled');
               toast_message_error(data.message)
            }
         },
         error: function (xhr) {
            alert("Error occured.please try again");
            $('.btn-add-client').text('Save Changes');
            $('.btn-add-client').removeAttr('disabled');
            location.reload();
         },
      });
   });


</script>