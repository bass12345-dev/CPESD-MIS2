@extends('systems.lls_whip.whip.' . session('user_type') . '.layout.' . session('user_type') . '_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            @include('systems.lls_whip.whip.user.pages.project_monitoring.view_monitoring.sections.monitoring_information')
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <button class="btn btn-warning refresh-data">Refresh</button>
                <a href="javascript:;" class="btn btn-success generate-report">Generate Report</a>
                <div class="row">
                    @include('systems.lls_whip.whip.user.pages.project_monitoring.view_monitoring.sections.nature_chart')
                </div>
                <div class="row">
                    @include('systems.lls_whip.whip.user.pages.project_monitoring.view_monitoring.sections.count_nature_table')
                </div>
                <div class="row">
                    @include('systems.lls_whip.whip.user.pages.project_monitoring.view_monitoring.sections.percentage')
                </div>

            </div>
        </div>
        <hr>
        <div class="row">
            @include('systems.lls_whip.whip.user.pages.project_monitoring.view_monitoring.sections.employee_table')
        </div>
    </div>
</div>
@include('systems.lls_whip.whip.user.pages.project_monitoring.view_monitoring.modals.add_update_employee_modal')
@endsection
@section('js')
@include('systems.lls_whip.includes.custom_js.typeahead_search_employee')

<script>
   
   var information_table = $('#table-information');
    $(document).on('click', 'button.edit-information', function () {

        information_table.find('textarea').removeClass('hidden');
        information_table.find('input[name=date_of_monitoring]').prop("type", "date");
        information_table.find('select').attr('hidden', false)
        information_table.find('span.title1').attr('hidden', true);
        $('.cancel-edit').removeClass('hidden');
        $('.submit').removeClass('hidden');
        $(this).addClass('hidden');
    });

    $(document).on('click', 'button.cancel-edit', function () {
        information_table.find('textarea').addClass('hidden');
        information_table.find('input[name=date_of_monitoring]').prop("type", "hidden");
        information_table.find('span.title1').attr('hidden', false);
        information_table.find('select').attr('hidden', true)
        $(this).addClass('hidden');
        $('.submit').addClass('hidden');
        $('button.edit-information').removeClass('hidden');
    });
    $(document).ready(function () {
        $('button.edit-information').prop('disabled', false);
    });
    $(document).on('click', 'button.submit', function () {
        let form = {
            project_monitoring_id: $('input[name=project_monitoring_id]').val(),
            date_of_monitoring: $('input[name=date_of_monitoring]').val(),
            specific_activity: $('textarea[name=specific_activity]').val(),
            annotations: $('textarea[name=annotations]').val(),
        }

        $.ajax({
            url: base_url + '/user/act/whip/u-p-m',
            method: 'POST',
            data: form,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            beforeSend: function () {
                $('button.submit').prop('disabled', true);
                $('button.submit').html('<span class="loader"></span>')
            },
            success: function (data) {
                if (data.response) {
                    toast_message_success(data.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            },
            error: function (err) {
                toast_message_error('Server Error');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            }


        });
    });



    $('#add_update_form').on('submit', function (e) {
        e.preventDefault();

        $(this).find('button[type="submit"]').prop('disabled', true);
        $(this).find('button[type="submit"]').html('<span class="loader"></span>')
        var url = '/user/act/whip/i-u-p-e';
        let form = $('#add_update_form');
        var status = $('select[name=employment_status] :selected').val();

        if (!form.find('input[name=project_employee_id]').val()) {
            _insertAjax(url, form, table);
        } else {
            _updatetAjax(url, form, table);

        }
    });

    $(document).on('click', 'button.add-employee', function () {
        $('h2.title').text('Add Employee');
        $('form#add_update_form')[0].reset();
        $('input[name=employee]').val($(this).data('employee-name')).attr('disabled', false);
    });



    $(document).ready(function () {
        table = $('#data-table-basic').DataTable({
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
            ajax: {
                url: base_url + "/user/act/whip/g-a-p-e",
                method: 'POST',
                data: {
                    id: $('input[name=project_monitoring_id]').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                dataSrc: "",
                error: function (xhr, textStatus, errorThrown) {
                    toast_message_error('Employees List is not displaying... Please Reload the Page')
                }
            },
            columns: [{
                data: 'project_employee_id'
            },
            {
                data: 'i'
            },

            {
                data: null
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
            {
                data: 'status_of_employment'
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
            'select': {
                'style': 'multi',
            },
            columnDefs: [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            },
            {
                targets: 2,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return '<a href="' + base_url + '/admin/lls/employee/' + row.employee_id +
                        '">' + row.full_name + '</a>';

                }
            },
            {
                targets: 3,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return capitalizeFirstLetter(row.gender);

                }
            },

            {
                targets: 6,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return capitalizeFirstLetter(row.nature_of_employment);

                }
            },
            {
                targets: -3,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    var result = row.level_of_employment.replaceAll('_', ' ');
                    return capitalizeFirstLetter(result);

                }
            },

            {
                targets: -2,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return capitalizeFirstLetter(row.location_status);

                }
            },

            {
                targets: -1,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    //return '<button class="btn btn-success">Update</button> <button class="btn btn-success">Delete</button>';
                    return '<div class="actions">\
                                <div ><button class="btn btn-success update-project-employee" data-toggle="modal" data-target="#add_employee_modal" \
                                data-id="' + row.project_employee_id + '"\
                                data-employee-id="' + row.employee_id + '"\
                                data-employee-name="' + row.full_name + '"\
                                data-nature="' + row.nature_of_employment + '"\
                                data-position="' + row.position_id + '"\
                                data-status="' + row.status_id + '"\
                                data-start="' + row.start_date + '"\
                                data-end="' + row.end_date + '"\
                                data-level="' + row.level_of_employment + '"\
                                data-address = "' + row.full_address + '"\
                                data-location-status = "' + row.location_status + '"\
                                ><i class="fas fa-pen"></i></button> </div>\
                                </div>\
                                ';
                }
            }
            ]

        });


    });

    //UpdateoNClick
    $(document).on('click', 'button.update-project-employee', function () {
        $('form#add_update_form').find('input[name=project_employee_id]').val($(this).data('id'));
        var status = $(this).data('status');
        $('input[name=employee_id]').val($(this).data('employee-id'))
        $('input[name=employee]').val($(this).data('employee-name')).attr('disabled', true);
        $('h2.title').text($(this).data('employee-name'));
        $('select[name=employment_nature]').val($(this).data('nature'));
        $('select[name=position]').val($(this).data('position'));
        $('select[name=employment_status]').val(status);
        $('select[name=employment_level]').val($(this).data('level'));
        $('input[name=address]').val($(this).data('address'));
        $('select[name=location_status]').val($(this).data('location-status'));
    });

    $('button#multi-delete').on('click', function () {
        var button_text = 'Delete selected items';
        var text = '';
        var url = '/user/act/whip/d-p-e';
        let items = get_select_items_datatable();
        var data = {
            id: items,
        };

        if (items.length == 0) {
            toast_message_error('Please Select at Least One')
        } else {
            delete_item(data, url, button_text, text, table);

        }

    });

    var chart_inside;
    var chart_outside;
    var id = $('input[name=project_monitoring_id]').val();
    var project_id = $('input[name=project_id]').val();

    function load_skilled_inside_chart() {

       
        $.ajax({
            url: base_url + "/user/act/whip/g-n-e-i",
            method: 'POST',
            data: {
                id: id,
                project_id: project_id
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            beforeSend :function(){
                $('.submit-loader').removeClass('hidden');
            },
            success: function (data) {
                $('.submit-loader').addClass('hidden');
                try {
                 chart_inside =    new Chart(document.getElementById("inside-skilled-chart"), {
                        type: 'pie',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: '',
                                backgroundColor: data.color,
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.total
                            },]
                        },

                    });
                } catch (error) {

                }
            },
            error: function (xhr, status, error) {

                toast_message_error('Nature of Employment Pie Chart is not displaying... Please Reload the Page')

            },
        });
    }

    function load_skilled_outside_chart() {


        $.ajax({
            url: base_url + "/user/act/whip/g-n-e-o",
            method: 'POST',
            data: {
                id: id,
                project_id: project_id
            },
            dataType: 'json',
            beforeSend :function(){
                $('.submit-loader').removeClass('hidden');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                $('.submit-loader').addClass('hidden');
                try {
                 chart_outside =    new Chart(document.getElementsByClassName("outside-skilled-chart"), {
                        type: 'pie',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: '',
                                backgroundColor: data.color,
                             
                                data: data.total
                            },]
                        },

                    });
                } catch (error) {

                }
            },
            error: function (xhr, status, error) {

                toast_message_error('Nature of Employment Pie Chart is not displaying... Please Reload the Page')

            },
        });
    }
    function get_total(){

        $.ajax({
            url: base_url + "/user/act/whip/g-s-u-t",
            method: 'POST',
            data: {
                id: id,
                project_id: project_id
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                var table = $('#nature_table');
                let total = 0;
                let skilled_percentage = 0;
                let unskilled_percentage = 0;
                let arr = [];
                $.each(data, function(index,row){
                    table.find('.' + row.nature_of_employment).html(row.count_nature);
                    total += row.count_nature;
                    let obj = {
                        'count' : row.count_nature,
                        'name' : row.nature_of_employment,
                    }
                    arr.push(obj);
                    
                });
                
              
                $.map( arr, function( val, i ) {
                   $('.total_'+val.name).html(parseFloat(val.count / total * 100).toFixed(2)+' %');
                });
              
                table.find('.total_workers').html(total);

            
            },
            error: function (xhr, status, error){

                toast_message_error('Count Total is not displaying... Please Reload the Page')

            },
        });

    }


    $(document).on('click','button.refresh-data', function(){
        chart_inside.destroy();
        chart_outside.destroy();
        setTimeout(() => {
            get_total();
            load_skilled_outside_chart();
            load_skilled_inside_chart();
        }, 1000);
       
    });
    get_total();
    load_skilled_outside_chart();
    load_skilled_inside_chart();
</script>

@include('systems.lls_whip.includes.custom_js.whip_generate_report')
@endsection