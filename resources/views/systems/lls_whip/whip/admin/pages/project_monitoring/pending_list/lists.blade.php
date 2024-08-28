@extends('systems.lls_whip.whip.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.whip.admin.pages.project_monitoring.pending_list.sections.table')
@include('systems.lls_whip.whip.admin.pages.project_monitoring.pending_list.modals.chat_message')
@endsection
@section('js')
@include('systems.lls_whip.includes.custom_js.nature_js')

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
                url: base_url + "/admin/act/whip/g-p-p-m",
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
                data: 'monitoring_status'
            },
            {
                data: null
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
                targets: -3,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return row.monitoring_status == 'pending' ?
                        '<span class="badge notika-bg-danger">Pending</span>' :
                        '<span class="badge notika-bg-success">Completed</span>';
                }
            },
            {
                targets: -2,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return '<a href="#"   data-toggle="modal" data-target="#chat_modal" data-id="' + row.project_monitoring_id + '" style="font-size: 25px; " class="message"><i class="fas fa-message"></i></a>';
                }
            },
            {
                targets: -1,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return '<button class="btn btn-success approved" data-id="' + row.project_monitoring_id + '" ><i class="fas fa-check"></i></button>';
                }
            }
            ]

        });
    });

    function reload() {
        table.ajax.reload();
    }

    $(document).on('click', 'button.approved', function () {

        Swal.fire({
            title: "Are you sure?",
            text: '',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Approved!",
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: base_url + '/admin/act/whip/a-m',
                    method: 'POST',
                    data: {
                        id: $(this).data('id')
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        if (data.response) {
                            toast_message_success(data.message);
                            table.ajax.reload();
                        } else {
                            toast_message_error(data.message);
                        }
                    },
                    error: function (err) {
                        if (err.status == 422) { // when status code is 422, it's a validation issue
                            toast_message_error('Something Wrong');
                        }
                    }


                });
            }
        });


    });


    $('button#multi-delete1').on('click', function () {
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