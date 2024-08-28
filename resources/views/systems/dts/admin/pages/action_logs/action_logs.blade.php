@extends('systems.dts.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.dts.admin.pages.action_logs.sections.table')
@endsection
@section('js')
@include('global_includes.js.custom_js.select_by_month')
<script>
    var search = function(month) {
        var add_to_url = '';
        if (month != null) {
            add_to_url = '?date=' + month
        }

        table = $("#datatables-buttons").DataTable({
            responsive: true,
            ordering: false,
            processing: true,
            pageLength: 25,
            destroy: true,
            language: {
                "processing": '<div class="d-flex justify-content-center ">' + table_image_loader + '</div>'
            },
            "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: datatables_buttons(),
            ajax: {
                url: base_url + "/admin/act/dts/action-logs" + add_to_url,
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
                    data: 'name',
                },
                {
                    data: null,
                },
                {
                    data: null
                },
                {
                    data: 'action_datetime'
                },

            ],
            columnDefs: [{
                    targets: 2,
                    data: null,
                    render: function(data, type, row) {
                        return '<a href="' + base_url + '/dts/user/view?tn=' + row.tracking_number + '" data-toggle="tooltip" data-placement="top" title="View ' + row.tracking_number + ' ?>">' + row.action + '</a>';
                    }
                },
                {
                    targets: -2,
                    data: null,
                    render: function(data, type, row) {
                        return '<span class="badge bg-primary" style="font-size: 12px;">' + row.user_type + '</span>';
                    }
                },



            ]

        });

    };

    $(document).ready(function() {
        search(month);
    });
</script>
@endsection