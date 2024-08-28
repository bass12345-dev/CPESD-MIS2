<script>
    function get_cso_information() {

        $.ajax({
            type: "POST",
            url: base_url + '/user/act/cso/get-cso-infomation',
            data: {
                'id': $('input[name=cso_id]').val()
            },
            cache: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                $('.cso_code').text(data.cso_code)
                $('.cso_name').text(data.cso_name)
                $('.cso_address').text(data.address)
                $('.contact_person').text(data.contact_person)
                $('.contact_number').text(data.contact_number)
                $('.telephone_number').text(data.telephone_number)
                $('.email').text(data.email_address)
                $('.classification').html('<span class="status-p sub-button">' + data.type_of_cso + '<span>')
                $('.cso_status').html(data.cso_status + ' ' + '<a href="javascript:;" data-id="' + data.cso_id + '" data-status="' + data.status + '"  id="update-cso-status"  class=" text-center ml-3  btn-rounded  pull-right"><i class = "fa fa-edit" aria-hidden = "true"></i> Update Status</a>')
                $('#update-cso-information').data('id', data.cso_id);



                $('input[name=cso_idd]').val(data.cso_id);
                $('input[name=cso_name]').val(data.cso_name);
                $('input[name=cso_code]').val(data.cso_code);
                // $('#cso_type option[value='+data.type_of_cso.toString().toLowerCase()+']').attr('selected','selected'); 
                $('input[name=purok]').val(data.purok_number);
                $('select[name=barangay]').val(data.barangay);
                $('select[name=cso_type]').val(data.type_of_cso);


                $('input[name=contact_person]').val(data.contact_person);
                $('input[name=contact_number]').val(data.contact_number);
                $('input[name=telephone_number]').val(data.telephone_number);
                $('input[name=email_address]').val(data.email_address);

            }

        })
    }

    $('#update_cso_information_form').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        var url = '/user/act/cso/update-cso-information';
        _updatetAjax(url, form, table = null);
        $('#update_cso_information_modal').modal('hide');
        loader();
        setTimeout(function () {
            JsLoadingOverlay.hide();
            get_cso_information()
        }, 2000);

    });



    // Update CSO STATUS
    $(document).on('click', 'a#update-cso-status', function (e) {
        const id = $(this).data('id');
        const status = $(this).data('status');
        $('#update_cso_status_modal').modal('show');
        $('#cso_status_update option[value=' + status + ']').attr('selected', 'selected');
        $('input[name=cso_id]').val(id);
    });



    $('#update_cso_status_form').on('submit', function (e) {
        e.preventDefault();
        var btn = $('.btn-update-cso-status');
        $.ajax({
            type: "POST",
            url: base_url + '/user/act/cso/update-cso-status',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                btn.text('Please wait...');
                btn.attr('disabled', 'disabled');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                if (data.response) {
                    $('#update_cso_status_modal').modal('hide')
                    btn.text('Save Changes');
                    btn.removeAttr('disabled');
                    toast_message_success(data.message);
                    get_cso_information();
                } else {

                    btn.text('Save Changes');
                    btn.removeAttr('disabled');
                    toast_message_success(data.message);

                }
            },
            error: function (xhr) { // if error occured
                alert("Error occured.please try again");
                btn.text('Save Changes');
                btn.removeAttr('disabled');
            },


        });

    });

</script>