<!DOCTYPE html>
<html lang="en">
<head>
	@include('global_includes.meta')
	@include('systems.dts.includes.css')
</head>
<body>
	<div class="wrapper">
		@include('system_management.layout.includes.system_sidebar')
		<div class="main">
			@include('system_management.layout.includes.system_topbar')
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
@include('global_includes.js.custom_js.datatable_settings')
@include('global_includes.js.custom_js.alert_loader')
@yield('js')

</html>