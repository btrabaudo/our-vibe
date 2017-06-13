
	<!-- Your JavaScript Form Validator -->
	<script src="javascript/navbar-style.js"></script>

	<body>
		<div id="wrapper">


			<!-- Sidebar -->
			<div id="sidebar-wrapper">
				<ul class="sidebar-nav">
					<li class="sidebar-brand">
						<a href="#">
							Our Vibe
						</a>
					<li class="search">
						<div class="search-wrapper card">
							<input id="search">
							<i class="material-icons">search</i>
							<div class="search-results"></div>
						</div>


					<li>
						<a class="waves-effect" routerLink="">Events</a>
					</li>
					<li>
						<a class="waves-effect" routerLink="/venues">Venues</a>
					</li>
					<li>
						<a class="waves-effect" routerLink="/about">About</a>
					</li>
					<li>
						<a class="waves-effect" routerLink="/sign-up">Sign Up</a> / <a class="waves-effect" routerLink="/log-in">Sign In</a>
					</li>
				</ul>
			</div>
			<!-- /#sidebar-wrapper -->


			<!-- Page Content -->
			<div id="page-content-wrapper">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
						</div>
					</div>
				</div>
			</div>
			<!-- /#page-content-wrapper -->


		</div>
		<!-- /#wrapper -->


		<!-- jQuery -->
		<script src="js/jquery.js"></script>


		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>


		<!-- Menu Toggle Script -->
		<script>
			$("#menu-toggle").click(function(e) {
				e.preventDefault();
				$("#wrapper").toggleClass("toggled");
			});
		</script>

