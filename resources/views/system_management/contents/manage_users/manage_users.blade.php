@extends('system_management.layout.system_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('system_management.contents.manage_users.sections.table')
@endsection
@section('js')

<script>
   document.addEventListener("DOMContentLoaded", function() {
      table = $("#datatables").DataTable({
         responsive: true,
         ordering: false,
         processing: true,
         pageLength: 25,
         language: {
            "processing": '<div class="d-flex justify-content-center "> <img class="top-logo mt-4" src="{{asset("assets/img/dts/peso_logo.png")}}"></div>'
         },
         "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
         buttons: datatables_buttons(),
         ajax: {
            url: base_url + "/admin/sysm/act/g-a-u",
            method: 'GET',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            dataSrc: ""
         },
         columns: [{
            data: 'i'
         }, {
            data: null
         }, {
            data: 'username'
         }, {
            data: 'address'
         }, {
            data: 'email_address'
         }, {
            data: 'phone_number'
         }, {
            data: null
         }, {
            data: null
         }, ],
         columnDefs: [{
               targets: 1,
               data: null,
               render: function(data, type, row) {
                  return '<a href="' + base_url + '/admin/sysm/user/' + row.user_id + '" data-toggle="tooltip" data-placement="top" title="View ' + row.full_name + ' Information ">' + row.full_name + '</a>';
               }
            },
            {
               targets: -2,
               data: null,
               render: function(data, type, row) {
                  return row.status == 'active' ? '<span class="badge bg-success p-2">Active</span>' : '<span class="badge bg-danger p-2">Inactive</span>';
               }
            },
            {
               targets: -1,
               data: null,
               render: function(data, type, row) {
                  var button1 = row.status == 'active' ? '<li class="dropdown-item set-inactive"  data-id="' + row.user_id + '">Remove</li>' : '';;
                  var button2 = row.status != 'active' ? '<li class="dropdown-item delete"  data-id="' + row.user_id + '">Delete</li> <li class="dropdown-item set-active"  data-id="' + row.user_id + '">Set Active</li>' : '';
                  return ' <div class="btn-group dropstart">\
                        <i class="fa fa-ellipsis-v " class="dropdown-toggle" data-bs-toggle="dropdown"aria-expanded="false"></i>\
                        <ul class="dropdown-menu">' + button1 + ' ' + button2 + '</ul></div>';
               }
            }


         ],

      });
   });
   $(document).on('click', 'li.set-active', function() {
      var id = $(this).data('id');
      let data = {
         id: id,
         status: 'active'
      }
      var url = '/admin/sysm/act/c-u-s';
      update_item(data, url, table)
   });

   $(document).on('click', 'li.set-inactive', function() {
      var id = $(this).data('id');
      let data = {
         id: id,
         status: 'inactive'
      }
      var url = '/admin/sysm/act/c-u-s';
      update_item(data, url, table)
   });

   $(document).on('click', 'li.delete', function() {
      var id = $(this).data('id');
      var url = '/admin/sysm/act/delete-user';
      delete_item(id, url, button_text = '', text = '', table)
   });
</script>
@endsection