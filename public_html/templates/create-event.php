
		<div class="row">
				<h1>Create Event</h1>

				<!-- Create New Post Form -->
				<form id="create-event" #createEventForm="ngForm" class="form-horizontal" name="create-event" (submit)="createEvent();" novalidate>
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
								<label class="sr-only" for="eventDate">Event DateTime<span
										class="text-danger">*</span></label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-pencil" aria-hidden="true"></i>
									</div>
									<input type="date" class="form-control" id="eventDate" name="eventDate"
											 placeholder="Date and Time of Event">
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


                                       <button class="btn btn-success" type="submit" [disabled]="createEventForm.invalid"><i class="fa fa-paper-plane"></i> Submit</button>
                                        <button class="btn btn-warning" type="reset"><i class="fa fa-ban"></i> Reset</button>

                                    </div>
                </form>


