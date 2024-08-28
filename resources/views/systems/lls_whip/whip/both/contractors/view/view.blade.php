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
    var province_options = $("#province_select");
    var city_options = $("#city_select");
    var brgy_options = $("#barangay_select");
    function load_provinces() {
        province_options.append(new Option('Select Province', ''));
        $.ajax({
            url: 'https://psgc.cloud/api/provinces', method: 'GET', dataType: 'json', beforeSend: function () { province_options.after('<span class="text-warning loading_provinces" >Loading Provinces...</span><a href="javascript:;" class="refetch_provinces"></a>'); }
        }).done(function (data) {
            $('span.loading_provinces').remove();
            $.each(data, function (i, row) {
                province_options.append(new Option(row.name, row.code));
            });
            province_options.removeAttr('disabled');
            province_options.val($('input[name=province_code]').val());
        });
    }


    province_options.on('change', function () {
        city_options.find('optgroup').remove();
        city_options.find('option').remove();
        var province_string = $(this).find(":selected").val().split("-");
        var province_selected = province_string[0];
        var url = 'https://psgc.cloud/api/provinces/' + province_selected + '/cities-municipalities';
        let city_arr = [];
        $.ajax({
            url: url, method: 'GET', dataType: 'json', beforeSend: function () { city_options.after('<span class="text-warning loading_cities" >Loading Cities and Municipalities...</span>'); }
        }).done(function (cities) {
            $('span.loading_cities').remove();
            var filteredMun = $(cities).filter(function (idx) {
                return cities[idx].type === "Mun"
            });
            var filteredCities = $(cities).filter(function (idx) {
                return cities[idx].type === "City"
            });
            var optgroup = "<optgroup label='Cities'>";
            $(filteredCities).each(function () {
                name = this.name;
                optgroup += "<option value='" + this.code + "'>" + name + "</option>"
            });
            optgroup += "</optgroup>"
            city_options.append(optgroup);

            var optgroup = "<optgroup label='Municipalities'>";
            $(filteredMun).each(function () {
                name = this.name;
                optgroup += "<option value='" + this.code + "'>" + name + "</option>"
            });
            optgroup += "</optgroup>"
            city_options.append(optgroup);
            city_options.prepend(new Option('Select City Or Municipalities', ''));
            $(`#city_select option[value='']`).prop('selected', true);
            city_options.removeAttr('disabled');


        });
    });


    city_options.on('change', function () {

        brgy_options.find('option').remove();
        var city_string = $(this).find(":selected").val().split("-");
        var city_selected = city_string[0];
        brgy_options.append(new Option('Select Barangay', ''));
        var url = 'https://psgc.cloud/api/cities-municipalities/' + city_selected + '/barangays';
        let city_arr = [];
        $.ajax({
            url: url, method: 'GET', dataType: 'json', beforeSend: function () { brgy_options.after('<span class="text-warning loading_brgy" >Loading Brgy...</span>'); }
        }).done(function (data) {
            $('span.loading_brgy').remove();
            $.each(data, function (i, row) {
                brgy_options.append(new Option(row.name, row.code));
            });
            brgy_options.removeAttr('disabled');
        });
    });



    function load_selected_city() {
        city_options.append(new Option($('input[name=city_name]').val(), $('input[name=city_code]').val()));
    }

    function load_selected_barangay() {
        brgy_options.append(new Option($('input[name=barangay_name]').val(), $('input[name=barangay_code]').val()));
    }
    load_selected_barangay();
    load_selected_city();
    load_provinces();


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
@endsection