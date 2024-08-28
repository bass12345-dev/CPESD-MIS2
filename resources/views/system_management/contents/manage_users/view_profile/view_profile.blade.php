@extends('system_management.layout.system_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
<div class="row">
   <div class="col-6 col-md-6">
        @include('system_management.contents.manage_users.view_profile.sections.user_information')
   </div>
   <div class="col-6 col-md-6">
        @include('system_management.contents.manage_users.view_profile.sections.system_authorize')
   </div>
</div>

@endsection
@section('js')
<script>
	table = null;
    $('#authorized_form').on('submit', function(e){
	e.preventDefault();
	items = [];
	$("input[name=system_id]:checked").map(function(item){
		items.push($(this).val());
	});
	var user_id = $('input[name=user_id]').val();
	var url = '/admin/sysm/act/a-s';
	let data = {
				id : items,
				user_id : user_id
	};
	$(this).find('button').attr('disabled',true);
	$.ajax({
            url: base_url + '/admin/sysm/act/a-s',
            method: 'POST',
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            beforeSend: function () {
                $('button.submit').prop('disabled', true);
                $('button.submit').html('Please Wait')
            },
            success: function (data) {
                if (data.response) {
                    toast_message_success(data.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            },
            error: function (err) {
                toast_message_error('Server Error');
               
            }


        });


});



</script>

@endsection
