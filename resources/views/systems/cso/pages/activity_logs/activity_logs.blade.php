@extends('systems.cso.layout.cso_master')
@section('title', $title)
@section('content')
<div class="row">
    <div class="col-12 mt-5">
        <div class="card" style="border: 1px solid;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('components.dts.filter_by_month')
                    </div>
                </div>
                <div class="row">
                    @include('systems.pmas.admin.pages.activity_logs.sections.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://jsuites.net/v4/jsuites.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
@include('global_includes.js.custom_js.datatable_settings')
@include('global_includes.js.custom_js.select_by_month')
<script>
    var search = function (month) {
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
                url: base_url + "/user/act/cso/logged-in-history" + add_to_url,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: "",
                error: function (xhr, textStatus, errorThrown) {
                    toast_message_error('Activity Logs is not displaying... Please Reload the Page Or Contact the developer')
                }
            },

            columns: [{
                data: 'number',
            },
            {
                data: 'name',
            },
            {
                data: 'user_type',
            },
            {
                data: 'action',
            },

            {
                data: 'action_datetime'
            },

            ],

        });

    };

    $(document).ready(function () {
        search(month);
    });

</script>
@endsection