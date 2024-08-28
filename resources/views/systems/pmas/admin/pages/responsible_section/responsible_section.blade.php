@extends('systems.pmas.admin.layout.admin_master')
@section('title', $title)
@section('content')
<div class="row">
   <div class="col-12 mt-5">
      <div class="card" style="border: 1px solid;">
         <div class="card-body">

            <div class="row">
               @include('systems.pmas.admin.pages.responsible_section.sections.table')
               @include('systems.pmas.admin.pages.responsible_section.sections.form')
            </div>
         </div>
      </div>
   </div>
</div>
@include('systems.pmas.admin.pages.responsible_section.modals.update_modal')
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
<script>
   var responsible_section_table = $('#responsible_section_table').DataTable({
      "ajax": {
         "url": base_url + '/admin/act/pmas/get-responsible',
         "type": "GET",
         "dataSrc": "",
      },
      'columns': [{
         data: null,
         render: function(data, type, row) {
            return '<span href="javascript:;"   data-id="' + data['responsible_section_id'] + '"  style="color: #000;" class="table-font-size" >' + data['responsible_section_name'] + '</span>';
         }
      }, {
         data: null,
         render: function(data, type, row) {
            return '<ul class="d-flex justify-content-center">\ <li class="mr-3 "><a href="javascript:;" class="text-secondary action-icon" data-id="' + data['responsible_section_id'] + '" data-name="' + data['responsible_section_name'] + '" id="update-responsible" data-toggle="modal" data-target="#update_responsible_modal"><i class="fa fa-edit"></i></a></li>\ <li><a href="javascript:;" data-name="' + data['responsible_section_name'] + '" data-id="' + data['responsible_section_id'] + '"  id="delete-responsible"  class="text-danger action-icon"><i class="ti-trash"></i></a></li>\ </ul>';
         }
      }, ]
   });
   $(document).on('click', 'a#update-responsible', function(e) {
      $('input[name=responsible_id]').val($(this).data('id'));
      $('input[name=update_responsible_name]').val($(this).data('name'));
   });
   $('#update_responsible_form').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
         type: "POST",
         url: base_url + '/admin/act/pmas/update-responsible',
         data: $(this).serialize(),
         dataType: 'json',
         beforeSend: function() {
            $('.btn-update-responsible').text('Please wait...');
            $('.btn-update-responsible').attr('disabled', 'disabled');
         },
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         success: function(data) {
            if (data.response) {
               $('.btn-update-responsible').text('Submit');
               $('.btn-update-responsible').removeAttr('disabled');
               $('#update_responsible_modal').modal('hide');
               Swal.fire("", data.message, "success");
               responsible_section_table.ajax.reload();
            } else {
               Swal.fire("", data.message, "error");
               $('.btn-update-responsible').text('Submit');
               $('.btn-update-responsible').removeAttr('disabled');
            }
         },
         error: function(xhr) {
            alert("Error occured.please try again");
            $('.btn-update-responsible').text('Submit');
            $('.btn-update-responsible').removeAttr('disabled');
         },
      });
   });
   $('#add_responsible_section_form').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
         type: "POST",
         url: base_url + '/admin/act/pmas/add-responsible',
         data: $(this).serialize(),
         dataType: 'json',
         beforeSend: function() {
            $('.btn-add-responsible').text('Please wait...');
            $('.btn-add-responsible').attr('disabled', 'disabled');
         },
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         success: function(data) {
            if (data.response) {
               $('#add_responsible_section_form')[0].reset();
               $('.btn-add-responsible').text('Submit');
               $('.btn-add-responsible').removeAttr('disabled');
               $('.alert').html(' <div class="alert-dismiss mt-2">\ <div class="alert alert-success alert-dismissible fade show" role="alert">\ <strong>' + data.message + '.\ <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-times"></span>\ </button>\ </div>\ </div>');
               setTimeout(function() {
                  $('.alert').html('')
               }, 3000);
               responsible_section_table.ajax.reload();
            } else {
               $('.btn-add-responsible').text('Submit');
               $('.btn-add-responsible').removeAttr('disabled');
               $('.alert').html(' <div class="alert-dismiss mt-2">\ <div class="alert alert-warning alert-dismissible fade show" role="alert">\ <strong>' + data.message + '.\ <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="fa fa-times"></span>\ </button>\ </div>\ </div>');
            }
         },
         error: function(xhr) {
            alert("Error occured.please try again");
            $('.btn-add-responsible').text('Submit');
            $('.btn-add-responsible').removeAttr('disabled');
         },
      });
   });
   $(document).on('click', 'a#delete-responsible', function(e) {
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
      }).then(function(result) {
         if (result.value) {
            $.ajax({
               type: "POST",
               url: base_url + '/admin/act/pmas/delete-responsible',
               data: {
                  id: id
               },
               cache: false,
               dataType: 'json',
               beforeSend: function() {
                  Swal.fire({
                     title: "",
                     text: "Please Wait",
                     icon: "",
                     showCancelButton: false,
                     showConfirmButton: false,
                     reverseButtons: false,
                     allowOutsideClick: false
                  });
               },
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
               },
               success: function(data) {
                  if (data.response) {
                     Swal.fire("", "Success", "success");
                     responsible_section_table.ajax.reload();
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