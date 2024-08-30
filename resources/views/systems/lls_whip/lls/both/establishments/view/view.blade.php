@extends('systems.lls_whip.lls.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        @include('components.lls.header_title_container')
        <div class="row">
            @include('systems.lls_whip.lls.both.establishments.view.sections.information')

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="row">
                    <button class="btn btn-primary refresh-charts">Refresh</button>
                </div>
                <div class="row">@include('systems.lls_whip.lls.both.establishments.view.sections.gender_charts')</div>
                <div class="row">@include('systems.lls_whip.lls.both.establishments.view.sections.positions_charts')</div>
            </div>
        </div>
        <hr>
        <div class="row">@include('systems.lls_whip.lls.both.establishments.view.sections.employee_table')</div>
    </div>
</div>
@include('systems.lls_whip.lls.both.establishments.view.modals.add_update_employee')
@endsection
@section('js')
<script>
    var information_table = $('#table-information');
    var year_now;
    var chart1;
    var chart2;
    var chart3;
    $(document).on('click', 'button.refresh-charts', function () {
        reload_graph();
    });

    function reload_graph(){

        loader();
        setTimeout(() => {
            JsLoadingOverlay.hide();
            if (chart1) chart1.destroy();
            if (chart2) chart2.destroy();
            if (chart3) chart3.destroy();
            load_positions_chart();
            load_gender_outside_chart();
            load_gender_inside_chart();
        }, 2000);

    }
    //Information

    $(document).on('click', 'button.edit-information', function () {

        information_table.find('input[type=hidden]').prop("type", "text");
        information_table.find('select').attr('hidden', false)
        information_table.find('span.title').attr('hidden', true);
        $('.cancel-edit').removeClass('hidden');
        $('.submit').removeClass('hidden');
        $(this).addClass('hidden');
    });

    $(document).on('click', 'button.cancel-edit', function () {
        information_table.find('input[type=text]').prop("type", "hidden");
        information_table.find('span.title').attr('hidden', false);
        information_table.find('select').attr('hidden', true)
        $(this).addClass('hidden');
        $('.submit').addClass('hidden');
        $('button.edit-information').removeClass('hidden');
    });
    $(document).ready(function () {
        $('button.edit-information').prop('disabled', false);
    });
    $(document).on('click', 'button.add-employee', function () {
        $('form#add_update_form')[0].reset();
    })

    $(document).on('click', 'button.submit', function () {
        let form = {
            establishment_id: $('input[name=establishment_id]').val(),
            establishment_name: $('input[name=establishment_name]').val(),
            street: $('input[name=street]').val(),
            barangay: $('select[name=barangay] :selected').val(),
            contact_number: $('input[name=phone_number]').val(),
            email_address: $('input[name=email_address]').val(),
            authorized_personnel: $('input[name=authorized_personnel]').val(),
            status: $('select#select_status :selected').val(),
            position: $('input[name=position]').val(),
        }

        $.ajax({
            url: base_url + '/user/act/lls/u-e',
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
                alert('Something Wrong')
            }


        });
    });


    //Employees


    $('#add_update_form').on('submit', function (e) {
        e.preventDefault();

        $(this).find('button[type="submit"]').prop('disabled', true);
        $(this).find('button[type="submit"]').html('<span class="loader"></span>')
        var url = '/user/act/lls/i-u-e-e';
        let form = $(this);
        var status = $('select[name=employment_status] :selected').val();

        if (!form.find('input[name=establishment_employee_id]').val()) {
            _insertAjax(url, form, table);

        } else {
            _updatetAjax(url, form, table);

        }
        reload_graph();

    });

    $(document).on('click', 'button.update-establishment-employee', function () {
        $('form#add_update_form').find('input[name=establishment_employee_id]').val($(this).data('id'));
        var status = $(this).data('status');
        $('input[name=employee_id]').val($(this).data('employee-id'))
        $('input[name=employee]').val($(this).data('employee-name')).attr('disabled', true);
        $('h2.title').text($(this).data('employee-name'));
        $('select[name=employment_nature]').val($(this).data('nature'));
        $('select[name=position]').val($(this).data('position'));
        $('select[name=employment_status]').val(status);
        $('select[name=employment_level]').val($(this).data('level'));
        $('input[name=start]').val(moment($(this).data('start')).format('YYYY-MM'));
        var end = $(this).data('end') === '-' ? '' : $(this).data('end');
        $('input[name=end]').val(moment(end).format('YYYY-MM'));
        if (status != 5) {
            $('input[name=end]').prop('required', true);
        } else {
            $('input[name=end]').prop('required', false);
        }
    });

    $('button#multi-delete').on('click', function() {
        var button_text = 'Delete selected items';
        var text = '';
        var url = '/user/act/lls/d-e-e';
        let items = get_select_items_datatable();
        var data = {
            id: items,
        };

        if (items.length == 0) {
            toast_message_error('Please Select at Least One')
        } else {
            delete_item(data, url, button_text, text, table);
            year_now = $('select#select_year :selected').val();
           reload_graph();
        }

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
                url: base_url + "/user/act/lls/g-a-e-e",
                method: 'POST',
                data: {
                    id: $('input[name=establishment_id]').val(),
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
                data: 'establishment_employee_id'
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
                data: 'start_date'
            },
            {
                data: 'end_date'
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
                targets: 1,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return '<a href="' + base_url + '/admin/lls/employee/' + row.employee_id +
                        '">' + row.full_name + '</a>';

                }
            },
            {
                targets: 2,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return capitalizeFirstLetter(row.gender);

                }
            },

            {
                targets: 5,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return capitalizeFirstLetter(row.nature_of_employment);

                }
            },
            {
                targets: -2,
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    var result = row.level_of_employment.replaceAll('_', ' ');
                    return capitalizeFirstLetter(result);

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
                                <div ><button class="btn btn-success update-establishment-employee" data-toggle="modal" data-target="#add_employee_modal" \
                                data-id="' + row.establishment_employee_id + '"\
                                data-employee-id="' + row.employee_id + '"\
                                data-employee-name="' + row.full_name + '"\
                                data-nature="' + row.nature_of_employment + '"\
                                data-position="' + row.position_id + '"\
                                data-status="' + row.status_id + '"\
                                data-start="' + row.start_date + '"\
                                data-end="' + row.end_date + '"\
                                data-level="' + row.level_of_employment + '"\
                                ><i class="fas fa-pen"></i></button> </div>\
                                </div>\
                                ';
                }
            }
            ]

        });
    });


    function load_gender_inside_chart() {

        $.ajax({
            url: base_url + "/user/act/lls/g-g-e-i",
            method: 'POST',
            data: {
                id: $('input[name=establishment_id]').val(),
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
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
                            },]
                        },

                    });
                } catch (error) {

                }
            },
            error: function (xhr, status, error) {

                toast_message_error('Gender Pie Chart is not displaying... Please Reload the Page')

            },
        });
    }

    function load_gender_outside_chart() {

        var id = $('input[name=establishment_id]').val();

        $.ajax({
            url: base_url + "/user/act/lls/g-g-e-o",
            method: 'POST',
            data: {
                id: $('input[name=establishment_id]').val(),
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                try {
                    chart2 = new Chart(document.getElementById("outside-gender-chart"), {
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
                } catch (error) { }
            },
            error: function (xhr, status, error) {

                toast_message_error('Gender Pie Chart is not displaying... Please Reload the Page')
            },
        });
    }

    function load_positions_chart() {



        $.ajax({
            url: base_url + "/user/act/lls/g-e-p",
            method: 'POST',
            data: {
                id: $('input[name=establishment_id]').val(),
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                try {
                    chart3 = new Chart(document.getElementById("positions-chart"), {
                        type: 'bar',
                        data: {
                            labels: data.label,
                            datasets: [{
                                label: '',
                                backgroundColor: '#222E3C',
                                borderColor: 'rgb(23, 125, 255)',
                                data: data.total
                            },]
                        },

                    });
                } catch (error) { }
            },
            error: function (xhr, status, error) {

                toast_message_error('Position Bar Chart is not displaying... Please Reload the Page')
            },
        });
    }




    $(document).ready(function () {
        load_gender_outside_chart();
        load_gender_inside_chart();
        load_positions_chart();
    });

    

</script>

@include('systems.lls_whip.includes.custom_js.lls_typeahead_search_employee')
@endsection