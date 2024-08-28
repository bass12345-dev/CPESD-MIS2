@extends('systems.dts.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
@include('systems.dts.admin.pages.analytics.sections.document_types_analytics')
@endsection
@section('js')
<script>
    function load_document_types_analytics(year) {

        $.ajax({
            url: base_url + '/admin/act/dts/d-t-analytics',
            data: {
                year: year
            },
            method: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            beforeSend: function () {
                $('.submit-loader').removeClass('d-none');
            },
            success: function (data) {
                $('.submit-loader').addClass('d-none');
                try {

                    new Chart(document.getElementById("chartjs-dashboard-line"), {
                        type: 'horizontalBar',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: 'Documents',
                                backgroundColor: "rgb(41,134,204)",
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.count_documents
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
                                text: 'Documents in year ' + year
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
        })

    }


    function load_document_per_month(year) {

        $.ajax({
            url: base_url + '/admin/act/dts/p-m-analytics',
            data: {
                year: year
            },
            method: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            beforeSend: function () {
                $('.submit-loader').removeClass('d-none');
            },
            success: function (data) {
                $('.submit-loader').addClass('d-none');
                try {

                    new Chart(document.getElementById("chartjs-dashboard-line1"), {
                        type: 'horizontalBar',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: 'Completed',
                                backgroundColor: "rgb(5, 176, 133)",
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.data_completed
                            }, {
                                label: 'Pending',
                                backgroundColor: 'rgb(216, 88, 79)',
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.data_pending
                            }, {
                                label: 'Cancelled',
                                backgroundColor: '#ffcc00',
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.data_cancelled
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
                                text: 'Documents in year ' + year
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
        })

    }

    document.addEventListener("DOMContentLoaded", function () {
        var year = $('#admin_year option:selected').val();
        load_document_types_analytics(year)
        load_document_per_month(year);
    });

    function load_graph($this) {
        load_document_types_analytics($this.value)
        load_document_per_month($this.value);
    }
</script>
@endsection