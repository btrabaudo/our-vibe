<?php
//<body class="sfooter">
//<div class="sfooter-content">

//<!-- insert header and navbar -->
//<?php require_once("lib/header.php");?>

<html>
	<body>

		<main class="bg">
			<div class="container">
				<div class="row">

					<div class="col-md-4">
						<h1>Create Event</h1>

						<!-- Create New Post Form -->
						<form id="create-event">
							<div class="form-group">
								<label class="sr-only" for="eventName">Event Name <span class="text-danger">*</span></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-pencil" aria-hidden="true"></i>
									</div>
									<input type="text" class="form-control" id="eventName" name="eventName"
											 placeholder="Event Name">
								</div>
							</div>

							<form id="create-event">
								<div class="form-group">
									<label class="sr-only" for="venueAddress">Event Venue <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</div>
										<input type="text" class="form-control" id="eventVenue" name="eventVenue"
												 placeholder="Event Venue">
									</div>
								</div>

								<form id="create-event">
									<div class="form-group">
										<label class="sr-only" for="eventDateTime">Event DateTime<span
												class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</div>
											<input type="text" class="form-control" id="eventDateTime" name="eventDateTime"
													 placeholder="Event Date Time">
										</div>
									</div>


									<form id="create-event">
										<div class="form-group">
											<label class="sr-only" for="eventContact">Event Contact<span
													class="text-danger">*</span></label>
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-pencil" aria-hidden="true"></i>
												</div>
												<input type="text" class="form-control" id="eventContact" name="eventContact"
														 placeholder="Event Contact">
											</div>
										</div>

											<form id="create-event">
												<div class="form-group">
													<label class="sr-only" for="eventContent">Event Content <span
															class="text-danger">*</span></label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-pencil" aria-hidden="true"></i>
														</div>
														<input type="text" class="form-control" id="eventContent"
																 name="eventContent" placeholder="Info About This Event">
													</div>
												</div>

												<!-- upload image to event -->

												<div *ngIf="modes.length > 0">
													<div class="row main" *ngFor="let post of posts">
														<div class="col-xs-12 col-md-6 col-md-offset-3 display">
															<div class="row post">
																<div class="col-md-3">
																	<img src="URL Of IMAGE" id="eventImage"/>
																	<p id="handle">Event</p>
																</div>
																<div class="col-md-9">
																	<img [src]="imageMap[post.postId]?.imageCloudinaryId" alt="post image" id="post-img"/>
																	<p class="post-rundown">{{ post.postOffer }}</p>
																	<p class="post-rundown">{{ getModeNameFromArray(post.postModeId) }}</p>
																	<p class="post-rundown">{{ post.postRequest }}</p>
																	<p class="post-rundown">{{ post.postContent}}</p>
																</div>
															</div>
														</div>
													</div>
												</div>


												<form id="create-event">
													<div class="form-group">
														<label class="sr-only" for="eventImage">Event Image <span
																class="text-danger">*</span></label>
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-pencil" aria-hidden="true"></i>
															</div>
															<input type="text" class="form-control" id="EventImage" name="eventImage"
																	 placeholder="Event Image">
														</div>
													</div>

														<form id="create-venue">
															<div class="form-group">
																<label class="sr-only" for="profilePassword">Venue Password <span
																		class="text-danger">*</span></label>
																<div class="input-group">
																	<div class="input-group-addon">
																		<i class="fa fa-pencil" aria-hidden="true"></i>
																	</div>
																	<input type="text" class="form-control" id="profilePassword"
																			 name="profilePassword" placeholder="venue password">
																</div>
															</div>

															<form id="create-venue">
																<div class="form-group">
																	<label class="sr-only" for="profileConfirmPassword">Confirm Password <span class="text-danger">*</span></label>
																	<div class="input-group">
																		<div class="input-group-addon">
																			<i class="fa fa-pencil" aria-hidden="true"></i>
																		</div>
																		<input type="text" class="form-control" id="profileConfirmPassword" name="profileConfirmPassword" placeholder="re-type password">
																	</div>
																</div>

																<button class="btn btn-success" type="submit"><i
																		class="fa fa-paper-plane"></i> Submit
																</button>
																<button class="btn btn-warning" type="reset"><i
																		class="fa fa-ban"></i> Reset
																</button>
															</form>

					</div>

	</body>
</html>