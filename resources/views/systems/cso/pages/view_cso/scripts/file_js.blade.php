<script>
    $(document).on('click', 'a.update_file', function () {
        const type = $(this).data('type');
        const file_title = $(this).data('title');
        $('#update_files_form').find('input[name=file_type]').val(type);
        $('#update_files_form').find('label.file_title').text(file_title);
        $('h5.modal_file_title').text('Update ' + file_title);
    });
    $('#update_files_form').on('submit', function (e) {
        e.preventDefault();

        let form = new FormData(this);
        let type = $(this).find('input[name=file_type]').val();
        let save_btn = $('button.save_file_button');
        var url = '/user/act/cso/upload-cso-file';
        _ajax_file(url, form, save_btn);
    });

    function _ajax_file(url = '', form, save_btn = '') {

        var startTime = new Date().getTime();
        var xhr = $.ajax({
            xhr: function () {
                var xhr = new XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (e) {
                    if (e.lengthComputable) {
                        var percentComplete = ((e.loaded / e.total) * 100);
                        $("#percent").html(Math.floor(percentComplete) + '%');
                        $(".progress-bar").width(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },

            type: "POST",
            url: base_url + url,
            data: form,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            beforeSend: function () {
                $('.prog_cent').attr('hidden', false);
                save_btn.html('<div class="loader"></div>');
                save_btn.prop("disabled", true);
                $("#percent").html('0%');
                $(".progress-bar").width('0%');
            },
            error: function (xhr) { // if error occured
                alert("Error occured.please try again");
                save_btn.prop("disabled", false);
                save_btn.text('Save Changes');
                $('.prog_cent').attr('hidden', true);
            },
            success: function (data) {

                if (data.response) {
                    $('#update_files_modal').modal('hide');
                    save_btn.prop("disabled", false);
                    save_btn.text('Save Changes');
                    toast_message_success(data.message);
                    $('input[name=update_file]').val('')


                } else {
                    save_btn.prop("disabled", false);
                    save_btn.text('Save Changes');
                    toast_message_error(data.message);
                }

                $('.prog_cent').attr('hidden', true);

            }
        });

    }

    function Validate_file(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {

                    var sCurExtension = _validFileExtensions[j];
                    console.log(sCurExtension.length)
                    if (sFileName.substr(sFileName.length - sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;


                    }

                }

                if (!blnValid) {
                    alert("Sorry, " + sFileName + " is invalid, allowed extension is " + _validFileExtensions.join(", ") + ' only');
                    oInput.value = "";
                    return false;


                }
            }
        }
        return true;

    }


    $(document).on('click', 'a.view-pdf', function (e) {

        $.ajax({
            type: "GET",
            url: base_url + '/user/act/cso/get-file?type=' + $(this).data('type') + '&&id='+$('input[name=cso_id]').val(),
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                $('#view_cor').html('<div class="loader"></div>');
                loader();
            },
            success: function (data) {
                if (data.resp) {
                    JsLoadingOverlay.hide();
                    $('#view_file_modal').modal('show');
                    $('.pdf-viewer').html('<iframe src="' + data.file + '" style="width:100%;height:900px;"></iframe>');
                } else {
                    JsLoadingOverlay.hide();
                    toast_message_error(data.message);
                }
                $('#view_cor').html('View COR');

            },
            error: function () {
                alert('Server Error!');
                $('#view_cor').html('View COR');
                JsLoadingOverlay.hide();
            }

        });


    });

</script>