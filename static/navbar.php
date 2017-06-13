<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
				integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- FontAwesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

		<!-- Custom CSS -->
		<link rel="stylesheet" href="src/app.css">


		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="javascript/navbar-style.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
				  integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
				  crossorigin="anonymous"></script>

		<!-- jQuery Form, Additional Methods, Validate -->
		<script type="text/javascript"
				  src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.1/jquery.form.min.js"></script>
		<script type="text/javascript"
				  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
		<script type="text/javascript"
				  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.min.js"></script>

		<!-- Your JavaScript Form Validator -->
		<script src="javascript/navbar-style.js"></script>
	</head>
	<body>
		<div id="wrapper">


			<!-- Sidebar -->
			<div id="sidebar-wrapper">
				<ul class="sidebar-nav">
					<li class="sidebar-brand">
						<a href="#">
							Start Bootstrap
						</a>
					<li class="search">
						<div class="search-wrapper card">
							<input id="search">
							<i class="material-icons">search</i>
							<div class="search-results"></div>
						</div>
					<li>
						<a href="#">Dashboard</a>
					</li>

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



	</body>
</html>