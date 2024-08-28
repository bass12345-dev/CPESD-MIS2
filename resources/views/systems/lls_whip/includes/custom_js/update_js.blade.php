<script>
      var information_table = $('#table-information');
    $(document).on('click', 'button.edit-information', function () {

        information_table.find('textarea').removeClass('hidden');
        information_table.find('input[type=hidden]').prop("type", "text");
        information_table.find('select').attr('hidden', false)
        information_table.find('span.title1').attr('hidden', true);
        $('.cancel-edit').removeClass('hidden');
        $('.submit').removeClass('hidden');
        $(this).addClass('hidden');
    });

    $(document).on('click', 'button.cancel-edit', function () {
        information_table.find('textarea').addClass('hidden');
        information_table.find('input[type=text]').prop("type", "hidden");
        information_table.find('span.title1').attr('hidden', false);
        information_table.find('select').attr('hidden', true)
        $(this).addClass('hidden');
        $('.submit').addClass('hidden');
        $('button.edit-information').removeClass('hidden');
    });

    $(document).ready(function () {
        $('button.edit-information').prop('disabled', false);
    });
</script>