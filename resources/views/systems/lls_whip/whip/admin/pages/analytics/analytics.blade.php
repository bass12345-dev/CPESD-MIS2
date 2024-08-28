@extends('systems.lls_whip.whip.admin.layout.admin_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                @include('systems.lls_whip.whip.admin.pages.analytics.sections.piechart1')
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                @include('systems.lls_whip.whip.admin.pages.analytics.sections.piechart2')
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                @include('systems.lls_whip.whip.admin.pages.analytics.sections.barchart1')
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @include('systems.lls_whip.whip.admin.pages.analytics.sections.barchart2')
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    var year = $('select[id=admin_year]').val();

    function load_contractor_chart() {
        $.ajax({
            url: base_url + "/user/act/whip/g-c-i-o",
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('.submit-loader').removeClass('hidden');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(data) {
                $('.submit-loader').addClass('hidden');
                try {
                    chart_outside = new Chart(document.getElementById("contractor-chart"), {
                        type: 'pie',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: '',
                                backgroundColor: data.color,

                                data: data.total
                            }, ]
                        },

                    });
                } catch (error) {

                }
            },
            error: function(xhr, status, error) {

                toast_message_error('Contractors Pie Chart is not displaying... Please Reload the Page')

            },
        });
    }


    function load_workers_chart() {
        $.ajax({
            url: base_url + "/user/act/whip/g-w-i-o",
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('.submit-loader').removeClass('hidden');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(data) {
                $('.submit-loader').addClass('hidden');
                try {
                    chart_outside = new Chart(document.getElementById("worker-chart"), {
                        type: 'pie',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: '',
                                backgroundColor: data.color,

                                data: data.total
                            }, ]
                        },

                    });
                } catch (error) {

                }
            },
            error: function(xhr, status, error) {

                toast_message_error('Contractors Pie Chart is not displaying... Please Reload the Page')

            },
        });
    }


    function load_projects_per_barangay() {


        $.ajax({
            url: base_url + "/user/act/whip/g-d-p-p-b",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                try {
                    new Chart(document.getElementById("projects-chart"), {
                        type: 'bar',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: 'Completed Projects',
                                backgroundColor: "rgb(5, 176, 133)",
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.data_completed
                            }, {
                                label: 'Ongoing Projects',
                                backgroundColor: 'rgb(216, 88, 79)',
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.data_ongoing
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
                                text: 'Projects Per Barangay'
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                        }

                    });
                } catch (error) {}
            },
            error: function(xhr, status, error) {

                toast_message_error('Contractor\'s Projects Chart is not displaying... Please Reload the Page')
            },
        });
    }

    function load_graph($this) {
        monitoring_graph($this.value);
    }

    function monitoring_graph(year) {


        $.ajax({
            url: base_url + "/user/act/whip/g-w-m-a?year=" + year,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                try {
                    new Chart(document.getElementById("monitoring-chart"), {
                        type: 'bar',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: 'Approved Monitoring',
                                backgroundColor: "rgb(5, 176, 133)",
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.data_approved
                            }, {
                                label: 'Pending Monitoring',
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
                                text: 'Monitoring'
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                        }

                    });
                } catch (error) {}
            },
            error: function(xhr, status, error) {

                toast_message_error('Contractor\'s Projects Chart is not displaying... Please Reload the Page')
            },
        });


    }

    monitoring_graph(year);
    load_projects_per_barangay();
    load_workers_chart();
    load_contractor_chart();
</script>
@endsection