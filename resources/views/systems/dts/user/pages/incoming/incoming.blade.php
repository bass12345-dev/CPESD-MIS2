@extends('systems.dts.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')

<div class="row">
   <div class="col-md-12 col-12   ">
      @include('systems.dts.user.pages.incoming.sections.table')
   </div>
</div>

@endsection
@section('js')

<script>
   document.addEventListener("DOMContentLoaded", function() {
      table = $("#datatable_with_select").DataTable({
         responsive: true,
         ordering: false,
         processing: true,
         pageLength: 25,
         language: {
            "processing": '<div class="d-flex justify-content-center "> ' + table_image_loader + '</div>'
         },
         "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
         buttons: datatables_buttons(),
         ajax: {
            url: base_url + "/user/act/dts/incoming-documents",
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
            data: 'his+tn',
         }, {
            data: 'number'
         }, {
            data: 'tracking_number'
         }, {
            data: null
         }, {
            data: 'from'
         }, {
            data: 'type_name'
         }, {
            data: 'remarks'
         }, {
            data: 'released_date'
         }, ],
         'select': {
            'style': 'multi',
         },
         columnDefs: [{
            'targets': 0,
            'checkboxes': {
               'selectRow': true
            },
         }, {
            targets: 3,
            data: null,
            render: function(data, type, row) {
               return view_document(row);
            }
         }]
      });
   });

   $('a#received_documents').on('click', function() {
      selected_items = get_select_items_datatable();
      if (selected_items.length == 0) {
         toast_message_error('Please Select at least one')
      } else {
         var url = '/user/act/dts/receive-documents';
         let form = {
            items: selected_items
         };
         delete_item(form, url, button_text = 'Receive Document', text = '',table);
      }
   });
</script>

@endsection