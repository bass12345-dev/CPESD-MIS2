<script>
    document.addEventListener("DOMContentLoaded", function() {
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
                url: base_url + "/user/act/watchlisted/g-w-r?id=" + $('input[name=person_id]').val(),
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: ""
            },
            columns: [{
                    data: 'record_description'
                },
                {
                    data: 'created_at'
                },
                {
                    data: null
                },
            ],
            columnDefs: [{
                    targets: -1,
                    data: null,
                    render: function(data, type, row) {
                        let actions = row.actions == true ? '<div class="btn-group dropstart">\
                                <i class="fa fa-ellipsis-v " class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></i>\
                                <ul class="dropdown-menu">\
                                    <li><a class="dropdown-item" id="update" href="javascript:;" data-user-id="' + row.p_id + '" data-record="' + row.record_description + '" data-record-id="' + row.record_id + '">Update</a></li>\
                                    <li><a class="dropdown-item" id="remove" href="javascript:;" data-id="' + row.record_id + '">Remove</a></li>\
                                </ul>\
                            </div>' : '';
                        return actions;
                    }
                },



            ]
        });
    });

    $(document).on('click', 'a#update', function() {
        var id = $(this).data('record-id');
        var record = $(this).data('record');
        $('input[name=record_id]').val(id);
        $('textarea[name=record_description]').val(record);
        $('#add_form').find('button.submit').text('Update');
        $('#add_form').find('button.cancel_update').attr('hidden', false);
        $('.card-title').text('Update Record');
    });

    $('#add_form').find('button.cancel_update').on('click', function() {
        $(this).attr('hidden', true);
        $('input[name=record_id]').val('');
        $('textarea[name=record_description]').val('');
        $('#add_form').find('button.submit').text('Submit');
        $('.card-title').text('Add Program');
    });

    $('#add_form').on('submit', function(e) {
        e.preventDefault();
        $(this).find('button').prop('disabled', true);
        $(this).find('button').html('<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>')
        var url = '/user/act/watchlisted/i-u-r';
        let form = $(this);
        if (!$('form#add_form').find('input[name=record_id]').val()) {
            _insertAjax(url, form, table);
        } else {
            _updatetAjax(url, form, table);
            $(this).find('button.cancel_update').prop('hidden', true)
        }
    });


    $(document).on('click', 'a#remove', function() {
        var id = $(this).data('id');
        var url = '/user/act/watchlisted/delete-record';
        delete_item(id, url, button_text = '', text = '', table)
    });
</script>