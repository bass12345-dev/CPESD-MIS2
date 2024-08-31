@extends('systems.pmas.admin.layout.admin_master')
@section('title', $title)
@section('content')
<div class="row">
    <div class="col-12 mt-5">
        <div class="card" style="border: 1px solid;">
            <div class="card-body">
                @include('systems.pmas.admin.pages.report.sections.filter')
                @include('systems.pmas.admin.pages.report.sections.result')
            </div>
        </div>
    </div>
</div>
@include('systems.pmas.admin.pages.report.modals.view_project_monitoring_modal')
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
    $(function () {
        $('input[name="daterange_completed_filter"]').daterangepicker({
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
        }, function (start, end, label) { });
    });

    $(document).on('click', 'button#generate-pmas-report', function (e) {
        var date_filter = $('input[name="daterange_completed_filter"]').val();
        var filter_type_of_activity = $('#filter_type_of_activity option:selected').val();
        var cso = $('#select_cso option:selected').val();
        $('#completed_transactions_table').DataTable().destroy();
        generate_pmas_report(date_filter, filter_type_of_activity, cso);
        
    });
    $(document).on('click', 'button#close_pmas_report_section', function (e) {
        $('#generate_pmas_report_section').attr("hidden", true);
    });
    $(document).on('click', 'button#reset-filter-options', function (e) {
        $('select[id=filter_type_of_activity]').val('');
        $('select[name=cso]').select2("val", "0");
        $('#select_cso_section').attr('hidden', 'hidden');
        $('input[name=daterange_completed_filter]').val(moment().format("MM/DD/YYYY") + ' - ' + moment().format("MM/DD/YYYY"));
    });
    $(document).on('change', 'select#filter_type_of_activity', function (e) {
        var text = $('#filter_type_of_activity').find('option:selected').text().toString().toLowerCase();
        if (text == '<?php echo $rgpm_text ?>') {
            $('#select_cso_section').removeAttr('hidden');
            $('#total_section').removeAttr('hidden');
        } else {
            $('#total_section').attr('hidden', 'hidden');
            $('#select_cso_section').attr('hidden', 'hidden');
            $('select[name=cso]').select2("val", "0");
        }
    });


    $(document).on('click', 'a#view_project_monitoring', function (e) {
        const id = $(this).data('id');
        const title = $(this).data('title');
        $.ajax({
            type: "POST",
            url: base_url + '/admin/act/pmas/get-project-transaction-data',
            data: {
                id: id
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                $("#view_project_monitoring_modal").modal('show');
                $('.cso_title').text(title);
                $('.project_title').html(data.project_title);
                $('.delinquent').text('₱ ' + data.delinquent);
                $('.overdue').text('₱ ' + data.overdue);
                $('.total_production').text('₱ ' + data.total_production);
                $('.total_collection_sales').text('₱ ' + data.total_collection_sales);
                $('.total_released_purchases').text('₱ ' + data.total_released_purchases);
                $('.total_delinquent_account').text('₱ ' + data.total_delinquent_account);
                $('.total_over_due_account').text('₱ ' + data.total_over_due_account);
                $('.cash_in_bank').text('₱ ' + data.cash_in_bank);
                $('.cash_on_hand').text('₱ ' + data.cash_on_hand);
                $('.inventories').text('₱ ' + data.inventories);
                $('.total_volume_of_business_').text('₱ ' + data.total_volume_of_business);
                $('.total_cash_position_').text('₱ ' + data.total_cash_position);
            }
        });
    });

    function generate_pmas_report(date_filter, filter_type_of_activity, cso) {
        $.ajax({
            url: base_url + '/admin/act/pmas/generate-pmas-report',
            type: "POST",
            data: {
                date_filter,
                filter_type_of_activity,
                cso
            },
            dataType: "json",
            beforeSend: function () {
                $('#generate-pmas-report').html('Fetching Data...');
                loader();
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                $('#generate-pmas-report').html('Generate Report');
                $('#generate_pmas_report_section').removeAttr('hidden');
                var total_volume_of_business = 0;
                var total_cash_position = 0;
                var text = $('#filter_type_of_activity').find('option:selected').text().toString().toLowerCase();


                if (text == '<?php echo $rgpm_text ?>') {

                    for (var i = 0; i < data.length; i++) {

                        total_volume_of_business = total_volume_of_business + parseFloat(data[i].total_volume_of_business.replace(',', ''));
                    }
                    $('.all_total_volume_of_business').text('₱ ' + parseFloat(total_volume_of_business).toFixed(2));
                    for (var i = 0; i < data.length; i++) {

                        total_cash_position = total_cash_position + parseFloat(data[i].total_cash_position.replace(',', ''));
                    }
                    $('.all_total_cash_position').text('₱ ' + parseFloat(total_cash_position).toFixed(2));
                }
                JsLoadingOverlay.hide();
                $('#completed_transactions_table').DataTable({
                    "ordering": false,
                    "paging": true,
                    search: true,
                    autoWidth: true,
                    responsive: false,
                    "data": data,
                    "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        {
                            extend: 'excel',
                            text: 'Excel',
                            className: 'btn btn-default ',
                            footer: true,
                            exportOptions: {
                                columns: 'th:not(:last-child)',
                                orthogonal: 'excel',
                                modifier: {
                                    order: 'current',
                                    page: 'all',
                                    selected: false,
                                },
                            }
                        },
                        {
                            extend: 'pdf',
                            text: 'pdf',
                            className: 'btn btn-default',
                            footer: true,
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        }, {
                            extend: 'print',
                            text: 'print',
                            className: 'btn btn-default',
                            footer: true,
                            exportOptions: {
                                columns: 'th:not(:last-child)',
                            }
                        },],
                    'columns': [{
                        data: 'pmas_no',
                    }, {
                        data: 'date_and_time_filed',
                    }, {
                        data: "type_of_activity_name",
                    }, {
                        data: 'cso_name',
                    }, {
                        data: 'name',
                    }, {
                        data: null,
                        render: function (data, type, row) {
                            return '<ul class="d-flex justify-content-center">\ <li><a href="javascript:;" data-id="' + data['transaction_id'] + '"   id="view_transaction1"  class="text-secondary action-icon"><i class="ti-eye"></i></a></li>\ </ul>';
                        }
                    },],
                });
            }
        });
    }
    $(document).on('click', 'a#view_transaction1', function (e) {
        window.open(base_url + '/admin/pmas/view-transaction/' + $(this).data('id'), '_blank');
    });

</script>
@endsection