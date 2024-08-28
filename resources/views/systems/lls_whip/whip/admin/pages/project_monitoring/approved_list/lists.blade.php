@extends('systems.lls_whip.whip.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.whip.admin.pages.project_monitoring.approved_list.sections.table')
@endsection
@section('js')
@include('global_includes.js.custom_js.select_by_month')
<script>
    var search = function (month) {
        var add_to_url = '';
        if (month != null) {
            add_to_url = '?date=' + month
        }

        table = $("#data-table-basic").DataTable({
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
                url: base_url + "/admin/act/whip/g-a-p-m" + add_to_url,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: ""
            },
            columns: [
                {
                    data: 'i'
                },
                {
                    data: 'project_title'
                },
                {
                    data: 'contractor'
                },
                {
                    data: 'address'
                },
                {
                    data: 'date_of_monitoring'
                },
                {
                    data: 'specific_activity'
                },

                {
                    data: 'person_responsible'
                },
                

            ],

            columnDefs: [
                {
                    targets: 1,
                    data: null,
                    render: function(data, type, row) {
                        return '<a href="' + base_url + '/user/whip/project-monitoring-info/' + row.project_monitoring_id + '" data-toggle="tooltip" data-placement="top" title="View ' + row.project_title + '">' + row.project_title + '</a>';
                    }
                },
            ]


        });

    };

    $(document).ready(function () {
        search(month);
    });
</script>

@endsection