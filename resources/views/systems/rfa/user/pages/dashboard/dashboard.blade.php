@extends('systems.rfa.user.layout.user_master')
@section('title', $title)
@section('content')
@include('systems.rfa.user.pages.dashboard.sections.count1')
@include('systems.rfa.user.pages.dashboard.sections.graph')
@endsection
@section('js')
<script>
    var year = $('#user_year option:selected').val();

    function load_user_graph($this) {
        load_user_rfa_chart($this.value)
    }

    function load_user_rfa_chart(year) {
        $.ajax({
            url: base_url + '/user/act/rfa/l-u-c-r-t-d',
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
                    new Chart(document.getElementById("bar-chart"), {
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
        })
    }
    load_user_rfa_chart(year);

</script>
@endsection