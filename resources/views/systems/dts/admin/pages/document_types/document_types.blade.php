@extends('systems.dts.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
<div class="row">
    <div class="col-12  col-md-7 ">
        @include('systems.dts.admin.pages.document_types.sections.table')
    </div>
    <div class="col-12 col-md-5">
        @include('systems.dts.admin.pages.document_types.sections.form')
    </div>
</div>
@endsection
@section('js')
<script>
 document.addEventListener("DOMContentLoaded", function () {
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
                url: base_url + "/admin/act/dts/types",
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: "",
                error: function (xhr, textStatus, errorThrown) {
                    toast_message_error('Documents is not displaying... Please Reload the Page Or Contact the developer')
               }
            },
            columns: [
                {
                    data: 'number',
                },
                {
                    data: 'type_name',
                },
                {
                    data: 'created'
                },
                {
                    data: null
                },


            ],
            columnDefs: [
                {
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return '<div class="btn-group dropstart">\
                             <i class="fa fa-ellipsis-v " class="dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false"></i>\
                             <ul class="dropdown-menu">\
                                  <li><a href="javascript:;" class="dropdown-item text-danger" data-id="'+ row.type_id + '" id="delete">Delete</a></li>\
                                  <li><a href="javascript:;" id="update" class="dropdown-item text-primary" data-id="'+ row.type_id + '" data-type="' + row.type_name + '" >Update</a></li>\
                                </ul>\
                           </div>';
                    }
                }
            ],
        });
    });

    $(document).on('click', 'a#update', function () {
        var id = $(this).data('id');
        var type = $(this).data('type');
        $('input[name=id]').val(id);
        $('input[name=type]').val(type);
        $('#add_form').find('button.submit').text('Update');
        $('#add_form').find('button.cancel_update').attr('hidden', false);
        $('#add_form').find('button.cancel_update').text('Cancel update');
        $('.card-title').text('Update ' + office + ' Office');
    });

    $('#add_form').find('button.cancel_update').on('click', function () {
        $(this).attr('hidden', true);
        $('input[name=id]').val('');
        $('input[name=type]').val('');
        $('#add_form').find('button.submit').text('Submit');
        $('.card-title').text('Add Office');
    });

    $('#add_form').on('submit', function (e) {
        e.preventDefault();
        $(this).find('button').prop('disabled', true);
        $(this).find('button').html('<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>')
        var url = '/admin/act/dts/i-u-t';
        let form = $(this);
        if (!$('form#add_form').find('input[name=id]').val()) {
            _insertAjax(url, form, table);
        } else {
            _updatetAjax(url, form, table);
            $(this).find('button.cancel_update').prop('hidden',true)
        }
    });

    $(document).on('click', 'a#delete', function () {
        var button_text = 'Delete Item';
        var text = '';
        var url = '/admin/act/dts/d-t';
        var data = {
            id: $(this).data('id'),
        };
        delete_item(data, url, button_text, text, table);
    });
</script>
@endsection