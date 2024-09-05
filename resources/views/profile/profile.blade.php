<!DOCTYPE html>
<html lang="en">

<head>
	@include('global_includes.meta')
	@include('systems.dts.includes.css')
</head>

<body>
	<div class="wrapper">
		<div class="main">
			@include('system_management.layout.includes.system_topbar')
			<main class="content">
				<div class="container-fluid p-0">
					@include('global_includes.title')
					<div class="row">
						@include('profile.sections.profile_table')
					</div>
				</div>
			</main>
		</div>
	</div>
	@include('profile.sections.check_password_modal')
	@include('profile.sections.update_password_modal')
	@include('profile.sections.view_profile_modal')

</body>
@include('global_includes.js.global_js')
@include('systems.dts.includes.js')
@include('global_includes.js.custom_js.alert_loader')
@include('global_includes.js.custom_js._ajax')
@yield('js')
<script>
	$('#update_user_form').on('submit', function(e) {
		e.preventDefault();

		var form = $(this).serialize();
		var id = $('input[name=id]').val();
		var url = '/user/act/update-profile';
		update_item(form, url, table = null);
		$('#update_user_form').find('button').attr('disabled', true);
		setTimeout(() => {
			location.reload();
		}, 7000);
	});

	$('#check_old_password_form').on('submit', function(e) {

		e.preventDefault();

		$.ajax({
			url: base_url + '/user/act/ck',
			method: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			beforeSend: function() {
				Swal.showLoading()
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			},
			success: function(data) {

				if (data.response) {
					Swal.close();
					$('#check_password_modal').modal('hide')
					$('#update_password_modal').modal('show')
				} else {
					Swal.close();
					toast_message_error(data.message);

				}
			},
			error: function() {
				Swal.close();
				alert('something Wrong')
			}

		});

	});

	$('#update_password_form').on('submit', function(e) {
		e.preventDefault();

		var form = $(this).serialize();
		var id = '';
		var url = '/user/act/up';
		update_item(form, url, table = null);
		setTimeout(() => {
			location.reload();
		}, 6000);
		
	});
</script>

</html>