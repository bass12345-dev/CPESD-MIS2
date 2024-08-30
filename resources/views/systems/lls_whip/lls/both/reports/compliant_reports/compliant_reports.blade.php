@extends('system.lls_whip.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @include('system.lls_whip.user.lls.reports.compliant_reports.sections.table')
            </div>
        </div>
    </div>
</div>
@include('system.lls_whip.user.lls.reports.survey_reports.modals.survey_reports_modal')
@endsection
@section('js')

<script>
    var date;

    $(document).on('click', 'button#by-year', function() {
        $('#data-table-basic').DataTable().destroy();
        date = $('input[name=select_month]').val();
        if (!date) {
            toast_message_error('Please Select Month and Year');
        } else {
            generate_compliant_report(date);
        }

    });


    function generate_compliant_report(date) {

        $.ajax({
            url: base_url + '/admin/act/lls/generate-compliant-report',
            method: 'POST',
            data: {
                date: date
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            beforeSend: function() {
                JsLoadingOverlay.show({
                    'overlayBackgroundColor': '#666666',
                    'overlayOpacity': 0.6,
                    'spinnerIcon': 'pacman',
                    'spinnerColor': '#000',
                    'spinnerSize': '2x',
                    'overlayIDName': 'overlay',
                    'spinnerIDName': 'spinner',
                });
            },
            success: function(data) {
                JsLoadingOverlay.hide();
                $('#data-table-basic').DataTable({
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
                            render: function(data, type, row) {
                                return '<a href="' + base_url + '/admin/lls/establishment/' + row
                                    .establishment_id + '">' + row.establishment_name + '</a>'
                            }
                        },
                        {
                            targets: 1,
                            data: null,
                            orderable: false,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return row.is_compliant.percent;

                            }
                        },
                        {
                            targets: 2,
                            data: null,
                            orderable: false,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return row.is_compliant.resp == true ? '<span class="badge notika-bg-success">Compliant</span>' : '<span class="badge notika-bg-danger">Not Compliant</span>';

                            }
                        },
                        {
                            targets: -3,
                            data: null,
                            orderable: false,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return row.is_compliant.total_inside;

                            }
                        },

                        {
                            targets: -2,
                            data: null,
                            orderable: false,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return row.is_compliant.total_employee;

                            }
                        },
                        {
                            targets: -1,
                            data: null,
                            orderable: false,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return '<a href="#" data-toggle="modal" data-id="' + row.establishment_id + '" data-establishment-name="' + row.establishment_name + '"  data-target="#survey_modal" class="view_survey">View Survey</a>';

                            }
                        },
                    ]

                });
            },
            error: function(err) {
                toast_message_error('Something Wrong')
            }


        });

    }
    $(document).on('click', 'a.view_survey', function() {
        let id = $(this).data('id');
        $('h2.establishment_name').text('Survey Report - ' + $(this).data('establishment-name'));
        setTimeout(() => {
            survey(id);
        }, 1000);
    });

    function survey(id){
        let data = {
            id: id,
            date: date
        }
        $.ajax({
            url: base_url + "/admin/act/lls/g-e-s",
            method: 'POST',
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(data) {
                var table = $('table.survey-information');
                let inside_total = [];
                let outside_total = [];
                if(data.inside.length > 0 || data.outside.length) {
                $.each(data.inside, function(i, row) {
                    table.find('span.' + 'inside_' + row.nature_of_employment).html(row.count);
                    inside_total.push(row.count);
                });
                let inside = total_calc(inside_total); 
                table.find('strong.inside_total').html(inside);
                $.each(data.outside, function(i, row) {
                    table.find('span.' + 'outside_' + row.nature_of_employment).html(row.count);
                    outside_total.push(row.count);
                });
                let outside = total_calc(outside_total); 
                table.find('strong.outside_total').html(outside);
                }else {
                    table.find('span.title1').html('-');
                    table.find('strong.title1').html('-');
                }
            },
            error: function(xhr, status, error) {
                toast_message_error('Something Wrong')
            },
        });

    }

    function total_calc(total) {
        return total.reduce((a, b) => a + b, 0);
    }
</script>

@endsection