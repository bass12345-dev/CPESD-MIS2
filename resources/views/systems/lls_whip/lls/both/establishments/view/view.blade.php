@extends('systems.lls_whip.lls.user.layout.user_master')
@section('title', $title)
@section('content')
<div class="notika-status-area">
    <div class="container">
        @include('components.lls.header_title_container')
        <div class="row">
            @include('systems.lls_whip.lls.both.establishments.view.sections.information')
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    var information_table = $('#table-information');
    $(document).on('click', 'button.edit-information', function () {

        information_table.find('input[type=hidden]').prop("type", "text");
        information_table.find('select').attr('hidden', false)
        information_table.find('span.title').attr('hidden', true);
        $('.cancel-edit').removeClass('hidden');
        $('.submit').removeClass('hidden');
        $(this).addClass('hidden');
    });

    $(document).on('click', 'button.cancel-edit', function () {
        information_table.find('input[type=text]').prop("type", "hidden");
        information_table.find('span.title').attr('hidden', false);
        information_table.find('select').attr('hidden', true)
        $(this).addClass('hidden');
        $('.submit').addClass('hidden');
        $('button.edit-information').removeClass('hidden');
    });
    $(document).ready(function() {
        $('button.edit-information').prop('disabled', false);
    });


    $(document).on('click', 'button.submit', function() {
        let form = {
            establishment_id: $('input[name=establishment_id]').val(),
            establishment_name: $('input[name=establishment_name]').val(),
            street: $('input[name=street]').val(),
            barangay: $('select[name=barangay] :selected').val(),
            contact_number: $('input[name=phone_number]').val(),
            email_address: $('input[name=email_address]').val(),
            authorized_personnel: $('input[name=authorized_personnel]').val(),
            status: $('select#select_status :selected').val(),
            position: $('input[name=position]').val(),
        }

        $.ajax({
            url: base_url + '/user/act/lls/u-e',
            method: 'POST',
            data: form,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            beforeSend: function() {
                $('button.submit').prop('disabled', true);
                $('button.submit').html('<span class="loader"></span>')
            },
            success: function(data) {
                if (data.response) {
                    toast_message_success(data.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            },
            error: function(err) {
                alert('Something Wrong')
            }


        });
    });


</script>
@endsection