@extends('systems.lls_whip.lls.user.layout.user_master')
@section('title', $title)
@section('content')
@include('systems.lls_whip.lls.user.pages.dashboard.sections.count1')
@include('systems.lls_whip.lls.user.pages.dashboard.sections.list1')
@endsection
@section('js')
<script>
    function load_gender_inside_chart() {

        $.ajax({
            url: base_url + "/user/act/lls/g-g-i",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                try {
                    chart1 = new Chart(document.getElementById("inside-gender-chart"), {
                        type: 'pie',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: '',
                                backgroundColor: data.color,
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.total
                            }, ]
                        },

                    });
                } catch (error) {

                }
            },
            error: function(xhr, status, error) {

                toast_message_error('Gender Pie Chart is not displaying... Please Reload the Page')

            },
        });
    }

    function load_gender_outside_chart() {

        $.ajax({
            url: base_url + "/user/act/lls/g-g-o",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                try {
                    chart1 = new Chart(document.getElementById("outside-gender-chart"), {
                        type: 'pie',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: '',
                                backgroundColor: data.color,
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.total
                            }, ]
                        },

                    });
                } catch (error) {

                }
            },
            error: function(xhr, status, error) {

                toast_message_error('Gender Pie Chart is not displaying... Please Reload the Page')

            },
        });
    }
    $(document).ready(function(){
        load_gender_outside_chart()
        load_gender_inside_chart();
    });
  
</script>
@endsection