import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";

import {Venue} from "../classes/venue";
import {SignUpService} from "../services/sign-up.service";
import "rxjs/add/operator/switchMap";

@Component({
    templateUrl: "./templates/sign-up.php"
})

export class SignUpComponent implements OnInit {

    venue: Venue = new Venue(null, null, null, null, null, null, null, null, null, null, null, null, null);
    status : Status = null;

    constructor(private signUpService: SignUpService) {}

    ngOnInit(): void {}

    createSignUp() : void {
        this.signUpService.createSignUp(this.venue)
            .subscribe(status => this.status = status);
    }
}