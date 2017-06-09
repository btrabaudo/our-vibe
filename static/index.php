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
		<script src="js/form-validate.js"></script>
	</head>
	<body>
		<ul id="slide-out" class="side-nav">
			<li><a href="#!">First Sidebar Link</a></li>
			<li><a href="#!">Second Sidebar Link</a></li>
			<li class="no-padding">
				<ul class="collapsible collapsible-accordion">
					<li>
						<a class="collapsible-header">Dropdown<i class="material-icons">arrow_drop_down</i></a>
						<div class="collapsible-body">
							<ul>
								<li><a href="#!">First</a></li>
								<li><a href="#!">Second</a></li>
								<li><a href="#!">Third</a></li>
								<li><a href="#!">Fourth</a></li>
							</ul>
						</div>
					</li>
				</ul>
			</li>
		</ul>
		<ul class="right hide-on-med-and-down">
			<li><a href="#!">First Sidebar Link</a></li>
			<li><a href="#!">Second Sidebar Link</a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown1">Dropdown<i class="material-icons right">arrow_drop_down</i></a></li>
			<ul id='dropdown1' class='dropdown-content'>
				<li><a href="#!">First</a></li>
				<li><a href="#!">Second</a></li>
				<li><a href="#!">Third</a></li>
				<li><a href="#!">Fourth</a></li>
				<ul id="slide-out" class="side-nav">
					<li><a href="#!">First Sidebar Link</a></li>
					<li><a href="#!">Second Sidebar Link</a></li>
				</ul>
				<a href="#" data-activates="slide-out" class="button-collapse show-on-large"><i class="material-icons">menu</i></a>
			</ul>
		</ul>
		<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
		<ul id="slide-out" class="side-nav fixed">
			<li><a href="#!">First Sidebar Link</a></li>
			<li><a href="#!">Second Sidebar Link</a></li>
		</ul>
		<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
	</body>
</html>