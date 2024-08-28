@extends('systems.pmas.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('systems.pmas.includes.components.count_pending_completed')
@include('systems.pmas.includes.components.count_coops')
@include('systems.pmas.admin.pages.dashboard.sections.graph1')
@include('systems.pmas.admin.pages.dashboard.sections.new_transactions')
@endsection
@section('js')
<script>
    var year = $('#admin_year option:selected').val();

    function load_graph($this) {
        load_admin_chart($this.value)
    }

    function load_admin_chart(year) {
        $.ajax({
            url: base_url + '/admin/act/pmas/load-admin-chart-transaction-data',
            data: {
                year: year
            },
            method: 'POST',
            dataType: 'json',
            beforeSend: function () {
                $('.loader-alert').html('Fetching Data....');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                try {
                    $('.loader-alert').html('');
                    new Chart(document.getElementById("admin-bar-chart"), {
                        type: 'bar',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: 'Completed Transactions',
                                backgroundColor: "rgb(5, 176, 133)",
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.data_completed
                            }, {
                                label: 'Pending Transactions',
                                backgroundColor: 'rgb(216, 88, 79)',
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.data_pending
                            }]
                        },
                        options: {
                            legend: {
                                position: 'top',
                                labels: {
                                    padding: 10,
                                    fontColor: '#007bff',
                                }
                            },
                            responsive: true,
                            title: {
                                display: true,
                                text: 'Transactions in year ' + year
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                        }
                    });
                } catch (error) { }
            },
            error: function (xhr, status, error) { },
        });
    }


    function load_cso_chart() {
        $.ajax({
            url: base_url + '/admin/act/pmas/load-admin-chart-cso-data',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                try {
                    new Chart(document.getElementById("admin-cso-chart"), {
                        type: 'pie',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: 'CSO',
                                backgroundColor: data.color,

                                data: data.cso
                            },]
                        },
                        options: {
                            legend: {
                                position: 'top',
                                labels: {
                                    padding: 10,
                                    fontColor: '#007bff',
                                }
                            },
                            responsive: true,
                            title: {
                                display: true,
                                text: "CSO's"
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                        }
                    });
                } catch (error) { }
            },
            error: function (xhr, status, error) { },
        });
    }


    $(document).ready(function () {
        load_admin_chart(year);
        load_cso_chart();
    });

    $('#pending_transactions_table_limit').DataTable({
        "ordering": false,
        responsive: false,
        "pageLength": 5,
        "ajax": {
            "url": base_url + '/user/act/pmas/get-pending-transaction-limit',
            "type": "GET",
            "dataSrc": "",
        },
        'columns': [{
            data: null,
            render: function (data, type, row) {
                return '<span href="javascript:;"    style="color: #000;" >' + data['pmas_no'] + '</span>';
            }
        }, {
            data: null,
            render: function (data, type, row) {
                return '<a href="javascript:;"       style="color: #000;"  >' + data['date_and_time_filed'] + '</a>';
            }
        }, {
            data: null,
            render: function (data, type, row) {
                return '<a href="javascript:;"       style="color: #000;"  >' + data['type_of_activity_name'] + '</a>';
            }
        }, {
            data: null,
            render: function (data, type, row) {
                return '<a href="javascript:;"       style="color: #000;"  >' + data['cso_name'] + '</a>';
            }
        }, {
            data: null,
            render: function (data, type, row) {
                return '<a href="javascript:;"       style="color: #000;"  >' + data['name'] + '</a>';
            }
        },]
    });
</script>
@endsection