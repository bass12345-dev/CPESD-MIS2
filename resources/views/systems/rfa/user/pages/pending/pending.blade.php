@extends('systems.rfa.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="row">
    <div class="col-12 mt-5">
        <div class="card" style="border: 1px solid;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn  mb-3 mt-2 sub-button pull-right mr-2" id="reload_user_pending_rfa"> Reload
                            <i class="ti-loop"></i></button>
                    </div>
                </div>
                <div class="row">
                    @include('systems.rfa.user.pages.pending.sections.table')
                </div>
            </div>
        </div>
    </div>
</div>

@include('systems.rfa.user.pages.pending.modals.refer_to_modal')
@endsection
@section('js')

<script>
    $(document).on('click', 'button#reload_user_pending_rfa', function (e) {
        $('#rfa_pending_table').DataTable().destroy();
        load_user_pending_rfa();
        count_total_rfa_pending();
        count_total_reffered_rfa()
    });


    function load_user_pending_rfa() {
        $('#rfa_pending_table').DataTable({
            responsive: false,
            "ordering": false,

            "ajax": {
                "url": base_url + '/user/act/rfa/g-u-p-r',
                "type": "GET",
                "dataSrc": "",
            },

            'columns': [{
                data: "ref_number",
            }, {
                data: "name",
            }, {
                data: "address",
            }, {
                data: "type_of_request_name",
            }, {
                data: "type_of_transaction",
            }, {
                data: "date_time_filed",
            }, {
                data: "status1",
            },
            {
                data: "action1",
            },]
        });
    }

    $(document).on('click', 'a#view_rfa', function (e) {
      window.open(base_url + '/user/rfa/update-rfa/' + $(this).data('id'), '_self');
   });


    $(document).on('click', 'a.update_referred', function (e) {
        $('#update_refer_to_modal').modal('show');
        $('select[name=refer_to_id]').val($(this).data('user-id'));
        $('#update_refer_to_form').find('input[name=rfa_id]').val($(this).data('id'))
    });


    $('#update_refer_to_form').on('submit', function (e) {
        e.preventDefault();
        var button = $('.btn-update-cso-status');

        $.ajax({
            type: "POST",
            url: base_url + '/user/act/rfa/update-referral',
            data: $(this).serialize(),
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                button.text('Please wait...');
                button.attr('disabled', 'disabled');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                if (data.response) {

                    button.text('Update');
                    button.removeAttr('disabled');
                    toast_message_success(data.message);
                    $('#update_refer_to_modal').modal('hide');
                    $('#rfa_pending_table').DataTable().destroy();
                    load_user_pending_rfa();

                } else {

                    button.text('Update');
                    button.removeAttr('disabled');
                    toast_message_error(data.message);

                }
            },
            error: function (xhr) { // if error occured
                alert("Error occured.please try again");
                button.text('Update');
                button.removeAttr('disabled');
            },


        });

    });


    $(document).ready(function () {
        load_user_pending_rfa();
    });




</script>
@endsection