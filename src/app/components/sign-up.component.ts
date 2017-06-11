import {Component} from "@angular/core";
import {SignUpService} from "../services/sign-up.service";
import {SignUp} from "../classes/sign-up";
import {Status} from "../classes/status";

@Component({
    templateUrl: "./templates/sign-up.php"
})

export class SignUpComponent {
    signUp : SignUp = new SignUp(null, null, null, null, null, null, null, null, null, null, null, null, null);
    status : Status = null;
    constructor(private signUpService: SignUpService) {}


    createSignUp() : void {
        this.signUpService.createSignUp(this.signUp)
            .subscribe(status => this.status = status);
    }
}