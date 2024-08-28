@extends('systems.lls_whip.whip.' . session('user_type') . '.layout.' . session('user_type') . '_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.whip.both.contractors.lists.sections.table')
@endsection
@section('js')
<script>
    $(document).ready(function () {
        table = $('#data-table-basic').DataTable({
            responsive: true,
            ordering: false,
            processing: true,
            searchDelay: 500,
            pageLength: 10,
            language: {
                "processing": '<div class="d-flex justify-content-center "><img class="top-logo mt-4" src="{{asset("assets/img/dts/peso_logo.png")}}"></div>'
            },
            "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: datatables_buttons(),
            ajax: {
                url: base_url + "/user/act/whip/g-a-c",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: ""
            },
            columns: [{
                data: 'contractor_id'
            },
            {
                data: 'contractor_name'
            },
            
            {
                data: 'proprietor'
            },
            {
                data: 'full_address'
            },
            {
                data: 'phone_number'
            }, {
                data: 'phone_number_owner'
            }, {
                data: 'telephone_number'
            }, {
                data: 'email_address'
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
                targets: 1,
                data: null,
                render: function (data, type, row) {
                    return '<a href="' + base_url + '/{{session("user_type")}}/whip/contractor-information/' + row.contractor_id + '" data-toggle="tooltip" data-placement="top" title="View ' + row.contractor_name + '">' + row.contractor_name + '</a>';
                }
            },
            {
                targets: -1,
                data: null,
                render: function (data, type, row) {
                    return row.status == 'active' ? '<span class="badge notika-bg-success">Active</span>' : '<span class="badge notika-bg-danger">InActive</span>';
                }
            }
            ]

        });
    });



    $('button#multi-delete').on('click', function () {
        var button_text = 'Delete selected items';
        var text = '';
        var url = '/user/act/whip/d-c';
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