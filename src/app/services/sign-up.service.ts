import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Venue} from "../classes/venue";

@Injectable()
export class SignUpService extends BaseService {
    constructor(protected http: Http) {
        super(http);
    }

    private signUpUrl = "api/sign-up/";

    createSignUp(venue:Venue) : Observable<Status> {
        return(this.http.post(this.signUpUrl, venue)
            .map(this.extractMessage)
            .catch(this.handleError));
    }
}