<!-- Page Content -->
<div class="container">

	<!-- Page Heading -->
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">{{venue.venueName}}</h1>
		</div>
	</div>
	<!-- /.row -->

	<!-- Event One -->
	<div class="row">
		<div class="col-md-7">
			<a href="#">
				<img class="img-responsive" src="http://res.cloudinary.com/our-vibe/image/upload/v1497306690/{{venue.imageCloudinaryId}}.jpg" alt="">
			</a>
		</div>
		<div class="col-md-5">
			<p>{{venue.venueContent}}</p>
            <p>{{venue.venueContact}}</p>
            <p>{{venue.venueCity}} {{venue.venueState}}</p>
		</div>
	</div>
</div>
<!-- /.row -->

<hr>
