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
		<link rel="stylesheet" href="css/style.css">


		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="javascript/style.js"></script>
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
	<body class="index" data-spy="scroll" data-target=".navbar-inverse">

		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<!-- logo #is place holder for a link -->
				<div class="navbar-header page-scroll">
					<!-- Navbar button -->
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavBar">

						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#"><span>Our</span>Vibe</a>
				</div>

				<!-- menu items -->
				<div class="collapse navbar-collapse" id="mainNavBar">
					<ul class="nav navbar-nav">


						<!-- Services tab dropdown -->
						<li class="dropdown">
							<a routerLink="" class="waves-effect" data-toggle="dropdown">Events<span></span></a>
						</li>

						<!-- Our Artist tab dropdown-->
						<li class="dropdown">
							<a routerLink="/venues" class="waves-effect" data-toggle="dropdown">Venues<span></span></a>

							<!-- About Us tab dropdown-->
						<li class="dropdown">
							<a routerLink="/about" class="waves-effect" data-toggle="dropdown">About Us<span></span></a>
						</li>
					</ul>

					<!-- right align Sign Up Sign In tab -->
					<ul class="nav navbar-nav navbar-right">
						<li><a routerLink="/sign">Sign Up/Sign In</a></li>
					</ul>

					<!-- right align Create Event tab -->
					<ul class="nav navbar-nav navbar-right">
						<li><a routerLink="/create-event">Create Event</a></li>
					</ul>

				</div>
		</nav>
	</body>
</html>