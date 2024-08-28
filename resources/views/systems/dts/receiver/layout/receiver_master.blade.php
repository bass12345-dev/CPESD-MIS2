<!DOCTYPE html>
<html lang="en">
<head>
	@include('global_includes.meta')
	@include('systems.dts.includes.css')
</head>
<body>
	<div class="wrapper">
		@include('systems.dts.receiver.layout.includes.receiver_sidebar')
		<div class="main">
			@include('systems.dts.includes.components.topbar')
			<main class="content">
				<div class="container-fluid p-0">
					@yield('content')
				</div>
			</main>
		</div>
	</div>
</body>
@include('global_includes.js.global_js')
@include('systems.dts.includes.js')
@yield('js')
@include('systems.dts.includes.custom_js.dts_scripts')
@include('global_includes.js.custom_js.datatable_settings')
@include('global_includes.js.custom_js.alert_loader')
@include('global_includes.js.custom_js._ajax')
</html>