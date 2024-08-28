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
                        @include('systems.rfa.user.pages.add.sections.table')
                        @include('systems.rfa.user.pages.add.sections.form')
                     </div>
                  </section>
               </div>
            </div>
         </div>
      </div>
      @include('systems.rfa.user.pages.add.modal.search_name_modal')
      @include('systems.rfa.user.pages.add.modal.add_client_modal')
      @include('systems.rfa.user.pages.add.modal.view_client_information_modal')
</body>
@include('global_includes.js.global_js')
@include('systems.rfa.includes.js')
@include('systems.rfa.includes.custom_js.layout_js')
@include('global_includes.js.custom_js.wizard_js')
@include('global_includes.js.custom_js.alert_loader')
<script>
   $(document).on('click', 'a#reload_all_transactions', function (e) {
      $('#request_table').DataTable().destroy();
      get_last_reference_number();
      rfa_transactions();
   });
   function rfa_transactions() {
      $('#request_table').DataTable({
         scrollY: 500,
         scrollX: true,
         "ordering": false,
         pageLength: 20,
         "ajax": {
            "url": base_url + '/user/act/rfa/g-p-t-l',
            "type": "GET",
            "dataSrc": "",
         },
         'columns': [{
            data: "ref_number",
         }, {
            data: "rfa_date_filed",
         }, {
            data: "name",
         },]
      })
   }

   function get_last_reference_number() {
      $.ajax({
         url: base_url + '/user/act/rfa/g-l-r-n',
         type: 'GET',
         dataType: 'text',
         success: function (result) {
            $('input[name=reference_number]').val(result);
         },
         error: function (xhr) {
            alert("Error occured.please try again");
            location.reload();
         },
      });
   }

   $('#add_rfa_form').on('submit', function (e) {
      e.preventDefault();
      if ($('input[name=client_id]').val() == '') {
         alert('Error');
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

               var button = $('.btn-add-rfa');
               $.ajax({
                  type: "POST",
                  url: base_url + '/user/act/rfa/add-rfa',
                  data: $('#add_rfa_form').serialize(),
                  dataType: 'json',
                  beforeSend: function () {
                     button.html('<div class="loader"></div>');
                     button.prop("disabled", true);
                  },
                  headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                  },
                  success: function (data) {
                     if (data.response) {
                        $('#add_rfa_form')[0].reset();
                        button.prop("disabled", false);
                        button.text('Submit');
                        toast_message_success(data.message)
                        $('a.form-wizard-previous-btn').click();
                        $('#request_table').DataTable().destroy();
                        rfa_transactions();
                     } else {
                        button.prop("disabled", false);
                        button.text('Submit');
                        toast_message_error(data.message)
                        $('a.form-wizard-previous-btn').click();
                     }
                     get_last_reference_number();
                  },
                  error: function (xhr) {
                     alert("Error occured.please try again");
                     button.prop("disabled", false);
                     button.text('Submit');
                     location.reload();
                  },
               })
            } else if (result.dismiss === "cancel") {
               swal.close()
            }
         });
      }
   });


   $(document).ready(function () {
      rfa_transactions();
      get_last_reference_number();
   });


</script>
@include('systems.rfa.user.includes.custom_js.add_update_js')
</html>