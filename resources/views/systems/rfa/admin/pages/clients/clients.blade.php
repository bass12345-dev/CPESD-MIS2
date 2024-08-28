@extends('systems.rfa.admin.layout.admin_master')
@section('title', $title)
@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card" style="border: 1px solid;">
                <div class="card-body">
                    @include('systems.rfa.admin.pages.clients.sections.table')
                </div>
            </div>
        </div>
    </div>
</div>
@include('systems.rfa.admin.pages.clients.modals.update_client_modal')
@endsection
@section('js')
<script>

var rfa_clients_table = $('#rfa_clients_table').DataTable({
   responsive: false,
   "ajax": {
      "url": base_url + '/admin/act/rfa/get-clients',
      "type": "GET",
      "dataSrc": "",
   },
   'columns': [{
      data: "full_name",
   }, {
      data: "address",
   }, {
      data: "contact_number",
   }, {
      data: "age",
   }, {
      data: null,
      render :function(row){
         return row.gender == '' ? '<span class="text-danger">Please Update Gender</span>' :capitalizeFirstLetter(row.gender)
      }
   }, {
      data: "employment_status",
   }, {
      data: null,
      render: function (data, type, row) {
         return '<div class="btn-group dropleft">\ <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\ <i class="ti-settings" style="font-size : 15px;"></i>\ </button>\ <div class="dropdown-menu">\ <a  href="javascript:;" class="dropdown-item completed text-danger" id="delete-client" data-name="' + data['full_name'] + '" data-id="' + data['rfa_client_id'] + '"   ><i class="fa fa-trash"></i> Delete</a>\ <a  href="javascript:;" class="dropdown-item completed text-secondary" id="update-client" data-toggle="modal" data-target="#update_client_modal" data-name="' + data['full_name'] + '" \ data-id="' + data['rfa_client_id'] + '"  \ data-first-name="' + data['first_name'] + '"  \ data-middle-name="' + data['middle_name'] + '"  \ data-last-name="' + data['last_name'] + '"  \ data-extension="' + data['extension'] + '"  \ data-purok="' + data['purok'] + '"  \ data-barangay="' + data['barangay'] + '"  \ data-contact="' + data['contact_number'] + '"  \ data-age="' + data['age'] + '" \ data-gender="' + data['gender'] + '"  \ data-employment-status="' + data['employment_status'] + '"  \ ><i class="fa fa-edit"></i> Update</a>\ </di>';
      }
   }, ]
});

$(document).on('click', 'a#update-client', function (e) {
   $('input[name=client_id_]').val($(this).data('id'));
   $('input[name=update_first_name]').val($(this).data('first-name'));
   $('input[name=update_middle_name]').val($(this).data('middle-name'));
   $('input[name=update_last_name]').val($(this).data('last-name'));
   $('input[name=update_extension]').val($(this).data('extension'));
   $('input[name=update_purok]').val($(this).data('purok'));
   $('select[name=update_barangay]').val($(this).data('barangay'));
   $('input[name=update_contact_number]').val($(this).data('contact'));
   $('input[name=update_age]').val($(this).data('age'));
   $('select[name=update_employment_status]').val($(this).data('employment-status'));
   $('select[name=gender]').val($(this).data('gender'));
});


$('#update_client_form').on('submit', function (e) {
   e.preventDefault();
   var button = $('.btn-update-client');
   $.ajax({
      type: "POST",
      url: base_url + '/admin/act/rfa/update-client',
      data: $(this).serialize(),
      cache: false,
      dataType: 'json',
      beforeSend: function () {
         button.text('Please wait...');
         button.attr('disabled', 'disabled');
      },
      headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
      success: function (data) {
         if (data.response) {
            $('#update_client_modal').modal('hide');
            button.text('Update');
            button.removeAttr('disabled');
            toast_message_success(data.message);
            rfa_clients_table.ajax.reload();
         } else {
            button.text('Save Changes');
            button.removeAttr('disabled');
            toast_message_error(data.message);
         }
      },
      error: function (xhr) {
         alert("Error occured.please try again");
         button.text('Save Changes');
            button.removeAttr('disabled');
      }
   });
});

$(document).on('click', 'a#delete-client', function (e) {
   var id = $(this).data('id');
   var name = $(this).data('name');
   Swal.fire({
      title: "",
      text: "Delete " + name,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "No, cancel!",
      reverseButtons: true
   }).then(function (result) {
      if (result.value) {
         $.ajax({
            type: "POST",
            url: base_url + '/admin/act/rfa/delete-client',
            data: {
               id: id
            },
            cache: false,
            dataType: 'json',
            beforeSend: function () {
               Swal.fire({
                  title: "",
                  text: "Please Wait",
                  icon: "",
                  showCancelButton: false,
                  showConfirmButton: false,
                  reverseButtons: false,
                  allowOutsideClick: false
               })
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
               if (data.response) {
                  Swal.fire("", "Success", "success");
                  rfa_clients_table.ajax.reload()
               } else {
                  Swal.fire("", data.message, "error");
               }
            }
         })
      } else if (result.dismiss === "cancel") {
         swal.close()
      }
   });
});
</script>
@endsection