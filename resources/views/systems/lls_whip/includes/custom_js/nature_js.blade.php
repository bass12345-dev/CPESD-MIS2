<script>
     $(document).on('click', 'button.update_nature', function () {
        $('form#add_update_form').find('input[name=project_nature]').val($(this).data('nature'));
        $('form#add_update_form').find('input[name=project_nature_id]').val($(this).data('id'));
    });
    $('button#multi-delete').on('click', function () {
        var button_text = 'Delete selected items';
        var text = '';
        var url = '/admin/act/whip/d-p-n';
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
    function add_update_ajax(url, form, table) {
        if (!$('form#add_update_form').find('input[name=position_id]').val()) {
            _insertAjax(url, form, table);
        } else {
            _updatetAjax(url, form, table);
        }

    }


    function nature_table(url) {
        return $('#data-table-basic').DataTable({
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
                url: base_url + url,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: ""
            },
            columns: [
                {
                    data: 'project_nature_id'
                },
                {
                    data: 'project_nature'
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
                                <div ><button class="btn btn-success update_nature" \
                                data-id="'+ data.project_nature_id + '"\
                                data-nature="'+ data.project_nature + '"\
                                ><i class="fas fa-pen"></i></button> </div>\
                                </div>\
                                ';
                }
            }
            ]

        });
    }
</script>