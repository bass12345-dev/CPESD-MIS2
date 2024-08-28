@extends('systems.dts.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')

<div class="row">
   <div class="col-md-12 col-12   ">
      @include('systems.dts.user.pages.forwarded.sections.table')
   </div>
</div>
@include('systems.dts.user.pages.forwarded.modals.remarks_update_modal')
@include('systems.dts.user.pages.forwarded.offcanvas.forward_offcanvas')
@endsection
@section('js')
<script>
   document.addEventListener("DOMContentLoaded", function() {
      table = $("#datatables-buttons").DataTable({
         responsive: true,
         ordering: false,
         processing: true,
         pageLength: 25,
         language: {
            "processing": '<div class="d-flex justify-content-center ">' + table_image_loader + '</div>'
         },
         "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
         buttons: datatables_buttons(),
         ajax: {
            url: base_url + "/user/act/dts/forwarded-documents",
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
         }, {
            data: 'tracking_number'
         }, {
            data: null
         }, {
            data: 'forwarded_to'
         }, {
            data: 'type_name'
         }, {
            data: null
         }, {
            data: 'released_date'
         }, {
            data: null
         }, ],

         columnDefs: [{
               targets: 2,
               data: null,
               render: function(data, type, row) {
                  return view_document(row);
               }
            },
            {
               targets: 5,
               data: null,
               render: function(data, type, row) {
                  var remarks = row.remarks == null ? '<span class="text-danger">no remarks</span>' : row.remarks;
                  return remarks + '<br><a href="javascript:;" id="update_remarks" class="text-success" data-document-id="' + row.document_id + '" data-history-id="' + row.history_id + '" data-remarks="' + row.remarks + '" data-tracking-number="' + row.tracking_number + '" >Update Remarks</a>';
               }
            },

            {
               targets: -1,
               data: null,
               render: function(data, type, row) {
                  return '<div class="btn-group dropstart">\
                             <i class="fa fa-ellipsis-v " class="dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false"></i>\
                             <ul class="dropdown-menu">\
                                  <li><a class="dropdown-item " id="forward_icon"  data-remarks="' + row.remarks + '" data-history-id="' + row.history_id + '" data-tracking-number="' + row.tracking_number + '"  href="javascript:;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" >Update Forward To</a></li>\
                                 \
                                </ul>\
                           </div>';
               }
            }

         ]
      });
   });



   $(document).on('click', 'a#update_remarks', function() {
      $('#update_remarks_modal').find('.modal-title').text('Update Remarks Document #' + $(this).data('tracking-number'));

      $('input[name=history_id]').val($(this).data('history-id'));
      $('input[name=remarks_document_id]').val($(this).data('document-id'));
      $('textarea[name=remarks_update]').val($(this).data('remarks'));
      $('#update_remarks_modal').modal('show');
   });


   $('#update_remarks_form').on('submit', function(e) {
      e.preventDefault();
      $(this).find('button').prop('disabled', true);
      $(this).find('button').html('<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>');
      var url = '/user/act/dts/update-remarks';
      let form = $(this);
      _insertAjax(url, form, table);
      $('#update_remarks_modal').modal('hide');
      $('#update_remarks_form')[0].reset();
   });


   $(document).on('click', 'a#forward_icon', function() {
      $('input[name=history_id]').val($(this).data('history-id'));
      $('input[name=tracking_number]').val($(this).data('tracking-number'));
      $('textarea[name=remarks]').val($(this).data('remarks'));

      $('.offcanvas-title').text('Forward Document #' + $(this).data('tracking-number'));
   });


   $('#forward_form').on('submit', function(e) {
      e.preventDefault();
      var url = '/dts/us/u-f-d';
      var form = $(this).serialize();



      Swal.fire({
         title: "Are you sure?",
         text: "",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Foward Document"
      }).then((result) => {
         if (result.isConfirmed) {
            $(this).find('button').prop('disabled', true);
            $(this).find('button').html('<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>');
            var url = '/user/act/dts/update-forwarded';
            let form = $(this);
            _insertAjax(url, form, table);
            $('select[name=forward]').val('');
            let closeCanvas = document.querySelector('[data-bs-dismiss="offcanvas"]');
            closeCanvas.click();

         }
      });



   });
</script>

@endsection