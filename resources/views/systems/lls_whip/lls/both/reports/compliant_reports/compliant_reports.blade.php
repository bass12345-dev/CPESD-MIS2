@extends('systems.lls_whip.lls.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @include('systems.lls_whip.lls.both.reports.compliant_reports.sections.table')
            </div>
        </div>
    </div>
</div>
@include('systems.lls_whip.lls.both.reports..survey_reports.modals.survey_reports_modal')
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js"
    integrity="sha512-t3XNbzH2GEXeT9juLjifw/5ejswnjWWMMDxsdCg4+MmvrM+MwqGhxlWeFJ53xN/SBHPDnW0gXYvBx/afZZfGMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var date;

    $(document).on('click', 'button#by-year', function () {
        $('#data-table-basic1').DataTable().destroy();
        date = $('input[name=select_month]').val();

        if (!date) {
            toast_message_error('Please Select Month and Year');
        } else {
            generate_compliant_report(date);
        }

    });


    function generate_compliant_report(date) {

        $.ajax({
            url: base_url + '/user/act/lls/generate-compliant-report',
            method: 'POST',
            data: {
                date: date
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            beforeSend: function () {
                loader();
            },
            success: function (data) {
                JsLoadingOverlay.hide();
                $('#data-table-basic1').DataTable({
                    responsive: true,
                    ordering: false,
                    processing: true,
                    searchDelay: 500,
                    pageLength: 25,
                    language: {
                        "processing": '<div class="d-flex justify-content-center "><img class="top-logo mt-4" src="{{asset("assets/img/dts/peso_logo.png")}}"></div>'
                    },
                    "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: datatables_buttons(),
                    "data": data,

                    columns: [{
                        data: null
                    },
                    {
                        data: null
                    },
                    {
                        data: null
                    },

                    {
                        data: null
                    },
                    {
                        data: null
                    },
                    {
                        data: null
                    },


                    ],
                    columnDefs: [{
                        targets: 0,
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            return '<a href="' + base_url + '/user/lls/establishment/' + row
                                .establishment_id + '">' + row.establishment_name + '</a>'
                        }
                    },
                    {
                        targets: 1,
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            return row.is_compliant.percent;

                        }
                    },
                    {
                        targets: 2,
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            return row.is_compliant.resp == true ? '<span class="badge notika-bg-success">Compliant</span>' : '<span class="badge notika-bg-danger">Not Compliant</span>';

                        }
                    },
                    {
                        targets: -3,
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            return row.is_compliant.total_inside;

                        }
                    },

                    {
                        targets: -2,
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            return row.is_compliant.total_employee;

                        }
                    },
                    {
                        targets: -1,
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            return '<a href="#" data-toggle="modal" data-id="' + row.establishment_id + '" data-establishment-name="' + row.establishment_name + '"  data-target="#survey_modal" class="view_survey">View Survey</a>';

                        }
                    },
                    ]

                });
            },
            error: function (err) {
                toast_message_error('Something Wrong')
            }


        });

    }
    $(document).on('click', 'a.view_survey', function () {
        let id = $(this).data('id');
        var date = $('input[name=select_month]').val();
        $('h2.establishment_name').text('Survey Report - ' + $(this).data('establishment-name'));
        $('h5.survey_date').text(moment(date).format('MMMM YYYY'));
        $('#data-table-basic').DataTable().destroy();
        setTimeout(() => {
            survey(id);
            get_employee(id);
        }, 1000);
    });

    function survey(id) {
        let data = {
            id: id,
            date: date
        }
        $.ajax({
            url: base_url + "/user/act/lls/g-e-s",
            method: 'POST',
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                var table = $('table.survey-information');
                let inside_total = [];
                let outside_total = [];

                if (data.inside.length > 0 || data.outside.length) {
                    $.each(data.inside, function (i, row) {
                        table.find('span.' + 'inside_' + row.nature_of_employment).html(row.count);
                        inside_total.push(row.count);
                    });
                    let inside = total_calc(inside_total);
                    table.find('strong.inside_total').html(inside);
                    $.each(data.outside, function (i, row) {

                        table.find('span.' + 'outside_' + row.nature_of_employment).html(row.count);
                        outside_total.push(row.count);
                    });
                    let outside = total_calc(outside_total);
                    table.find('strong.outside_total').html(outside);
                } else {
                    table.find('span.title1').html('-');
                    table.find('strong.title1').html('-');
                }
            },
            error: function (xhr, status, error) {
                toast_message_error('Something Wrong')
            },
        });

    }


    function get_employee(id) {

        let data = {
            id: id,
            date: date
        }

        table = $('#data-table-basic').DataTable({
            responsive: true,
            ordering: false,
            processing: true,
            searchDelay: 500,
            pageLength: 100,
            language: {
                "processing": '<div class="d-flex justify-content-center "><img class="top-logo mt-4" src="{{asset("assets/img/dts/peso_logo.png")}}"></div>'
            },
            ajax: {
                url: base_url + "/user/act/lls/g-s-e-l",
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: "",
                error: function (xhr, textStatus, errorThrown) {
                    toast_message_error('Employees List is not displaying... Please Reload the Page')
                }
            },
            columns: [

                {
                    data:  'full_name'
                },
                {
                    data: null
                },
                {
                    data: 'full_address'
                },
                {
                    data: 'position'
                },
                {
                    data: null
                },
                // {
                //     data: 'status_of_employment'
                // },
                {
                    data: 'start_date'
                },
                {
                    data: 'end_date'
                },


            ],

            columnDefs: [

               
                {
                    targets: 1,
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function (data, type, row) {
                        return capitalizeFirstLetter(row.gender);

                    }
                },

                {
                    targets: 4,
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function (data, type, row) {
                        return capitalizeFirstLetter(row.nature_of_employment);

                    }
                },


            ]

        });



    }

    $(function () {
        
        $('button.print').on('click', function () {
            
            $.print("#printable");
            
        });
        
    });


    function total_calc(total) {
        return total.reduce((a, b) => a + b, 0);
    }
</script>

@endsection