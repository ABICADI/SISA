<!-- Main Header -->
<header class="main-header">

	<!-- Logo -->
	<a class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>SISA</b></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg">{{ config('app.name', 'ABICADI') }}</span>
	</a>

	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- User Account Menu -->
				<li class="dropdown user user-menu">
					<!-- Menu Toggle Button -->
					<a class="dropdown-toggle">
						<!-- The user image in the navbar-->
						<img src="{{ asset("/bower_components/AdminLTE/dist/img/avatar.png") }}" class="user-image" alt="User Image">
						<!-- hidden-xs hides the username on small devices so only the image appears. -->
						<span class="hidden-xs">{{ Auth::user()->username }}</span>
					</a>
				</li>
			</ul>
		</div>
	</nav>
</header>
 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
		{{ csrf_field() }}
 </form>
