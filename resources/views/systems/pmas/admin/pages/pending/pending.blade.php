@extends('systems.pmas.admin.layout.admin_master')
@section('title', $title)
@section('content')
<div class="row">
    <div class="col-12 mt-5">
        <div class="card" style="border: 1px solid;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group mb-3 col-md-5">
                            <input type="text" class="form-control pull-right mt-2 mb-2" name="daterange_pending_filter"
                                value="" style="height: 45px;" />

                            <div class="input-group-append">
                                <div class="col-md-12"> <button id="reload_admin_pending_transaction"
                                        class="btn  mb-3 mt-2 sub-button pull-right">Reload <i
                                            class="ti-loop"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @include('systems.pmas.admin.pages.pending.sections.table')
                </div>
            </div>
        </div>
    </div>
</div>
@include('systems.pmas.admin.pages.pending.modals.add_remark_modal')
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
<script type="text/javascript" src="{{ asset('pmas_rfa/tinymce/tinymce.js')}}"></script>
@include('systems.pmas.includes.custom_js.tinymce_init_js')
<script>
    $(document).on('click', 'button#reload_admin_pending_transaction', function (e) {
        $('#pending_transactions_table').DataTable().destroy();
        fetch_pending_transactions();
    });
    $(document).on('click', 'a#add-remarks', function (e) {
        $("#add_remarks_modal").modal('show');
        $('input[name=transact_id]').val($(this).data('id'));
    });

    $(document).on('click', 'a#update-remark', function (e) {
        const id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: base_url + '/admin/act/rfa/view-remarks',
            data: {
                id: id
            },
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                $('#please_wait_remarks_alert').html('Please Wait......');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                $('#please_wait_remarks_alert').html('');
                $("#add_remarks_modal").modal('show');
                $('input[name=transact_id]').val(id);
                tinymce.get('tiny').setContent(data.remarks);
            },
            error: function (xhr) {
                alert("Error occured.please try again");
                location.reload();
            },
        })
    });

    $('#add_remarks_form').on('submit', function (e) {
        e.preventDefault();
        var myContent = tinymce.get("tiny").getContent();
        var id = $('input[name=transact_id]').val();
        var button = $('.btn-add-remarks');
        $.ajax({
            type: "POST",
            url: base_url + '/admin/act/pmas/add-remark',
            data: {
                content: myContent,
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
                    button.text('Submit');
                    toast_message_success(data.message);
                    $('#add_remarks_modal').modal('hide');
                    var myContent = tinymce.get("tiny").setContent('');
                    $('#pending_transactions_table').DataTable().destroy();
                    fetch_pending_transactions();
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
                // location.reload();
            },
        });
    });

  

    $(function () {
        $('input[name="daterange_pending_filter"]').daterangepicker({
            opens: 'right',
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            format: 'YYYY-MM-DD'
        }, function (start, end, label) {
            $('#pending_transactions_table').DataTable().destroy();
           
            fetch_pending_transactions(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'), filter = true);
        });
    });
    function fetch_pending_transactions(start_date = '', end_date = '', filter = false) {
        $.ajax({
            url: base_url + '/admin/act/pmas/get-pending-transactions',
            type: "POST",
            data: {
                start_date: start_date,
                end_date: end_date,
                filter: filter
            },
            dataType: "json",
            beforeSend: function () {
                $('#reload_admin_pending_transaction').html('');
                $('#reload_admin_pending_transaction').addClass('loader');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                $('#reload_admin_pending_transaction').removeClass('loader');
                $('#reload_admin_pending_transaction').html('Reload <i class="ti-loop"></i>');
                $('#pending_transactions_table').DataTable({
                    scrollY: 800,
                    scrollX: true,
                    "ordering": false,
                    "data": data,
                    "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [{
                        extend: 'excel',
                        text: 'Excel',
                        className: 'btn btn-default ',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    }, {
                        extend: 'pdf',
                        text: 'pdf',
                        className: 'btn btn-default',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    }, {
                        extend: 'print',
                        text: 'print',
                        className: 'btn btn-default',
                        exportOptions: {
                            columns: 'th:not(:last-child)'
                        }
                    },],
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
                            return '<a href="javascript:;"   data-id="' + data['res_center_id'] + '"  style="color: #000;"  >' + data['cso_name'] + '</a>';
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
            },
            error : function(err){
                toast_message_error('Pending Transaction don\'t load properly. Please Reload the Page');
                $('#reload_admin_pending_transaction').removeClass('loader');
                $('#reload_admin_pending_transaction').html('Reload <i class="ti-loop"></i>');
            }
        })
    }


    $(document).on('click', 'a.completed', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        Swal.fire({
            title: "Are you sure?",
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirm",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: base_url + '/admin/act/pmas/approved',
                    data: {
                        id: id
                    },
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
                        });
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        if (data.response) {
                            Swal.fire("", "Completed Successfully", "success");
                            $('#pending_transactions_table').DataTable().destroy();
                            fetch_pending_transactions();
                            load_total_pending_transactions();
                        }
                    },
                    error: function (xhr) {
                        alert("Error occured.please try again");
                        location.reload();
                    },
                })
            } else if (result.dismiss === "cancel") {
                swal.close()
            }
        });
    });


    $(document).ready(function () {
        fetch_pending_transactions();
    });
    $(document).on('click', 'a#view_transaction', function (e) {
        window.open(base_url + '/admin/pmas/view-transaction/' + $(this).data('id'), '_blank');
    });
</script>
@endsection