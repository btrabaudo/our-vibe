import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base-service";
import {Status} from "../classes/status";
import {Like} from "../classes/sign-in";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class SignInService extends BaseService {
	constructor(protected http:Http ) {
		super(http);
	}


	private signInUrl = "api/sign-in/";
	public  isSignedIn = false;


	// perform the post to initiate sign in
	postSignIn(signIn:SignIn) : Observable<Status> {
			return(this.http.post(this.signInUrl, signIn)
				.map(BaseService.extractMessage)
				.catch(BaseService.handleError));
	}
}

