@extends('systems.cso.layout.cso_master')
@section('title', $title)
@section('content')
@include('systems.pmas.includes.components.count_coops')
<div class="row">
@include('systems.cso.pages.dashboard.sections.graph1')
@include('systems.cso.pages.dashboard.sections.cso_per_barangay')
</div>
@endsection
@section('js')
<script>
 function per_barangay() {
   $('#per_barangay_table').DataTable({
      "ajax": {
         "url": base_url + '/user/act/cso/count-cso-per-barangay',
         "type": "GET",
         "dataSrc": "",
      },
      scrollX: true,
      "ordering": false,
      "paging": false,
      "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      buttons: [{
         extend: 'excel',
         text: 'Excel',
         className: 'btn btn-default ',
      }, {
         extend: 'pdf',
         text: 'pdf',
         className: 'btn btn-default',
      }, {
         extend: 'print',
         text: 'print',
         className: 'btn btn-default',
      }, ],
      'columns': [{
         data: 'barangay',
      }, {
         data: 'active',
      }, {
         data: 'inactive',
      }, ]
   })
}
function load_cso_chart() {
        $.ajax({
            url: base_url + '/admin/act/pmas/load-admin-chart-cso-data',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                try {
                    new Chart(document.getElementById("cso-chart"), {
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
        per_barangay();
        load_cso_chart();
    });

</script>
@endsection