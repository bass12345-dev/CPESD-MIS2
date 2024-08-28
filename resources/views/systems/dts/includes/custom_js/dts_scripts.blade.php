<script>
    $(document).on('click', 'a#view_remarks', function() {
        $('#staticBackdrop').modal('show');
        $('.remarks').text($(this).data('remarks'));
    });
    $('input[name=check_all]').on('change', function() {

        var check = $('input[name=check_all]:checked').val();
        if (check == 'true') {
            $('input[name=document_id]').prop('checked', true);
        } else {
            $('input[name=document_id]').prop('checked', false);
        }
    });

    function get_receiver_incoming() {

        const xhr = new XMLHttpRequest();
        xhr.open("GET", base_url + '/user/act/dts/receiver-incoming');
        xhr.send();
        xhr.responseType = "text";
        xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            const data = xhr.response;
            $('span.to_receive').text(data)
        } else {
            toast_message_error(`Error: ${xhr.status}`)
        }
        };


    }

    $(document).ready(function() {
        get_receiver_incoming();
    });

    function view_document(row){
        return '<a href="' + base_url + '/user/dts/view?tn=' + row.tracking_number + '" data-toggle="tooltip" data-placement="top" title="View ' + row.tracking_number + '">' + row.document_name + '</a>';
    }


</script>