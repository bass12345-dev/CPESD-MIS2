<script>
    var year = $('#admin_year option:selected').val();

    function load_graph($this) {
        load_cso_chart($this.value)
    }
    function load_cso_chart(year) {
        $.ajax({
            url: base_url + '/user/act/cso/cso-activities-data',
            data: {
                year: year,
                cso_id: $('input[name=cso_id]').val()
            },
            method: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            beforeSend: function () {
                loader();
            },
            success: function (data) {
                JsLoadingOverlay.hide();
                var items = '';
                data.label.forEach((row, index) => {
                    items += '<li class="list-group-item ">' + colot_it_red(row) + '</li>';
                });

                $('ul.list-group').html(items)
            },
            error: function (xhr, status, error) { },
        });
    }

    function colot_it_red(activity_text) {
        const myArray = activity_text.split(" - ");
        const activities = myArray[0];
        const number = myArray[1];
        return number == 0 ? activities + ' - ' + '<b><span class="text-danger">' + number + '</span></b>' : activities + ' - ' + number;


    }

</script>