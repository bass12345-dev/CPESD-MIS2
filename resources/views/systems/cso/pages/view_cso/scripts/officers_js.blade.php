<script>
    function load_cso_officers() {

        $.ajax({
            url: base_url + '/user/act/cso/get-officers',
            type: "POST",
            data: {
                cso_id: $('input[name=cso_id]').val()
            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                $('#officers_table').DataTable({
                    scrollY: 500,
                    scrollX: true,
                    "ordering": false,
                    "data": data,
                    "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [{
                        extend: 'excel',
                        text: 'Excel',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'pdf',
                        className: 'btn btn-default',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },

                    {
                        extend: 'print',
                        text: 'print',
                        className: 'btn btn-default',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },

                    ],
                    'columns': [{
                        data: null,
                        render: function (data, type, row) {
                            return row.name;
                        }

                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return row.title;
                        }

                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return row.contact_number;
                        }

                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return row.email_address;
                        }

                    },
                    {
                        // data: "song_title",
                        data: null,
                        render: function (data, type, row) {
                            return '<ul class="d-flex justify-content-center">\
                  <li class="mr-3 ">\
                  <a href="javascript:;" class="text-secondary action-icon" \
                  data-id="' + data['cso_officer_id'] + '"  \
                  data-position="' + data['position'] + '"  \
                  data-first-name="' + data['first_name'] + '"  \
                  data-middle-name="' + data['middle_name'] + '"  \
                  data-last-name="' + data['last_name'] + '"  \
                  data-extension="' + data['extension'] + '"  \
                  data-contact="' + data['contact_number'] + '"  \
                  data-email="' + data['email_address'] + '"  \
                  id="update-cso-officer"><i class="fa fa-edit"></i></a></li>\
                  <li class="mr-3 ">\
                  <a href="javascript:;" class="text-danger action-icon" \
                  data-id="' + data['cso_officer_id'] + '"  \
                  id="delete-cso-officer"><i class="fa fa-trash"></i></a></li>\
                  </ul>';
                        }

                    },
                    ]

                })

            }


        });


    }

    //CSO Officers
    $(document).on('click', 'a#update-cso-officer', function (e) {

        const id = $(this).data('id');
        const position = $(this).data('position');
        $('#update_officer_modal').modal('show');
        $('select[name=update_cso_position]').val(position);
        // $('#cso_status option[value='+position+']').attr('selected','selected'); 
        $('input[name=officer_id]').val(id);
        $('input[name=cso_id]').val($('input[name=cso_id]').val());
        $('input[name=update_first_name]').val($(this).data('first-name'));
        $('input[name=update_middle_name]').val($(this).data('middle-name'));
        $('input[name=update_last_name]').val($(this).data('last-name'));
        $('input[name=update_extension]').val($(this).data('extension'));
        $('input[name=update_contact_number]').val($(this).data('contact'));
        $('input[name=update_email]').val($(this).data('email'));
    });
    $('#add_officer_form').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        var url = '/user/act/cso/add-officer';
        var text = 'Save Changes';
        _insertAjax(url, form, table = null)
        $('#officers_table').DataTable().destroy();
        loader();
        setTimeout(function () {
            JsLoadingOverlay.hide();
            load_cso_officers();
        }, 2000);

        form[0].reset();

    });

    $('#update_officer_form').on('submit', function (e) {
        e.preventDefault();
        var btn = $('.btn-update-cso');
        $.ajax({
            type: "POST",
            url: base_url + '/user/act/cso/update-officer-information',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                btn.text('Please wait...');
                btn.attr('disabled', 'disabled');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                if (data.response) {
                    $('#update_officer_modal').modal('hide')
                    btn.text('Save Changes');
                    btn.removeAttr('disabled');
                    toast_message_success(data.message);
                    $('#officers_table').DataTable().destroy();
                    load_cso_officers();

                } else {

                    btn.text('Save Changes');
                    btn.removeAttr('disabled');
                    toast_message_error(data.message);

                }
            },
            error: function (xhr) { // if error occured
                alert("Error occured.please try again");
                btn.text('Save Changes');
                btn.removeAttr('disabled');
            },


        });

    });



    $(document).on('click', 'a#delete-cso-officer', function (e) {
        var id = $(this).data('id');
        Swal.fire({
            title: "Are you sure?",
            text: "You wont be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function (result) {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: base_url + '/user/act/cso/delete-cso-officer',
                    data: { id: id },
                    cache: false,
                    dataType: 'json',
                    beforeSend: function () {

                        Swal.fire({
                            title: "",
                            text: "Please Wait",
                            icon: "",
                            showCancelButton: false,
                            showConfirmButton: false,
                            reverseButtons: false,
                            allowOutsideClick: false
                        })

                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        if (data.response) {

                            Swal.fire(
                                "",
                                "Deleted Successfully",
                                "success"
                            )

                            $('#officers_table').DataTable().destroy();
                            load_cso_officers();

                        }


                    }
                })



                // result.dismiss can be "cancel", "overlay",
                // "close", and "timer"
            } else if (result.dismiss === "cancel") {
                swal.close()

            }
        });

    });
</script>