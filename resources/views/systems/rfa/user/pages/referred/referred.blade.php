@extends('systems.rfa.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="main-content-inner">
   <div class="row">
      <div class="col-12 mt-5">
         <div class="card" style="border: 1px solid;">
            <div class="card-body">

               <div class="row">
                  @include('systems.rfa.user.pages.referred.sections.table')
               </div>
            </div>
         </div>
      </div>
   </div>

</div>
@include('systems.rfa.user.pages.referred.modals.accomplished_modal')
@include('systems.rfa.user.pages.referred.modals.view_action_taken_modal')
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
<script type="text/javascript" src="{{ asset('pmas_rfa/tinymce/tinymce.js')}}"></script>
@include('systems.rfa.includes.custom_js.tinymce_init_js')

<script>


   $(document).on('click', 'button#reload_user_reffered_rfa', function (e) {
      $('#rfa_reffered_table').DataTable().destroy();
      load_user_reffered_rfa();
         count_total_reffered_rfa();
         count_total_rfa_pending();
   });

   function load_user_reffered_rfa() {
      $('#rfa_reffered_table').DataTable({
         responsive: false,
         "ordering": false,
         "ajax": {
            "url": base_url + '/user/act/rfa/g-u-r-r',
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
            data: "action1",
         },]
      });
   }
   $(document).ready(function () {
      load_user_reffered_rfa();
   });
   $(document).on('click', 'a#accomplished', function (e) {
      $('input[name=rfa_id]').val($(this).data('id'));
   });

   $(document).on('click', 'a#view_action_taken_admin', function (e) {
      $.ajax({
         type: "POST",
         url: base_url + '/user/act/rfa/view-action-taken',
         data: {
            id: $(this).data('id')
         },
         dataType: 'json',
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         beforeSend: function () {
            $('div#action_taken').addClass('.loader');
            loader();
         },
         success: function (data) {
            $('#view_action_taken_modal').modal('show');

            $('div#action_taken').find('p').html(data.action_taken);
            JsLoadingOverlay.hide();
         },
         error: function (xhr) {
            alert('Error! Can\'t Connect to Server');
            JsLoadingOverlay.hide();
         }
      })
   });


   $('#action_to_be_taken_form').on('submit', function (e) {
   e.preventDefault();
   var myContent = tinymce.get("action_to_be_taken").getContent();
   var button = $('.btn-refer');
   var id = $('input[name=rfa_id]').val();
   if (myContent == '') {
      alert('Please Fill up Action To Be Taken');
   } else {
      $.ajax({
         type: "POST",
         url: base_url + '/user/act/rfa/accomplish-rfa',
         data: {
            action_to_be_taken: myContent,
            rfa_id: id
         },
         dataType: 'json',
         beforeSend: function () {
            button.text('Please wait...');
            button.attr('disabled', 'disabled');
            loader();
         },
         headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
         success: function (data) {
            if (data.response) {
               button.text('Submit');
               button.removeAttr('disabled');
               $('#accomplished_modal').modal('hide');
               toast_message_success(data.message);
               $('#rfa_reffered_table').DataTable().destroy();
               load_user_reffered_rfa();
            } else {
               toast_message_success(data.message);
               button.text('Submit');
               button.removeAttr('disabled');
            }
            JsLoadingOverlay.hide();
         },
         error: function (xhr) {
            alert("Error occured.please try again");
            button.text('Submit');
            button.removeAttr('disabled');
            JsLoadingOverlay.hide();
         },
      });
   }
});


</script>
@endsection