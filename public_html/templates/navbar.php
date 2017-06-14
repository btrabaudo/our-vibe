
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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
						<a routerLink="/events" class="waves-effect" data-toggle="dropdown">Events<span></span></a>
					</li>

					<!-- Our Artist tab dropdown-->
					<li class="dropdown">
						<a routerLink="/venue" class="waves-effect" data-toggle="dropdown">Venues<span></span></a>

						<!-- About Us tab dropdown-->
					<li class="dropdown">
						<a routerLink="/about" class="waves-effect" data-toggle="dropdown">About Us<span></span></a>
					</li>
				</ul>

				<!-- right align Sign Up Sign In tab -->
				<ul class="nav navbar-nav navbar-right">
					<li><a routerLink="/log-in">Sign Up/Sign In</a></li>
				</ul>

				<!-- right align Create Event tab -->
				<ul class="nav navbar-nav navbar-right">
					<li><a routerLink="/create-event">Create Event</a></li>
				</ul>
			</div>
	</nav>