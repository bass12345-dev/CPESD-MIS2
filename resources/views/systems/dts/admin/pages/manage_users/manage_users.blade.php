@extends('systems.dts.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
<div class="row">
   <div class="col-md-12">
        @include('systems.dts.admin.pages.manage_users.sections.table')
   </div>
</div>

@endsection
@section('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
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
                url: base_url + "/admin/act/dts/all-users",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: ""
            },
            columns: [
                {
                    data: 'number',
                },
                {
                    data: 'name',
                },
                {
                    data: 'username'
                },
                {
                    data: 'address'
                },
                {
                    data: 'email_address'
                },
                {
                    data: 'contact_number'
                },
                {
                    data: null
                },
                {
                    data: null
                },
            ],
            columnDefs: [
              
                {
                    targets: -2,
                    data: null,
                    render: function (data, type, row) {
                        return row.user_status == 'active' ? '<span class="badge bg-success p-2">Active</span>' : '<span class="badge bg-danger p-2">Inactive</span>';
                    }
                },
                {
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        var button1 = row.user_status == 'active' ? '<li class="dropdown-item set-inactive"  data-id="'+row.user_id+'">Remove</li>' : '';;
                        var button2 = row.user_status == 'active' ? '<li class="dropdown-item delete"  data-id="'+row.user_id+'">Delete</li> <li class="dropdown-item set-active"  data-id="'+row.user_id+'">Set Active</li>' : '';
                        return '<div class="btn-group dropstart">\
                           <i class="fa fa-ellipsis-v " class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></i>\
                           <ul class="dropdown-menu">\
                              '+button1+'\
                              '+button2+'\
                           </ul>\
                        </div>';
                    }
                }
            ],

        });
    });

</script>
@endsection