@extends('systems.watchlisted.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.watchlisted.admin.pages.dashboard.sections.count1')
@include('systems.watchlisted.admin.pages.dashboard.sections.barangay')
@include('systems.watchlisted.admin.pages.dashboard.sections.latest_tabs')
@include('systems.watchlisted.admin.pages.dashboard.sections.count2')
@include('systems.watchlisted.admin.pages.dashboard.sections.gender')
@endsection
@section('js')
<script>
    var year = $('#admin_year option:selected').val();

    function load_graph($this) {
        load_chart_active($this.value)
    }

    function load_chart_active(year) {

        $.ajax({
            url: base_url + '/admin/act/watchlisted/l-c-g-a',
            data: {
                year: year
            },
            method: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': '<?php echo config('app.key') ?>'
            },
            beforeSend: function() {
                $('.loader-alert').html('Fetching Data....');
            },
            success: function(data) {
                try {
                    $('.loader-alert').html('');
                    new Chart(document.getElementById("admin-bar-gender-by-month-chart"), {
                        type: 'bar',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: 'Male',
                                backgroundColor: "rgb(41,134,204)",
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.male
                            }, {
                                label: 'Female',
                                backgroundColor: 'rgb(201,0,118)',
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.female
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
                                text: 'Watchlisted in year ' + year
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
            error: function(xhr, status, error) {},
        })

    }

    function load_chart() {
        $.ajax({
            url: base_url + '/admin/act/watchlisted/data-per-barangay',
            method: 'GET',
            dataType: 'json',
            success: function(data) {

                try {

                    // Bar chart
                    new Chart(document.getElementById("chartjs-dashboard-bar"), {
                        type: "bar",
                        data: {
                            labels: data.label,
                            datasets: [{
                                    label: 'Approved',
                                    backgroundColor: window.theme.danger,
                                    borderColor: window.theme.danger,
                                    hoverBackgroundColor: window.theme.danger,
                                    hoverBorderColor: window.theme.danger,
                                    data: data.active,

                                },

                                {
                                    label: 'To Approved',
                                    backgroundColor: window.theme.warning,
                                    borderColor: window.theme.warning,
                                    hoverBackgroundColor: window.theme.warning,
                                    hoverBorderColor: window.theme.warning,
                                    data: data.to_approved,

                                },

                                {
                                    label: 'Removed',
                                    backgroundColor: window.theme.success,
                                    borderColor: window.theme.success,
                                    hoverBackgroundColor: window.theme.success,
                                    hoverBorderColor: window.theme.success,
                                    data: data.removed,

                                }


                            ]
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
                                text: 'Per Barangay Data'
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }

                            },
                        }

                    });

                } catch (error) {
                    alert('Something Wrong')
                }
            },
            error: function(xhr, status, error) {},
        });

    }




    document.addEventListener("DOMContentLoaded", function() {
        load_chart();
        load_chart_active(year)
    });
</script>
@endsection