<!doctype html>
<html class="no-js" lang="en">

<head>
   @include('global_includes.meta')
   @include('systems.rfa.includes.css')
</head>

<body>
   @include('components.pmas_rfa.preloader')
   <div class="page-container sbar_collapsed">
      <div class="main-content">
         @include('systems.rfa.includes.components.add_rfa_topbar')
         <div class="main-content-inner">
            <div class="row">
               <div class="col-12 mt-3">
                  <section class="wizard-section" style="background-color: #fff;">
                     <div class="row no-gutters">
                        @include('systems.pmas.user.pages.add.sections.table')
                        @include('systems.pmas.user.pages.add.sections.form')
                     </div>
                  </section>
               </div>
            </div>
         </div>
      </div>
      @include('systems.pmas.user.pages.add.modals.select_under_type_of_activity_modal')
</body>
@include('global_includes.js.global_js')
@include('systems.rfa.includes.js')
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
@include('systems.rfa.includes.custom_js.layout_js')
@include('global_includes.js.custom_js.wizard_js')
@include('global_includes.js.custom_js.alert_loader')

<script>

   
  
   function get_last_pmas_number() {
      $.ajax({
         url: base_url + '/user/act/pmas/get-last-pmas-number',
         type: 'GET',
         dataType: 'text',
         success: function (result) {
            $('input[name=pmas_number]').val(result);
         }
      });
   }

   function list_all_transactions() {
      $.ajax({
         url: base_url + '/user/act/pmas/get-pending-transaction-limit',
         type: "GET",
         dataType: "json",
         success: function (data) {
            $('#new_transactions_table').DataTable({
               scrollY: 500,
               scrollX: true,
               "ordering": false,
               pageLength: 20,
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
               }, {
                  extend: 'print',
                  text: 'print',
                  className: 'btn btn-default',
               },],
               'columns': [{
                  data: null,
                  render: function (data, type, row) {
                     return '<b><a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['pmas_no'] + '</a></b>';
                  }
               }, {
                  data: null,
                  render: function (data, type, row) {
                     return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['date_and_time_filed'] + '</a>';
                  }
               }, {
                  data: null,
                  render: function (data, type, row) {
                     return '<b><a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['type_of_activity'] + '</a></b>';
                  }
               }, {
                  data: null,
                  render: function (data, type, row) {
                     return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['name'] + '</a>';
                  }
               },]
            })
         }
      })
   }

  

   


   $('#add_transaction_form').on('submit', function (e) {
      e.preventDefault();
      var button = $('.btn-add-transaction');
      if ($('input[name=pmas_number]').val() == '') {
         alert('Pmas Number Is Empty! PLease Reload the Page or click the reload button');
      } else {
         Swal.fire({
            title: "",
            text: "Review first before submitting",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
         }).then(function (result) {
            if (result.value) {
               $.ajax({
                  type: "POST",
                  url: base_url + '/user/act/pmas/add-transaction',
                  data: $('#add_transaction_form').serialize(),
                  dataType: 'json',
                  beforeSend: function () {
                     button.html('<div class="loader"></div>');
                     button.prop("disabled", true);
                     loader();
                  },
                  headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                  },
                  success: function (data) {
                     if (data.response) {
                        $('#add_transaction_form')[0].reset();
                        $('select[name=responsibility_center_id]').select2("val", '0');
                        $('select[name=cso_id]').select2("val", '0');
                        $('input[name=date_time]').val('');
                        button.prop("disabled", false);
                        button.text('Submit');
                        toast_message_success(data.message);
                        $('a.form-wizard-previous-btn').click();
                        JsLoadingOverlay.hide();
                     } else {
                        button.prop("disabled", false);
                        button.text('Submit');
                        toast_message_error(data.message);
                        $('a.form-wizard-previous-btn').click();
                     }
                     $('#new_transactions_table').DataTable().destroy();
                     list_all_transactions();
                     get_last_pmas_number();
                  },
                  error: function (xhr) {
                     alert("Error occured.please try again");
                     button.prop("disabled", false);
                     button.text('Submit');
                     JsLoadingOverlay.hide();
                  },
               })
            } else if (result.dismiss === "cancel") {
               swal.close()
            }
         });
      }
   });


   $(document).on('click', 'a#reload_all_transactions', function (e) {
      $('#new_transactions_table').DataTable().destroy();
      get_last_pmas_number();
      list_all_transactions();
   });


   $(document).ready(function () {
      get_last_pmas_number();
      list_all_transactions();
   });


</script>
@include('systems.pmas.includes.custom_js.add_update_js')
</html>