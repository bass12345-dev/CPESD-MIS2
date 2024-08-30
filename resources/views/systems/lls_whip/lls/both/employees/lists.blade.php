@extends('systems.lls_whip.lls.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            @include('systems.lls_whip.both.employees.table')
        </div>
    </div>
</div>
@include('systems.lls_whip.both.employees.modals.add_employee_modal')
@endsection
@section('js')
@include('systems.lls_whip.includes.custom_js.location_js')
<script>
    
   
    $(document).ready(function () {
        table = $('#data-table-basic').DataTable({
            responsive: true,
            ordering: false,
            processing: true,
            searchDelay: 500,
            pageLength: 25,
            language: datatables_loader(),
            "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: datatables_buttons(),
            ajax: {
                url: base_url + "/user/act/g-a-em",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: ""
            },
            columns: [
                {
                    data: 'employee_id'
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: 'full_address'
                },
                {
                    data: 'birthdate'
                },
                {
                    data: 'contact_number'
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
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return capitalizeFirstLetter(row.gender);

                }
            },

            {
                targets: 1,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return '<a href="' + base_url + '/<?php echo session('user_type') ?>/whip/employee/' + row.employee_id + '">' + row.full_name + '</a>';

                }
            },





            ]

        });
    });


    $('#add_employee_form').on('submit', function (e) {
        e.preventDefault();
        $(this).find('button').prop('disabled', true);
        $(this).find('button').html('<span class="loader"></span>')
        var url = '/user/act/i-e';
        let form = $(this);
        _insertAjax(url, form, table);
    });

    $('button#multi-delete').on('click', function () {

        var button_text = 'Delete selected items';
        var text = '';
        var url = '/user/act/d-em';
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