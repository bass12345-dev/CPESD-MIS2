@extends('systems.watchlisted.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
<div class="row">
    <div class="col-md-7">
        @include('systems.watchlisted.admin.pages.manage_program.sections.table')
    </div>
    <div class="col-md-5">
        @include('systems.watchlisted.admin.pages.manage_program.sections.form')
    </div>
</div>
@endsection
@section('js')
<script>

    document.addEventListener("DOMContentLoaded", function () {
        table = $("#datatable_with_select").DataTable({
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
                url: base_url + "/admin/act/watchlisted/get-programs",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: ""
            },
            columns: [
                {
                    data: 'program_id'
                },
                {
                    data: 'program'
                }, {
                    data: 'program_description'
                }, {
                    data: 'created'
                }, {
                    data: null
                }
            ],
            'select': {
                'style': 'multi',
            },
            columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    },
                },
                {
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {

                        return '<div class="btn-group dropstart">\
                                <i class="fa fa-ellipsis-v " class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></i>\
                                <ul class="dropdown-menu">\
                                    <li><a class="dropdown-item" id="update" href="javascript:;" data-id="' + row.program_id + '" data-name="' + row.program + '" data-description="' + row.program_description + '" >Update</a></li>\
                                    <li><a class="dropdown-item" id="remove" href="javascript:;" data-id="' + row.program_id + '">Delete</a></li>\
                                </ul>\
                            </div>';
                    }
                },



            ]
        });
    });


    $(document).on('click', 'a#update', function () {
        var id = $(this).data('id');
        var item_name = $(this).data('name');
        var item_description = $(this).data('description');
        $('input[name=id]').val(id);
        $('input[name=program]').val(item_name);
        $('textarea[name=program_description]').val(item_description);
        $('#add_form').find('button.submit').text('Update');
        $('#add_form').find('button.cancel_update').attr('hidden', false);
        $('.card-title').text('Update ' + item_name + ' Program');
    });

    $('#add_form').find('button.cancel_update').on('click', function () {
        $(this).attr('hidden', true);
        $('input[name=id]').val('');
        $('input[name=program]').val('');
        $('textarea[name=program_description]').val('');
        $('#add_form').find('button.submit').text('Submit');
        $('.card-title').text('Register Programs');
    });




    $('#add_form').on('submit', function (e) {
        e.preventDefault();
        $(this).find('button').prop('disabled', true);
        $(this).find('button').html('<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>')
        var url = '/admin/act/watchlisted/i-u-p';
        let form = $(this);
        if (!$('form#add_form').find('input[name=id]').val()) {
            _insertAjax(url, form, table);
        } else {
            _updatetAjax(url, form, table);
            $(this).find('button.cancel_update').prop('hidden', true)
        }
        $(this)[0].reset();
    });

    $(document).on('click', 'a#remove', function () {
        var id = $(this).data('id');
        var url = '/admin/act/watchlisted/delete-program';

        delete_item(id, url, button_text = '', text = '', table)
       
    });


</script>

@endsection