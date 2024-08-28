@extends('systems.watchlisted.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.watchlisted.user.pages.approved.sections.table')
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
                "processing": '<div class="d-flex justify-content-center ">' + table_image_loader + '</div>'
            },
            "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: datatables_buttons(),
            ajax: {
                url: base_url + "/user/act/watchlisted/g-r-w",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: ""
            },
            columns: [{
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
            }],
            columnDefs: [{
                targets: 1,
                data: null,
                render: function(data, type, row) {
                    return '<a href="' + base_url + '/user/watchlisted/view_profile?id=' + row.person_id + '" >' + row.name + '</a>';
                }
            }, ]
        });
    });
</script>
@endsection