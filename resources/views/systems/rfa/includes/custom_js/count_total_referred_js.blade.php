<script>
    function count_total_reffered_rfa() {
        $.ajax({
            type: "GET",
            url: base_url + '/user/act/rfa/count-reffered-rfa',
            cache: false,
            dataType: 'text',
            success: function (data) {
                $('.count_reffered_rfa').text(data);
            }
        })
    }

    $(document).ready(function () {

        count_total_reffered_rfa();

    });

</script>