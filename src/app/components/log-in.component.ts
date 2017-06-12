import {Component, OnInit, EventEmitter, ViewChild} from "@angular/core";
import {LogInService} from "../services/log-in.service";
import {Router} from  "@angular/router";
import {Status} from "../classes/status";
import {Login} from "../classes/log-in";
@Component({
	templateUrl: "./templates/log-in.php"
})
export class LogInComponent {

	login: Login = new Login(null, null);
	status: Status = null;

	constructor(private loginService: LogInService, private router: Router) {

	}

	ngOnit(): void {

	}

	postLogin(): void {
		this.loginService.postSignIn(this.login)
			.subscribe(status =>{
				this.status =status;
				console.log(this.status);
				if (status.status ===200){
					alert("tell paul he is a crunk ass juice box punk");
					this.router.navigate(['']);
				}
			})
	}

}