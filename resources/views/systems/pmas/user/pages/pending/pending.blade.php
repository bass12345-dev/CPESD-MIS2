@extends('systems.pmas.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="row">
    <div class="col-12 mt-5">
        <div class="card" style="border: 1px solid;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn  mb-3 mt-2 sub-button pull-right mr-2" id="reload_user_pending_transaction">
                            Reload <i class="ti-loop"></i></button>
                    </div>
                </div>
                <div class="row">
                    @include('systems.pmas.user.pages.pending.sections.table')
                </div>
            </div>
        </div>
    </div>
</div>
@include('systems.pmas.user.pages.pending.modals.view_remarks_modal')
@include('systems.pmas.user.pages.pending.modals.pass_to_modal')
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
<script>

    $(document).on('click', 'button#reload_user_pending_transaction', function (e) {
        $('#pending_transactions_table').DataTable().destroy();
        fetch_user_pending_transactions();
        loader();
    });

    function fetch_user_pending_transactions() {
        $.ajax({
            url: base_url + '/user/act/pmas/get-user-pending-transactions',
            type: "GET",
            dataType: "json",
            success: function (data) {
                JsLoadingOverlay.hide();
                $('#pending_transactions_table').DataTable({
                    scrollY: 800,
                    scrollX: true,
                    "ordering": false,
                    "data": data,
                    'columns': [{
                        data: null,
                        render: function (data, type, row) {
                            return '<b><a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['pmas_no'] + '</a></b>';
                        }
                    }, {
                        data: null,
                        render: function (data, type, row) {
                            return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['date_and_time_filed'] + '</a>';
                        }
                    }, {
                        data: null,
                        render: function (data, type, row) {
                            return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['type_of_activity_name'] + '</a>';
                        }
                    }, {
                        data: null,
                        render: function (data, type, row) {
                            return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['name'] + '</a>';
                        }
                    }, {
                        data: null,
                        render: function (data, type, row) {
                            return row.s;
                        }
                    }, {
                        data: null,
                        render: function (data, type, row) {
                            return row.action;
                        }
                    },]
                })
            }
        })
    }

    $(document).on('click', 'a#pass_to', function (e) {

        $('.pass-to-title').text('PMAS NO ' + $(this).data('name'));
        $('input[name=pmas_id]').val($(this).data('id'));

    });

    $('#pass_to_form').on('submit', function (e) {
        e.preventDefault();

        var pass_to_id = $('#pass_to_id').find('option:selected').val();
        var button = $('.pass-button');

        if (pass_to_id == '') {
            alert('Please select user');
        } else {

            $.ajax({
                type: "POST",
                url: base_url + '/user/act/pmas/pass-pmas',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function () {
                    button.html('<div class="loader"></div>');
                    button.prop("disabled", true);
                    loader()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    if (data.response) {
                        $('#pass_to_form')[0].reset();
                        button.prop("disabled", false);
                        button.text('Submit');
                        toast_message_success(data.message)

                    } else {
                        button.prop("disabled", false);
                        button.text('Submit');
                        toast_message_error(data.message)

                    }
                    JsLoadingOverlay.hide();
                    $('#pass_to_modal').modal('hide');
                    $('#pending_transactions_table').DataTable().destroy();
                    fetch_user_pending_transactions();

                },
                error: function (xhr) {
                    alert("Error occured.please try again");
                    button.prop("disabled", false);
                    button.text('Submit');
                },
            })

        }
    });

    $(document).on('click', 'a#view-remarks', function (e) {
        $.ajax({
            type: "POST",
            url: base_url + '/user/act/pmas/view-remarks',
            data: {
                id: $(this).data('id')
            },
            dataType: 'json',
            beforeSend: function () {
                $('div#remarks').addClass('.loader');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                $("#view_remarks_modal").modal('show');
                $('div#remarks').find('p').html(data.remarks);
                $('input[name=t_id]').val(data.transaction_id);
            }
        })
    });

    $(document).on('click', 'button#btn-done-remarks', function (e) {
        e.preventDefault();
        var id = $('input[name=t_id]').val();
        var button = $('button#btn-done-remarks');
        Swal.fire({
            title: "",
            text: "Confirm",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: base_url + '/user/act/pmas/accomplished',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        button.html('<div class="loader"></div>');
                        button.prop("disabled", true);
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        if (data.response) {
                            button.prop("disabled", false);
                            button.text('Done');
                            toast_message_success(data.message);
                            $('#view_remarks_modal').modal('hide');
                            $('#pending_transactions_table').DataTable().destroy();
                            fetch_user_pending_transactions();
                        } else {
                            button.prop("disabled", false);
                            button.text('Submit');
                            toast_message_error(data.message);
                        }
                    },
                    error: function (xhr) {
                        alert("Error occured.please try again");
                        button.prop("disabled", false);
                        button.text('Submit');
                    },
                })
            } else if (result.dismiss === "cancel") {
                swal.close()
            }
        });
    });

    $(document).ready(function () {
        fetch_user_pending_transactions();
    });
</script>
@endsection