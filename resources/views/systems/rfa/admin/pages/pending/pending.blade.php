@extends('systems.rfa.admin.layout.admin_master')
@section('title', $title)
@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card" style="border: 1px solid;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <button class="btn  mb-3 mt-2 sub-button pull-right mr-2" id="reload_admin_pending_rfa">
                                Reload <i class="ti-loop"></i></button>
                        </div>
                    </div>
                    <div class="row">

                        @include('systems.rfa.admin.pages.pending.sections.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('systems.rfa.admin.pages.pending.modals.refer_to_modal')
@include('systems.rfa.admin.pages.pending.modals.view_action_taken_modal')
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
<script type="text/javascript" src="{{ asset('pmas_rfa/tinymce/tinymce.js')}}"></script>
@include('systems.rfa.includes.custom_js.tinymce_init_js')

<script>

function load_admin_pending_rfa() {
   $('#rfa_pending_table').DataTable({
      responsive: false,
      "ordering": false,
      "ajax": {
         "url": base_url + '/admin/act/rfa/get-admin-pending-rfa',
         "type": "GET",
         "dataSrc": "",
      },
      'columns': [{
         data: "ref_number",
      }, {
         data: "name",
      }, {
         data: "address",
      }, {
         data: "type_of_request_name",
      }, {
         data: "type_of_transaction",
      }, {
         data: "status1",
      }, {
         data: "encoded_by",
      }, {
         data: "action1",
      }, ]
   });
}
load_admin_pending_rfa();
$(document).on('click', 'a#view_rfa_', function (e) {
      window.open(base_url + '/admin/rfa/view-rfa/' + $(this).data('id'), '_self');
   });
$(document).on('click', 'button#reload_admin_pending_rfa', function (e) {
   $('#rfa_pending_table').DataTable().destroy();
   load_admin_pending_rfa();
   count_total_rfa_pending();
});
$(document).on('click', 'a#refer_to', function (e) {
   $('input[name=rfa_id]').val($(this).data('id'));
});

$('#update_refer_form').on('submit', function (e) {
   e.preventDefault();
   var myContent = tinymce.get("action_to_be_taken").getContent();
   var id = $('input[name=rfa_id]').val();
   var refer_to = $('#refer_to_id :selected').val();
   var name = $('#refer_to_id :selected').text();
   var btn = $('.btn-refer');
   Swal.fire({
      title: "",
      text: "Refer to " + name,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "No, cancel!",
      reverseButtons: true
   }).then(function (result) {
      if (result.value) {
         $.ajax({
            type: "POST",
            url: base_url + '/admin/act/rfa/refer-to',
            data: {
               action_taken: myContent,
               rfa_id: id,
               reffered_to: refer_to
            },
            dataType: 'json',
            beforeSend: function () {
               btn.text('Please wait...');
               btn.attr('disabled', 'disabled');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
               if (data.response) {
                  btn.text('Submit');
                  btn.removeAttr('disabled');
                  $('#refer_to_modal').modal('hide');
                  toast_message_success(data.message);
                  $('#rfa_pending_table').DataTable().destroy();
                  load_admin_pending_rfa();
               } else {
                  toast_message_error(data.message);
                  btn.text('Submit');
                  btn.removeAttr('disabled');
               }
            },
            error: function (xhr) {
               alert("Error occured.please try again");
               btn.text('Submit');
               btn.removeAttr('disabled');
            },
         });
      }
   });
});


$(document).on('click', 'a#view_action', function (e) {
   $.ajax({
      type: "POST",
      url: base_url + '/admin/act/rfa/view-action',
      data: {
         id: $(this).data('id')
      },
      dataType: 'json',
      beforeSend: function () {
         $('div#action_to_be_taken').addClass('.loader');
      },
      headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
      success: function (data) {
         $("#view_action_to_be_taken_modal").modal('show');
         $('div#action_to_be_taken').find('p').html(data.action_to_be_taken);
      },
      error: function (xhr) {
         alert("Error occured.please try again");
         location.reload();
      },
   })
});


$(document).on('click', 'a#approved', function (e) {
   var id = $(this).data('id');
   var name = $(this).data('name');
   Swal.fire({
      title: "",
      text: "Approved RFA Reference No. " + name,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "No, cancel!",
      reverseButtons: true
   }).then(function (result) {
      if (result.value) {
         $.ajax({
            type: "POST",
            url: base_url + '/admin/act/rfa/approved-rfa',
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
               });
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
               if (data.response) {
                  Swal.fire("", "Success", "success");
                  $('#rfa_pending_table').DataTable().destroy();
                  load_admin_pending_rfa();
                  // count_total_rfa_pending();
               } else {
                  Swal.fire("", data.message, "error");
               }
            },
            error: function (xhr) {
               alert("Error occured.please try again");
               location.reload();
            },
         })
      } else if (result.dismiss === "cancel") {
         swal.close()
      }
   });
});
    

</script>
@endsection