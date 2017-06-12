import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Login} from "../classes/log-in";

@Injectable()
export class LogInService extends BaseService {
	constructor(protected http:Http) {
		super(http);
	}

	private signInUrl = "api/sign-in/";
	public isSignedIn = false;


	//preform the post to initiate sign in
	postSignIn(login : Login) : Observable<Status> {
		return(this.http.post(this.signInUrl, login)
            .map(this.extractMessage)
            .catch(this.handleError));
	}
}