<!DOCTYPE html>
<html lang="en">
<head>
	@include('global_includes.meta')
	@include('systems.lls_whip.includes.css')
</head>
<body>
	@include('systems.lls_whip.whip.includes.header_top_area')
	@include('systems.lls_whip.whip.user.layout.includes.main_menu')
	@include('systems.lls_whip.whip.user.layout.includes.mobile_menu')
	<main class="content">
		@yield('content')
	</main>
</body>
@include('global_includes.js.global_js')
@include('systems.lls_whip.includes.js')
@include('global_includes.js.custom_js.datatable_settings')
@include('global_includes.js.custom_js.alert_loader')
@include('global_includes.js.custom_js._ajax')
@yield('js')
</html>