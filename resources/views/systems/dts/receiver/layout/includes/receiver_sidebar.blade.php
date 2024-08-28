<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href="">
			<span class="align-middle">PESO DTS RECEIVER</span>
		</a>
		<ul class="sidebar-nav">
			<?php $segments = Request::segments(); ?>

			<li class="sidebar-header">
				Pages
			</li>

			<li class="sidebar-item <?= $segments[2] == 'dashboard' ? 'active' : '' ?>">
				<a class="sidebar-link" href="{{url('/receiver/dts/dashboard')}}">
					<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
				</a>
			</li>

			<li class="sidebar-item <?= $segments[2] == 'incoming' ? 'active' : '' ?>">
				<a class="sidebar-link" href="{{url('/receiver/dts/incoming')}}">
					<i class="align-middle" data-feather="arrow-left"></i> <span class="align-middle">Incoming</span>
				</a>
			</li>

			<li class="sidebar-item <?= $segments[2] == 'find-document' ? 'active' : '' ?>">
				<a class="sidebar-link" href="{{url('/receiver/dts/find-document')}}">
					<i class="align-middle" data-feather="search"></i> <span class="align-middle">Find Document</span>
				</a>
			</li>


			
		</ul>
	</div>
</nav>