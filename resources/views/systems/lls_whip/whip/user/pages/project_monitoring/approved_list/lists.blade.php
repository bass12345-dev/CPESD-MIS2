@extends('systems.lls_whip.whip.user.layout.user_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.whip.user.pages.project_monitoring.approved_list.sections.table')
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
                url: base_url + "/user/act/whip/g-m-a-p-m" + add_to_url,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: ""
            },
            columns: [
                {
                data: 'project_monitoring_id'
            },
                {
                    data: 'i'
                },
                {
                    data: 'code'
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
            'select': {
                'style': 'multi',
            },

            columnDefs: [
                {
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            },
                {
                    targets: 2,
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

    
    $('button#multi-delete').on('click', function () {
        var button_text = 'Delete selected items';
        var text = '';
        var url = '/user/act/whip/d-p-m';
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

</script>
@endsection