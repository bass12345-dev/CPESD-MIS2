<script>
        $(document).on('click', 'a.message', function () {
        var id = $(this).data('id');
        $('input[name=project_monitoring_id]').val(id);
        
        load_message(id);
    });
    $('#add_remarks_form').on('submit', function (e) {
        e.preventDefault();
        var url = "/user/act/whip/add-remarks";
        var form = $(this).serialize();
        $.ajax({
            url: base_url + url,
            method: 'POST',
            data: form,
            dataType: 'json',
            beforeSend: function () {
                $('#add_remarks_form').find('button').attr('disabled', true);
                loader();
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                JsLoadingOverlay.hide();
                if (data.response) {

                    toast_message_success(data.message);
                    $('textarea[name=remarks]').val('');
                    load_message($('input[name=project_monitoring_id]').val());
                } else {
                    toast_message_error(data.message);
                }

                $('#add_remarks_form').find('button').attr('disabled', false);

            },
            error: function () {
                alert('something Wrong');
                JsLoadingOverlay.hide();
                $('#add_remarks_form').find('button').attr('disabled', false);
            }

        });
    });

    $(document).on('click', 'a.refresh', function(){
        load_message($('input[name=project_monitoring_id]').val());
        $(this).text('loading..');
    })

    function load_message(id) {
        var url = "/user/act/whip/get-remarks";
        $.ajax({
            url: base_url + url,
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (data) {
                var cont = '';
                $.each(data, function (i, row) {
                    if(row.user == 'me'){
                        cont += ' <li class="clearfix">\
                                <div class="message-data align-right">\
                                    <span class="message-data-name">You</span> <i\
                                        class="fa fa-circle me"></i>\
                                </div>\
                                <div class="message me-message float-right">'+row.remarks+'</div>\
                            </li>';
                    }else if(row.user == 'other'){
                        cont += '<li>\
                                <div class="message-data">\
                                    <span class="message-data-name"><i class="fa fa-circle you"></i>'+row.name+'</span>\
                                </div>\
                                <div class="message you-message">'+row.remarks+'</div>\
                            </li>';
                    }

                    $('a.refresh').text('Refresh');
                });
                $('.chat-ul').html(cont);
            },
            error: function () {

            }

        });


    }

</script>