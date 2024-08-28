@extends('systems.dts.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')

<div class="row">
    <div class="col-md-12 col-12   ">
        @include('systems.dts.user.pages.action_logs.sections.table')
    </div>
</div>

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
            language: {
                "processing": '<div class="d-flex justify-content-center ">' + table_image_loader + '</div>'
            },
            "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: datatables_buttons(),
            ajax: {
                url: base_url + "/user/act/dts/action-logs"+ add_to_url,
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
                    data: 'action_datetime'
                },

            ],
            columnDefs: [{
                    targets: 1,
                    data: null,
                    render: function(data, type, row) {
                        return '<a href="' + base_url + '/user/dts/view?tn=' + row.tracking_number + '" data-toggle="tooltip" data-placement="top" title="View ' + row.tracking_number + ' ?>">' + row.action + '</a>';
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