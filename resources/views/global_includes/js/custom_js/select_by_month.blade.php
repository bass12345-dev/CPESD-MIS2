<script>
    var month = $('input[name=month]').val();
    jSuites.calendar(document.getElementById('calendar'), {
        type: 'year-month-picker',
        format: 'MMMM-YYYY',
    });
    $(document).on('click', '#by-month', function () {
        month = $('input[name=month]').val();
        table.destroy();
        search(month);
    });

    $(document).on('click', '#all_data', function () {
        table.destroy();
        search(month = null);
    });
</script>