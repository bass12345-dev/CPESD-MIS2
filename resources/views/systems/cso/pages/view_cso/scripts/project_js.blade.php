<script>
    function load_projects() {

        $.ajax({
            url: base_url + '/user/act/cso/get-projects',
            type: "POST",
            data: { cso_id: $('input[name=cso_id]').val() },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                $('#project_table').DataTable({
                    scrollY: 500,
                    scrollX: true,
                    "ordering": false,
                    "data": data,
                    "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        {
                            extend: 'excel',
                            text: 'Excel',
                            className: 'btn btn-default ',
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
                    'columns': [
                        {

                            data: null,
                            render: function (data, type, row) {
                                return row.project_title;
                            }

                        },
                        {

                            data: null,
                            render: function (data, type, row) {
                                return row.amount;
                            }

                        },
                        {

                            data: null,
                            render: function (data, type, row) {
                                return row.year;
                            }

                        },
                        {

                            data: null,
                            render: function (data, type, row) {
                                return row.funding_agency;
                            }

                        },
                        {

                            data: null,
                            render: function (data, type, row) {
                                return row.status;
                            }

                        },
                        {

                            data: null,
                            render: function (data, type, row) {
                                return '<ul class="d-flex justify-content-center">\
                          <li class="mr-3 ">\
                          <a href="javascript:;" class="text-secondary action-icon" \
                          data-id="'+ data['cso_project_id'] + '"  \
                          data-project-title="'+ data['project_title'] + '"  \
                          data-amount="'+ data['amount'] + '"  \
                          data-year1="'+ data['year1'] + '"  \
                          data-funding-agency="'+ data['funding_agency'] + '"  \
                          data-status="'+ data['status1'] + '"  \
                          id="update-cso-project"><i class="fa fa-edit"></i></a></li>\
                          <li class="mr-3 ">\
                          <a href="javascript:;" class="text-danger action-icon" \
                         data-id="'+ data['cso_project_id'] + '"  \
                          data-project-title="'+ data['project_title'] + '"  \
                          id="delete-cso-project"><i class="fa fa-trash"></i></a></li>\
                          </ul>';
                            }

                        },
                    ]

                })

            }


        });

    }

    $('#add_project_form').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let table = $('#project_table');
        var url = '/user/act/cso/add-project';
        _insertAjax(url, form, table = null)
        loader();
        setTimeout(function () {
            JsLoadingOverlay.hide();
            $('#project_table').DataTable().destroy();
            load_projects();
            form[0].reset();
        }, 2000);

        

    });

    $(document).on('click', 'a#update-cso-project', function (e) {

        $('#update_project_modal').modal('show');

        $('input[name=cso_project_id]').val($(this).data('id'));
        $('input[name=update_title_of_project]').val($(this).data('project-title'));
        $('input[name=update_amount]').val($(this).data('amount'));
        $('input[name=update_year]').val($(this).data('year1'));
        $('input[name=update_funding_agency]').val($(this).data('funding-agency'));

        $('select[name=update_status]').val($(this).data('status'));

    });


    $('#update_project_form').on('submit', function (e) {
        e.preventDefault();
        var btn = $('.btn-update-project_');
        $.ajax({
            type: "POST",
            url: base_url + '/user/act/cso/update-project',
            data: $(this).serialize(),
            cache: false,
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
                    $('#update_project_modal').modal('hide');
                    btn.text('Save Changes');
                    btn.removeAttr('disabled');
                    toast_message_success(data.message);
                    $('#project_table').DataTable().destroy();
                    load_projects();
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

    $(document).on('click', 'a#delete-cso-project', function (e) {


        var id = $(this).data('id');
        var project = $(this).data('project-title');


        Swal.fire({
            title: "",
            text: "Delete Project " + project,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function (result) {
            if (result.value) {

                $.ajax({
                    type: "POST",
                    url: base_url + '/user/act/cso/delete-cso-project',
                    data: { id: id },
                    cache: false,
                    dataType: 'json',
                    beforeSend: function () {
                        loader();
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        if (data.response) {

                            JsLoadingOverlay.hide();

                            Swal.fire(
                                "",
                                "Deleted Successfully",
                                "success"
                            )


                            $('#project_table').DataTable().destroy();
                            load_projects();

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