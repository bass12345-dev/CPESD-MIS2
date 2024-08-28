@extends('systems.dts.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
<div class="row">
   <div class="col-12  col-md-7 ">
      @include('systems.dts.user.pages.add_document.sections.document_table')
   </div>
   <div class="col-12 col-md-5">
      @include('systems.dts.user.pages.add_document.sections.form')
   </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
   document.addEventListener("DOMContentLoaded", function() {
      table = $("#datatables-buttons").DataTable({
         responsive: true,
         ordering: false,
         processing: true,
         pageLength: 25,
         language: {
            "processing": '<div class="d-flex justify-content-center "> '+table_image_loader+'</div>'
         },


         ajax: {
            url: base_url + "/user/act/dts/g-l-d",
            method: 'GET',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            dataSrc: "",
            error: function (xhr, textStatus, errorThrown) {
                    toast_message_error('Documents is not displaying... Please Reload the Page Or Contact the developer')
               }
         },
         columns: [{
               data: 'number',
            },
            {
               data: null,
            },
            {
               data: 'name',
            },
            {
               data: 'document_number',
            },
         ],
         columnDefs: [{
               targets: 1,
               data: null,
               render: function(data, type, row) {
                  return view_document(row);
               }
            },



         ]

      });
   });


   $('#add_document').on('submit', function(e) {
      e.preventDefault();
      var url = "/user/act/dts/i-d";
      var form = $(this).serialize();


      Swal.fire({
         title: "Review First Before Submitting",
         text: "",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Submit"
      }).then((result) => {
         if (result.isConfirmed) {

            $.ajax({
               url: base_url + url,
               method: 'POST',
               data: form,
               dataType: 'json',
               beforeSend: function() {
                  $('#add_document').find('button').attr('disabled', true);
                  loader();
               },
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
               },
               success: function(data) {
                  JsLoadingOverlay.hide();
                  if (data.response) {

                     Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                     });
                     table.ajax.reload();
                     $('#add_document')[0].reset();
                     tracking_number();
                  } else {

                     alert(data.message + '! Please Click Submit Button Again');
                     tracking_number();
                  }
                  $('#add_document').find('button').attr('disabled', false);
                 
            

               },
               error: function() {
                  alert('something Wrong');
                  // location.reload();
                  JsLoadingOverlay.hide();
               }

            });


         }
      });


   });


   function tracking_number() {
      var url = "/user/act/dts/g-t-n";
      $.ajax({
         url: base_url + url,
         method: 'GET',
         dataType: 'text',
         beforeSend: function() {
            loader();
         },
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         },
         success: function(data) {
            JsLoadingOverlay.hide();
            if (data) {
               $('input[name=tracking_number]').val(data);
            } else {
               alert('Failed to load Tracking Number Please Contact the Develope');
               setTimeout(reload_page, 2000)
            }
         },
         error: function() {
            alert('Failed to load Tracking Number Please Contact the Developer');
            // location.reload();
            JsLoadingOverlay.hide();
         }

      });

   }

   $(document).ready(function() {
      tracking_number();
   })
</script>
@endsection