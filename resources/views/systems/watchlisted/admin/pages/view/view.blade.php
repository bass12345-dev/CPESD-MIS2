@extends('systems.watchlisted.admin.layout.admin_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
<div class="row">
	<div class="col-md-7">
		@include('systems.watchlisted.both.view.info')
	</div>
	<div class="col-md-5">
		@include('systems.watchlisted.both.view.program_block')
	</div>
</div>
<div class="row">
	<div class="col-md-7">
		@include('systems.watchlisted.both.view.records_table')
	</div>

	<div class="col-md-5">
		@include('systems.watchlisted.both.view.add_form')
	</div>
</div>

@include('systems.watchlisted.admin.pages.view.sections.off_canvas')
@include('systems.watchlisted.admin.pages.view.sections.update_canvas')

@endsection
@section('js')
@include('systems.watchlisted.includes.custom_js.info_js')
<script>

	$('#program_form').on('submit', function (e) {
		e.preventDefault();
		items = [];
		$("input[name=program_id]:checked").map(function (item) {
			items.push($(this).val());

		});
		var person_id = $('input[name=person_id]').val();
		var url = '/admin/act/watchlisted/s-p-p';
		var data = {
			id: items,
			person_id: person_id
		};

		$.ajax({
			url: base_url + url,
			method: 'POST',
			data: data,
			dataType: 'json',
			beforeSend: function () {
				$('#program_form').find('button').attr('disabled', true);
				loader();
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			},
			success: function (data) {
				JsLoadingOverlay.hide();
				if (data.response) {
					setTimeout(reload_page, 2000)
					toast_message_success(data.message);
				} else {
					toast_message_error(data.message);
				}

				$('#program_form').find('button').attr('disabled', false);
			},
			error: function () {
				alert('something Wrong');
				location.reload();
				JsLoadingOverlay.hide();
			}

		});

	});


	$('#update_information').on('submit', function (e) {
		e.preventDefault();

		var url = '/admin/act/watchlisted/update-info';
		var form = $('#update_information').serialize();
		$.ajax({
			url: base_url + url,
			method: 'POST',
			data: form,
			dataType: 'json',
			beforeSend: function () {
				$('#update_information').find('button').attr('disabled', true);
				loader();
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			},
			success: function (data) {
				JsLoadingOverlay.hide();
				if (data.response) {
					
					toast_message_success(data.message);
				} else {
					toast_message_error(data.message);
				}
				setTimeout(reload_page, 2000)
				$('#update_information').find('button').attr('disabled', false);
			},
			error: function () {
				alert('something Wrong');
				// location.reload();
				JsLoadingOverlay.hide();
			}

		});
	});


</script>
@endsection