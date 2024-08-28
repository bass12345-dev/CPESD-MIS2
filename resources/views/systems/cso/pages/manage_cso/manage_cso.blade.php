@extends('systems.cso.layout.cso_master')
@section('title', $title)
@section('content')
<div class="row">
   <div class="col-12 mt-5">
      <div class="card" style="border: 1px solid;">
         <div class="card-body">
            <div class="row">
               <div class="col-md-12">
                  @include('systems.cso.pages.manage_cso.sections.filter')
                  @include('systems.cso.pages.manage_cso.sections.table')
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@include('systems.cso.pages.manage_cso.modals.add_cso_modal')
@include('systems.cso.pages.manage_cso.modals.update_cso_status_modal')
@endsection
@section('js')
<script>
   var cso_status = $('#cso_status option:selected').val();
   var cso_type = $('#cso_type option:selected').val();
   $(document).on('click', 'button#reload_cso_filter', function(e) {
      $('#cso_table').DataTable().destroy();
      $("select").val('');
      get_cso();
   });

   function get_cso(cso_status = '', cso_type = '') {
      $.ajax({
         url: base_url + '/user/act/cso/get-cso',
         type: "POST",
         data: {
            cso_status: cso_status,
            cso_type: cso_type,
         },
         dataType: "json",
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         success: function(data) {
            $('#cso_table').DataTable({
               scrollX: true,
               "ordering": false,
               lengthMenu: [20, 50, 100, 200, 500],
               "data": data,
               "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
               buttons: [{
                  extend: 'excel',
                  text: 'Excel',
                  className: 'btn btn-default ',
                  exportOptions: {
                     columns: 'th:not(:last-child)'
                  }
               }, {
                  extend: 'pdf',
                  text: 'pdf',
                  className: 'btn btn-default',
                  exportOptions: {
                     columns: 'th:not(:last-child)'
                  }
               }, {
                  extend: 'print',
                  text: 'print',
                  className: 'btn btn-default',
                  exportOptions: {
                     columns: 'th:not(:last-child)'
                  }
               }, ],
               'columns': [{
                  data: null,
                  render: function(data, type, row) {
                     return '<b><a href="javascript:;"   data-id="' + data['cso_id'] + '"  style="color: #000;"  >' + data['cso_code'] + '</a></b>';
                  }
               }, {
                  data: null,
                  render: function(data, type, row) {
                     return '<a href="javascript:;"   data-id="' + data['cso_id'] + '"  style="color: #000;"  >' + data['cso_name'] + '</a>';
                  }
               }, {
                  data: null,
                  render: function(data, type, row) {
                     return '<a href="javascript:;"   data-id="' + data['cso_id'] + '"  style="color: #000;"  >' + data['address'] + '</a>';
                  }
               }, {
                  data: null,
                  render: function(data, type, row) {
                     return '<a href="javascript:;"   data-id="' + data['cso_id'] + '"  style="color: #000;"  >' + data['contact_person'] + '</a>';
                  }
               }, {
                  data: null,
                  render: function(data, type, row) {
                     return '<a href="javascript:;"   data-id="' + data['cso_id'] + '"  style="color: #000;"  >' + data['contact_number'] + '</a>';
                  }
               }, {
                  data: null,
                  render: function(data, type, row) {
                     return '<a href="javascript:;"   data-id="' + data['cso_id'] + '"  style="color: #000;"  >' + data['telephone_number'] + '</a>';
                  }
               }, {
                  data: null,
                  render: function(data, type, row) {
                     return '<a href="javascript:;"   data-id="' + data['cso_id'] + '"  style="color: #000;"  >' + data['email_address'] + '</a>';
                  }
               }, {
                  data: null,
                  render: function(data, type, row) {
                     return '<a href="javascript:;"   data-id="' + data['cso_id'] + '"  style="color: #000;"  >' + data['type_of_cso'] + '</a>';
                  }
               }, {
                  data: null,
                  render: function(data, type, row) {
                     return row.status;
                  }
               }, {
                  data: null,
                  render: function(data, type, row) {
                     return '<div class="btn-group dropleft">\ <button type="button" class="btn btn-secondary dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\ <i class="ti-settings" style="font-size : 15px;"></i>\ </button>\ <div class="dropdown-menu">\ <a class="dropdown-item" href="javascript:;" data-id="' + data['cso_id'] + '"  id="view-cso" > <i class="ti-eye"></i> View/Update Information</a>\ <hr>\ <a class="dropdown-item " href="javascript:;" data-id="' + data['cso_id'] + '" data-status="' + data['cso_status'] + '"    id="update-cso-status" ><i class="ti-pencil"></i> Update CSO Status</a>\ <hr>\ <a class="dropdown-item text-danger" href="javascript:;" data-id="' + data['cso_id'] + '" data-status="' + data['cso_status'] + '" data-name="' + data['cso_name'] + '"    id="delete-cso" ><i class="ti-trash"></i> Delete</a>\ </di>';
                  }
               }, ]
            })
         }
      })
   };
   
   $(document).on('click', 'a#delete-cso', function(e) {
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
               url: base_url + '/user/act/cso/delete-cso',
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
                     $('#cso_table').DataTable().destroy();
                     get_cso();
                  } else {
                     Swal.fire("", data.message, "error")
                  }
               },
               error: function(xhr) {
                  alert("Error occured.please try again");
                  location.reload();
               },

            });
         } else if (result.dismiss === "cancel") {
            swal.close();
         }
      });
   });

   function load_cso_by_type($this) {
      $('#cso_table').DataTable().destroy();
      get_cso($('#cso_status option:selected').val(), $this.value);
   }

   function load_cso_by_status($this) {
      $('#cso_table').DataTable().destroy();
      get_cso($this.value, $('#cso_type option:selected').val());
   }
   get_cso();
   $(document).on('click', 'a#view-cso', function(e) {
      window.open(base_url + '/user/cso/cso-information/' + $(this).data('id'), '_blank');
   });
   $(document).on('click', 'a#update-cso-status', function (e) {
      const id = $(this).data('id');
      const status = $(this).data('status');
      $('#update_cso_status_modal').modal('show');
      $('#cso_status_update option[value=' + status + ']').attr('selected', 'selected');
      $('input[name=cso_id]').val(id);
   });
   $('#update_cso_status_form').on('submit', function(e) {
      e.preventDefault();
      var btn = $('.btn-update-cso-status');
      $.ajax({
         type: "POST",
         url: base_url + '/user/act/cso/update-cso-status',
         data: new FormData(this),
         contentType: false,
         cache: false,
         processData: false,
         dataType: 'json',
         beforeSend: function() {
            btn.text('Please wait...');
            btn.attr('disabled', 'disabled');
         },
         headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
               },
         success: function(data) {
            if (data.response) {
               $('#update_cso_status_modal').modal('hide');
               btn.text('Save Changes');
               btn.removeAttr('disabled');
               toast_message_success(data.message);
               $('#cso_table').DataTable().destroy();
               get_cso();
            } else {
               btn.text('Save Changes');
               btn.removeAttr('disabled');
               toast_message_error(data.message);
            }
         },
         error: function(xhr) {
            alert("Error occured.please try again");
            btn.text('Save Changes');
            btn.removeAttr('disabled');
            location.reload();
         },
      });
   });
   $('#add_cso_form').on('submit', function(e) {
      e.preventDefault();
      var btn = $('.btn-add-cso');
      $.ajax({
         type: "POST",
         url: base_url + '/user/act/cso/add-cso',
         data: new FormData(this),
         contentType: false,
         cache: false,
         processData: false,
         dataType: 'json',
         beforeSend: function() {
            btn.text('Please wait...');
            btn.attr('disabled', 'disabled');
         },
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         success: function(data) {
            if (data.response) {
               $('#add_cso_form')[0].reset();
               btn.text('Submit');
               btn.removeAttr('disabled');
               toast_message_success(data.message);
               $('#cso_table').DataTable().destroy();
               get_cso();
            } else {
               btn.text('Submit');
               btn.removeAttr('disabled');
               toast_message_error(data.message);
            }
         },
         error: function(xhr) {
            alert("Error occured.please try again");
            btn.text('Submit');
            btn.removeAttr('disabled');
            location.reload();
         },
      });
   });
</script>
@endsection