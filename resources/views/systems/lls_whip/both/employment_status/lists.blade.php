@extends('systems.lls_whip.whip.' . session('user_type') . '.layout.' . session('user_type') . '_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                @include('systems.lls_whip.both.employment_status.sections.table')
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                @include('systems.lls_whip.both.employment_status.sections.add_update_position')
            </div>
        </div>
    </div>
</div>
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
                url: base_url + "/admin/act/a-e-s",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: ""
            },
            columns: [
                {
                    data: 'employ_stat_id'
                },
                {
                    data: 'status'
                },
                {
                    data: 'created'
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
                targets: -1,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    //return '<button class="btn btn-success">Update</button> <button class="btn btn-success">Delete</button>';
                    return '<div class="actions">\
                                <div ><button class="btn btn-success update-status" \
                                data-id="'+ row.employ_stat_id + '"\
                                data-name="'+ row.status + '"\
                                ><i class="fas fa-pen"></i></button> </div>\
                                </div>\
                                ';
                }
            }
            ]

        });
    });

    $(document).on('click', 'button.update-status', function () {
        $('#add_update_form').find('input[name=status_id]').val($(this).data('id'));
        $('#add_update_form').find('input[name=status]').val($(this).data('name'));
    })

    $('button#multi-delete').on('click', function () {

        var button_text = 'Delete selected items';
        var text = '';
        var url = '/admin/act/d-s';
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

    $('#add_update_form').on('submit', function (e) {
        e.preventDefault();
        $(this).find('button').prop('disabled', true);
        $(this).find('button').html('<span class="loader"></span>')
        var url = '/admin/act/i-u-e-s';
        let form = $(this);
        if (!$('form#add_update_form').find('input[name=status_id]').val()) {
            _insertAjax(url, form, table);
        } else {
            _updatetAjax(url, form, table);
        }
    });
</script>
@endsection