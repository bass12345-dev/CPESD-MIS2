@extends('systems.watchlisted.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.watchlisted.admin.pages.removed.sections.table')
@endsection
@section('js')
<script>
   document.addEventListener("DOMContentLoaded", function () {
      table = $("#datatable_with_select").DataTable({
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
            url: base_url + "/admin/act/watchlisted/r-f-w",
            method: 'GET',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            dataSrc: ""
         },
         columns: [
            {
               data: 'person_id'
            },
            {
               data: 'number'
            }, {
               data: null
            }, {
               data: 'age'
            }, {
               data: 'address'
            }, {
               data: 'email'
            }, {
               data: 'phone_number'
            }
         ],
         'select': {
            'style': 'multi',
         },
         columnDefs: [
            {
               'targets': 0,
               'checkboxes': {
                  'selectRow': true
               },
            },
            {
               targets: 2,
               data: null,
               render: function (data, type, row) {
                  return '<a href="' + base_url + '/watchlisted/admin/view_profile?id=' + row.person_id + '" >' + row.name + '</a>';
               }
            },



         ]
      });
   });


   $(document).on('click', 'button#delete', function () {
      var button_text = 'Delete selected items';
      var text = '';
      var url = '/user/act/watchlisted/d-p';
      let items = get_select_items_datatable();
      var data = {
         id: items,
      };

      if (items.length == 0) {
         toast_message_error('Please Select at Least One')
      } else {
         delete_item(data, url, button_text, text, table);
      }
   });

   $('button#restore').on('click', function () {

      var button_text = 'Submit';
      text = 'Selected individuals will be back to active list';
      var url = '/admin/act/watchlisted/c-s';
      let items = get_select_items_datatable();
      var button_text = 'Submit';
      var data = {
         id: items,
         status: 'active'
      };

      if (items.length == 0) {
         toast_message_error('Please Select at Least One')
      } else {
         delete_item(data, url, button_text, text, table);
      }


   });
</script>
@endsection