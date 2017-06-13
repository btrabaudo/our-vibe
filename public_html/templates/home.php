	<!-- Page Content -->
		<div class="container">
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Events in Albuquerque, NM
						<small></small>
					</h1>
				</div>
			</div>

			<!-- Events -->
			<div class="row" *ngFor="let event of events" >
				<div class="col-md-7">
					<a href="#">
						<img class="img-responsive" src="https://placehold.it/700x300" alt="">
					</a>
				</div>
				<div class="col-md-5">
					<h3>{{event.eventName}}</h3>
					<p>{{event.eventContent}}</p>
					<a class="btn btn-primary" [routerLink]="['venue/',(event.eventVenueId)]">View This Event <span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>
			</div>
			<!-- /.row -->
		</div>
	<hr>