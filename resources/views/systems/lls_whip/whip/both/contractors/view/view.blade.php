@extends('systems.lls_whip.whip.' . session('user_type') . '.layout.' . session('user_type') . '_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                @include('systems.lls_whip.whip.both.contractors.view.sections.information')
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                <div class="row">
                    @include('systems.lls_whip.whip.both.contractors.view.sections.count_section')
                </div>
                <div class="row">
                    @include('systems.lls_whip.whip.both.contractors.view.sections.graph')
                </div>

            </div>

        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @include('systems.lls_whip.whip.both.contractors.view.sections.projects_table')
        </div>

    </div>
</div>


@endsection
@section('js')
@include('systems.lls_whip.includes.custom_js.update_js')
<script>
    $(document).ready(function () {
        table = $('#data-table-basic').DataTable({
            responsive: true,
            ordering: false,
            processing: true,
            searchDelay: 500,
            pageLength: 25,
            language: {
                "processing": '<div class="d-flex justify-content-center ">' + table_image_loader + '</div>'
            },
            "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: datatables_buttons(),
            ajax: {
                url: base_url + "/user/act/whip/g-c-p",
                method: 'POST',
                data: {
                    id: $('input[name=contractor_id]').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: "",
                error: function (xhr, textStatus, errorThrown) {
                    toast_message_error('Contractor Projects is not displaying... Please Reload the Page')
                }
            },
            columns: [

                {
                    data: 'i'
                },
                {
                    data: 'project_title'
                },

                {
                    data: null
                },
                {
                    data: 'project_location'
                },
                {
                    data: 'project_nature'
                },
                {
                    data: 'date_started'
                },
                {
                    data: 'date_completed'
                },
                {
                    data: null
                }
            ],

            columnDefs: [{
                targets: 1,
                data: null,
                render: function (data, type, row) {
                    return '<a href="' + base_url + '/{{session("user_type")}}/whip/project-information/' + row.project_id + '" data-toggle="tooltip" data-placement="top" title="View ' + row.project_title + '">' + row.project_title + '</a>';
                }
            },
            {
                targets: 2,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return parseFloat((row.project_cost)).toFixed(2)
                }
            },
            {
                targets: -1,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return row.project_status == 'completed' ?
                        '<span class="badge notika-bg-success">Completed</span>' :
                        '<span class="badge notika-bg-danger">Ongoing</span>';
                }
            }
            ]


        });


    });


    function formatNumber (num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}


    function load_projects_per_barangay() {

        var id = $('input[name= contractor_id]').val();
        $.ajax({
            url: base_url + "/user/act/whip/g-p-p-b/" + id,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
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
                } catch (error) { }
            },
            error: function (xhr, status, error) {

                toast_message_error('Contractor\'s Projects Chart is not displaying... Please Reload the Page')
            },
        });
    }


    load_projects_per_barangay();

    $(document).on('click', 'button.submit', function () {
        let data = {
            'contractor_id' : $('input[name=contractor_id]').val(),
            'contractor_name': $('input[name=contractor_name]').val(),
            'province_code': province_options.find(":selected").val(),
            'province': province_options.find(":selected").text(),
            'city_code': city_options.find(":selected").val(),
            'city': city_options.find(":selected").text(),
            'barangay_code': brgy_options.find(":selected").val(),
            'barangay': brgy_options.find(":selected").text(),
            'street': $('input[name=street]').val(),
            'phone_number': $('input[name=phone_number]').val(),
            'phone_number_owner': $('input[name=phone_number_owner]').val(),
            'telephone_number': $('input[name=telephone_number]').val(),
            'email_address': $('input[name=email_address]').val(),
            'proprietor': $('input[name=proprietor]').val(),
            'status': $('select[name=status]').val(),
        }

        var url = "/user/act/whip/update-contractor";
        Swal.fire({
            title: "Review First Before Submitting",
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Submit"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: base_url + url,
                    method: 'POST',
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {
                        $('button.submit').find('button').attr('disabled', true);
                        loader();
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        JsLoadingOverlay.hide();
                        if(data.response) {
                            toast_message_success(data.message);
                        }

                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function () {
                        alert('something Wrong');
                        // location.reload();
                        JsLoadingOverlay.hide();
                    }

                });


            }
        });


    });







</script>
@include('systems.lls_whip.includes.custom_js.update_info_location')
@endsection