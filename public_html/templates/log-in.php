<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6 center-block">




		<form #loginForm="ngForm" name="loginForm" (ngSubmit)="postLogin();"
				class="form-horizontal well" >
			<div class="form-group" >
				<label for="venue">Venue Email</label>
				<div class="input-group">
					<div class="input-group-addon">
					</div>
					<input type="text" class="form-control" id="venueContact" name="venueContact" placeholder="email" required [(ngModel)]="login.venueContact" #venueContact = "ngModel"  >
				</div>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<div class="input-group">
					<div class="input-group-addon">
					</div>
					<input type="password" class="form-control" id="profilePassword" name="profilePassword" required [(ngModel)]="login.profilePassword" #profilePassword = "ngModel" placeholder="Password">
				</div>
			</div>
			<button class="btn btn-success" type="submit"> Log-In</button>
		</form>





		<a class="btn Venue" routerLink="/sign-up"> Register Venue</a>
		<div id="output-area"></div>




	</div>