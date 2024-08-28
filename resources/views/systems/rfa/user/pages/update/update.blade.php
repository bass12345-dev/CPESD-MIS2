<!doctype html>
<html class="no-js" lang="en">

<head>
    @include('global_includes.meta')
    @include('systems.rfa.includes.css')
</head>

<body>
    @include('components.pmas_rfa.preloader')
    <div class="page-container sbar_collapsed">
        <div class="main-content">
            @include('systems.rfa.includes.components.add_rfa_topbar')
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-12 mt-3">
                        <section class="wizard-section" style="background-color: #fff;">
                            <div class="row no-gutters">
                                @include('systems.rfa.user.pages.update.sections.view_rfa')
                                @include('systems.rfa.user.pages.add.sections.form')
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        @include('systems.rfa.user.pages.add.modal.search_name_modal')
        @include('systems.rfa.user.pages.add.modal.add_client_modal')
        @include('systems.rfa.user.pages.add.modal.view_client_information_modal')
</body>
@include('global_includes.js.global_js')
@include('systems.rfa.includes.js')
@include('systems.rfa.includes.custom_js.layout_js')
@include('global_includes.js.custom_js.wizard_js')
@include('global_includes.js.custom_js.alert_loader')
<script>

    function load_rfa_data() {

        $.ajax({
            type: "POST",
            url: base_url + '/user/act/rfa/get-rfa-data',
            data: { 'id': $('input[name=rfa_id]').val() },
            cache: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {

                $('.reference_no').text(data.ref_number)
                $('.name_of_client').text(data.client_name)
                $('.type_of_request').text(data.type_of_request_name)
                $('.type_of_transaction').text(data.type_of_transaction)
                $('.date_and_time').text(data.date_time_filed)


                $('input[name=reference_number]').val(data.number);
                $('input[name=month]').val(data.month);
                $('input[name=year]').val(data.year);
                $('input[name=client_id]').val(data.client_id);
                $('input[name=name_of_client]').val(data.client_name);

                $('select[name=type_of_request]').val(data.tor_id);
                $('select[name=type_of_transaction]').val(data.type_of_transaction);

                if (data.type_of_transaction == 'simple') {

                    $('#refer_to').attr('hidden', false);
                }

                $('select[name=refer_to_id]').val(data.reffered_to);

            },

            error: function (xhr, error) {

                alert('Server Error!')

            }

        })


    }




    $('#add_rfa_form').on('submit', function (e) {
        e.preventDefault();
        if ($('input[name=client_id]').val() == '') {
            alert('Error');
        } else {
            Swal.fire({
                title: "",
                text: "Review first before submitting",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then(function (result) {
                if (result.value) {
                    var button = $('.btn-add-rfa');
                    $.ajax({
                        type: "POST",
                        url: base_url + '/user/act/rfa/update-rfa',
                        data: $('#add_rfa_form').serialize(),
                        dataType: 'json',
                        beforeSend: function () {
                            button.html('<div class="loader"></div>');
                            button.prop("disabled", true);
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (data) {
                            if (data.response) {
                                $('#add_rfa_form')[0].reset();
                                button.prop("disabled", false);
                                button.text('Submit');
                                toast_message_success(data.message)
                                $('a.form-wizard-previous-btn').click();
                                $('#request_table').DataTable().destroy();
                                load_rfa_data();
                            } else {
                                button.prop("disabled", false);
                                button.text('Submit');
                                toast_message_error(data.message)
                                $('a.form-wizard-previous-btn').click();
                            }
                          
                        },
                        error: function (xhr) {
                            alert("Error occured.please try again");
                            button.prop("disabled", false);
                            button.text('Submit');
                            location.reload();
                        },
                    })
                } else if (result.dismiss === "cancel") {
                    swal.close()
                }
            });
        }
    });

    $(document).ready(function () {
        load_rfa_data();
    })

</script>
@include('systems.rfa.user.includes.custom_js.add_update_js')
</html>