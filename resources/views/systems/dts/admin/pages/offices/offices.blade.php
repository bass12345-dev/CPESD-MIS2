@extends('systems.dts.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
<div class="row">
    <div class="col-12  col-md-7 ">
        @include('systems.dts.admin.pages.offices.sections.table')
    </div>
    <div class="col-12 col-md-5">
        @include('systems.dts.admin.pages.offices.sections.form')
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
                url: base_url + "/admin/act/dts/all-offices",
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
                    data: 'office',
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
                                  <li><a href="javascript:;" class="dropdown-item text-danger" data-id="'+ row.office_id + '" id="delete">Delete</a></li>\
                                  <li><a href="javascript:;" id="update_office" class="dropdown-item text-primary" data-id="'+ row.office_id + '" data-office="' + row.office + '" >Update</a></li>\
                                </ul>\
                           </div>';
                    }
                }
            ],
        });
    });

    $(document).on('click', 'a#update_office', function () {
        var id = $(this).data('id');
        var office = $(this).data('office');
        $('input[name=office_id]').val(id);
        $('input[name=office]').val(office);
        $('#add_office').find('button.submit').text('Update');
        $('#add_office').find('button.cancel_update').attr('hidden', false);
        $('#add_office').find('button.cancel_update').text('Cancel update');
        $('.card-title').text('Update ' + office + ' Office');
    });

    $('#add_office').find('button.cancel_update').on('click', function () {
        $(this).attr('hidden', true);
        $('input[name=office_id]').val('');
        $('input[name=office]').val('');
        $('#add_office').find('button.submit').text('Submit');
        $('.card-title').text('Add Office');
    });

    $('#add_office').on('submit', function (e) {
        e.preventDefault();
        $(this).find('button').prop('disabled', true);
        $(this).find('button').html('<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>')
        var url = '/admin/act/dts/i-u-o';
        let form = $(this);
        if (!$('form#add_office').find('input[name=office_id]').val()) {
            _insertAjax(url, form, table);
        } else {
            _updatetAjax(url, form, table);
            $(this).find('button.cancel_update').prop('hidden',true)
        }
    });

    $(document).on('click', 'a#delete', function () {
        var button_text = 'Delete Item';
        var text = '';
        var url = '/admin/act/dts/d-o';
        var data = {
            id: $(this).data('id'),
        };
        delete_item(data, url, button_text, text, table);
    });
</script>
@endsection