
<main class="bg">
	<div class="container">
		<div class="row">

			<div class="col-md-4">
				<h1>Create Event</h1>

				<!-- Create New Post Form -->
				<form id="create-event" #createEventForm="ngForm" class="form-horizontal" name="create-event"
						(submit)="createEvent();" novalidate>
					<div class="form-group">
						<label class="sr-only" for="eventName">Event Name <span class="text-danger">*</span></label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</div>
							<input type="text" class="form-control" id="eventName" name="eventName" maxlength="32" required [(ngModel)]="event.eventName"
									 placeholder="Name of Event" #eventName="ngModel"/>
						</div>
					</div>

						<div class="form-group">
							<label class="sr-only" for="venueAddress">Event Venue <span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-pencil" aria-hidden="true"></i>
								</div>
                                <input type="text" class="form-control" id="eventVenue" name="eventVenue" maxlength="32" required [(ngModel)]="event.eventVenue"
                                       placeholder="Venue" #eventVenue="ngModel"/>
							</div>
						</div>

							<div class="form-group">
								<label class="sr-only" for="eventDateTime">Event DateTime<span
										class="text-danger">*</span></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-pencil" aria-hidden="true"></i>
									</div>
									<input type="text" class="form-control" id="eventDateTime" name="eventDateTime"
											 placeholder="Date and Time of Event ">
								</div>
							</div>


								<div class="form-group">
									<label class="sr-only" for="eventContact">Event Contact<span
											class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</div>
                                        <input type="text" class="form-control" id="eventContact" name="eventContact" maxlength="32" required [(ngModel)]="event.eventContact"
                                               placeholder="Contact for event" #eventContact="ngModel"/>
									</div>
								</div>

									<div class="form-group">
										<label class="sr-only" for="eventContent">Event Content <span
												class="text-danger">*</span></label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</div>
                                            <input type="text" class="form-control" id="eventContent" name="eventContent" maxlength="32" required [(ngModel)]="event.eventContent"
                                                   placeholder="Event Info" #eventContent="ngModel"/>
									</div>


									<!-- image upload form -->
									<h1>Image Component</h1>
									<form class="form-horizontal" name="imageUpload" (submit)="uploadImage();">
										<div class="form-group">
											<label for="postImage" class="modal-labels">Upload an image</label>
											<input type="file" name="dog" id="dog" ng2FileSelect [uploader]="uploader" />
										</div>
										<button type="submit" class="btn btn-info btn-lg"><i class="fa fa-file-image-o" aria-hidden="true"></i> Upload Image</button>
									</form>




										<form id="create-event">
											<div class="form-group">
												<label class="sr-only" for="profilePassword">
													Password <span
														class="text-danger">*</span></label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-pencil" aria-hidden="true"></i>
													</div>
													<input type="text" class="form-control" id="profilePassword"
															 name="profilePassword" placeholder=" password">
												</div>
											</div>

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