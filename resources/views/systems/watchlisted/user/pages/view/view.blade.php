@extends('systems.watchlisted.user.layout.user_master')
@section('title', $title)
@section('content')
@include('global_includes.title')
<div class="row">
	<div class="col-md-7">
		@include('systems.watchlisted.both.view.info')
	</div>
</div>
<div class="row">
	<div class="col-md-7">
		@include('systems.watchlisted.both.view.records_table')
	</div>
	<?php
	if (session('user_id') == $person_data->user_id) {
	?>
		<div class="col-md-5">
			@include('systems.watchlisted.both.view.add_form')
		</div>

	<?php } ?>
</div>
@endsection
@section('js')
@include('systems.watchlisted.includes.custom_js.info_js')
<script>

</script>
@endsection