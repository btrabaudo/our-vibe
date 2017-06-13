import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";

import {Event} from "../classes/event";
import {EventService} from "../services/event.service";
import "rxjs/add/operator/switchMap";

@Component({
	templateUrl: "./templates/create-event.php"
})

export class EventComponent implements OnInit {

	event: Event = new Event(null, null, null, null, null, null);
	status : Status = null;

	constructor(private eventService: EventService) {}

	ngOnInit(): void {}

	createEvent() : void {
		this.eventService.createEvent(this.event)
			.subscribe(status => this.status = status);
	}
}