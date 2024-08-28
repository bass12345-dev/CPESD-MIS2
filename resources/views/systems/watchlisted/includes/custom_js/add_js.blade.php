<script>
        $('#add_document').on('submit', function (e) {
		e.preventDefault();
        var url = '/user/act/watchlisted/i-p';
		var form = $(this).serialize();


		Swal.fire({
			title: "Review First Before Submitting",
			text: "",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Submit"
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url + url,
					method: 'POST',
					data: form,
					dataType: 'json',
					beforeSend: function () {
						Swal.showLoading();
						$('#add_document').find('button').attr('disabled', true);

					},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
						'Authorization': '<?php echo config('app.key') ?>'
				      },
					success: function (data) {
						Swal.close();
						$('#add_document')[0].reset();
						$('#add_document').find('button').attr('disabled', false);
						if (data.response) {
							Swal.fire({
								title: data.message,
								text: "",
								icon: "success",
								showCancelButton: true,
								confirmButtonColor: "#3085d6",
								cancelButtonColor: "#d33",
								confirmButtonText: "View Profile"
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.href = base_url + '/{{session("user_type")}}/watchlisted/view_profile/' + data.id;

								} 

							});


						} else {

                            toast_message_error('Server Error');

						}
					},
					error: function () {
						toast_message_error('Server Error');
					}

				});
			}
		});


	});
</script>