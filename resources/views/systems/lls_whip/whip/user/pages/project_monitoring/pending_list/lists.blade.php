@extends('systems.lls_whip.whip.user.layout.user_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.whip.user.pages.project_monitoring.pending_list.sections.table')
@include('systems.lls_whip.whip.admin.pages.project_monitoring.pending_list.modals.chat_message')
@endsection
@section('js')

<script>

    $(document).ready(function () {
        table = $('#data-table-basic').DataTable({
            responsive: true,
            ordering: false,
            processing: true,
            searchDelay: 500,
            pageLength: 25,
            language: {
                "processing": '<div class="d-flex justify-content-center "><img class="top-logo mt-4" src="{{asset("assets/img/dts/peso_logo.png")}}"></div>'
            },
            "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: datatables_buttons(),
            ajax: {
                url: base_url + "/user/act/whip/g-u-p-m",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: ""
            },
            columns: [{
                data: 'project_monitoring_id'
            },
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
            {
                data: 'monitoring_status'
            },
            {
                data: null
            },

            ],
            'select': {
                'style': 'multi',
            },
            columnDefs: [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            },
            {
                targets: 2,
                data: null,
                render: function (data, type, row) {
                    return '<a href="' + base_url + '/user/whip/project-monitoring-info/' + row.project_monitoring_id + '" data-toggle="tooltip" data-placement="top" title="View ' + row.project_title + '">' + row.project_title + '</a>';
                }
            },
            {
                    targets: -2,
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<a href="#" data-toggle="modal" data-target="#chat_modal" data-id="' + row.project_monitoring_id + '" style="font-size: 25px; " class="message"><i class="fas fa-message"></i></a>';
                    }
                },
            {
                targets: -1,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return row.monitoring_status == 'pending' ?
                        '<span class="badge notika-bg-danger">Pending</span>' :
                        '<span class="badge notika-bg-success">Completed</span>';
                }
            }
            ]

        });
    });
    
    // <span class="badge" style="margin-bottom: 28px;background-color: red;">'+row.count_unseen+'</span>

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
@include('systems.lls_whip.includes.custom_js.remarks_js')
@endsection