<main class="bg">
    <div class="row">

        <form #signUpForm="ngForm" class="form-horizontal" id="signUpForm" name="signUpForm"
              (submit)="createSignUp();" novalidate>

            <h1>Create Venue</h1>

            <!-- Create New Sign Up Form -->
            <div class="form-group">
                <label class="sr-only" for="venueName">Venue Name <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </div>
                    <input type="text" class="form-control" id="venueName" name="venueName" maxlength="32" required [(ngModel)]="venue.venueName" placeholder="Venue Name" #venueName="ngModel" />
                </div>
                <div [hidden]="venueName.valid || venueName.pristine" class="alert alert-danger" role="alert">Name is invalid.</div>
            </div>





            <div class="form-group" [ngClass]="{ 'has-error': venueAddress1.touched && venueAddress1.invalid}">
                <label class="sr-only" for="venueAddress">Venue Address 1 <span
                            class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </div>
                    <input type="text" class="form-control" id="venueAddress" name="venueAddress" class="form-control" maxlength="128" [(ngModel)]="venue.venueAddress1" #venueAddress1="ngModel"
                           placeholder="Venue Address"/>

                    <div [hidden]="venueAddress1.valid || venueAddress1.pristine" class="alert alert-danger" role="alert">
                        <p *ngIf="venueAddress1.errors?.maxlength"> Address cannot be more than 128 characters.</p>
                    </div>
                </div>
            </div>





            <div class="form-group" [ngClass]="{ 'has-error': venueAddress2.touched && venueAddress2.invalid}">
                <label class="sr-only" for="venueAddress">Venue Address 2 <span
                            class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </div>
                    <input type="text" class="form-control" id="venueAddress" name="venueAddress" class="form-control" maxlength="128" [(ngModel)]="venue.venueAddress2" #venueAddress2="ngModel"
                           placeholder="Venue Address"/>

                    <div [hidden]="venueAddress2.valid || venueAddress2.pristine" class="alert alert-danger" role="alert">
                        <p *ngIf="venueAddress2.errors?.maxlength"> Address cannot be more than 128 characters.</p>
                    </div>
                </div>
            </div>





            <div class="form-group" [ngClass]="{ 'has-error': venueCity.touched && venueCity.invalid}">
                <label class="sr-only" for="venueCity">Venue City <span
                            class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </div>
                    <input type="text" class="form-control" id="venueCity" name="venueCity" class="form-control" maxlength="32" [(ngModel)]="venue.venueCity" #venueCity="ngModel"
                           placeholder="Venue City"/>

                    <div [hidden]="venueCity.valid || venueCity.pristine" class="alert alert-danger" role="alert">
                        <p *ngIf="venueCity.errors?.maxlength"> City cannot be more than 32 characters.</p>
                    </div>
                </div>
            </div>





            <div class="form-group" [ngClass]="{ 'has-error': venueContact.touched && venueContact.invalid}">
                <label class="sr-only" for="venueContact">Venue Contact<span
                            class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </div>
                    <input type="text" class="form-control" id="venueContact" name="venueContact" class="form-control" maxlength="128" [(ngModel)]="venue.venueContact" #venueContact="ngModel"
                           placeholder="Venue Email"/>

                    <div [hidden]="venueContact.valid || venueContact.pristine" class="alert alert-danger" role="alert">
                        <p *ngIf="venueContact.errors?.maxlength"> Contact cannot be more than 128 characters.</p>
                    </div>
                </div>
            </div>






            <div class="form-group" [ngClass]="{ 'has-error': venueContent.touched && venueContent.invalid}">
                <label class="sr-only" for="venueContent">Venue Content <span
                            class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </div>
                    <input type="text" class="form-control" id="venueContent" name="venueContent" class="form-control" maxlength="768" required [(ngModel)]="venue.venueContent" #venueContent="ngModel"
                           placeholder="Venue Contend"/>

                    <div [hidden]="venueContent.valid || venueContent.pristine" class="alert alert-danger" role="alert">
                        <p *ngIf="venueContent.errors?.maxlength"> Content cannot be more than 768 characters.</p>
                    </div>
                </div>
            </div>







            <div class="form-group" [ngClass]="{ 'has-error': venueState.touched && venueState.invalid}">
                <label class="sr-only" for="venueState">Venue State <span
                            class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </div>
                    <input type="text" class="form-control" id="venueState" name="venueState" class="form-control" maxlength="128" required [(ngModel)]="venue.venueState" #venueState="ngModel"
                           placeholder="Venue State"/>

                    <div [hidden]="venueState.valid || venueState.pristine" class="alert alert-danger" role="alert">
                        <p *ngIf="venueState.errors?.maxlength"> State cannot be more than 2 characters.</p>
                    </div>
                </div>
            </div>






            <div class="form-group" [ngClass]="{ 'has-error': venueZip.touched && venueZip.invalid}">
                <label class="sr-only" for="venueZip">Venue Zip <span
                            class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </div>
                    <input type="text" class="form-control" id="venueZip" name="venueZip" class="form-control" maxlength="128" [(ngModel)]="venue.venueZip" #venueZip="ngModel"
                           placeholder="Venue Zip Code"/>

                    <div [hidden]="venueZip.valid || venueZip.pristine" class="alert alert-danger" role="alert">
                        <p *ngIf="venueZip.errors?.maxlength"> Zip cannot be more than 10 characters.</p>
                    </div>
                </div>
            </div>







            <div class="form-group" [ngClass]="{ 'has-error': profilePassword.touched && profilePassword.invalid}">
                <label class="sr-only" for="profilePassword">Profile Password <span
                            class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </div>
                    <input type="text" class="form-control" id="profilePassword" name="profilePassword" class="form-control" maxlength="128" [(ngModel)]="venue.profilePassword" #profilePassword="ngModel"
                           placeholder="Profile Password"/>

                    <div [hidden]="profilePassword.valid || profilePassword.pristine" class="alert alert-danger" role="alert">
                        <p *ngIf="profilePassword.errors?.maxlength"> Profile password cannot be more than 128 characters.</p>
                    </div>
                </div>
            </div>






            <div class="form-group" [ngClass]="{ 'has-error': profilePasswordConfirm.touched && profilePasswordConfirm.invalid}">
                <label class="sr-only" for="profilePassword">Profile Password Confirm <span
                            class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </div>
                    <input type="text" class="form-control" id="profilePasswordConfirm" name="profilePasswordConfirm" class="form-control" maxlength="128" [(ngModel)]="venue.profilePasswordConfirm" #profilePasswordConfirm="ngModel"
                           placeholder="Confirm Password"/>

                    <div [hidden]="profilePasswordConfirm.valid || profilePasswordConfirm.pristine" class="alert alert-danger" role="alert">
                        <p *ngIf="profilePasswordConfirm.errors?.maxlength"> Profile password cannot be more than 128 characters.</p>
                    </div>
                </div>
            </div>




            <button class="btn btn-success" type="submit" [disabled]="signUpForm.invalid"><i class="fa fa-paper-plane"></i> Submit</button>
            <button class="btn btn-warning" type="reset"><i class="fa fa-ban"></i> Reset</button>
        </form>
    </div>
</main>