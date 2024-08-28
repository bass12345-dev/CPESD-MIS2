@extends('systems.watchlisted.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.watchlisted.admin.pages.activity_logs.sections.table')
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
                url: base_url + "/admin/act/watchlisted/get-act-logs",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: ""
            },
            columns: [
                {
                    data: 'number'
                },
                {
                    data: 'name'
                }, {
                    data: null
                }, {
                    data: 'user_type'
                }, {
                    data: 'created'
                }, 
            ],
   
            columnDefs: [
   
                {
                    targets: 2,
                    data: null,
                    render: function (data, type, row) {
                        return '<a href="' + base_url + '/admin/watchlisted/view_profile/' + row.person_id + '" >' + row.action + '</a>';
                    }
                },

        



            ]
        });
    });

</script>

@endsection