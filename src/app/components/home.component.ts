import {Component,OnInit} from "@angular/core";
import {ActivatedRoute,Params} from "@angular/router";
import {Status} from "../classes/status";
import {Event} from  "../classes/event";
import {Venue} from "../classes/venue";
import {EventService} from "../services/event.service";
import "rxjs/add/operator/switchMap";
@Component({
	templateUrl: "./templates/home.php"
})

export class HomeComponent  implements  OnInit{
	event:Event = new Event(null,null,null,null,null,null);
	status: Status = null;
	events:Event[] = [];
	//
	constructor(private eventService:EventService,private route:ActivatedRoute){

	}
	ngOnInit(): void{
		// this.getEventsByEventId();
		this.eventService.getAllEvents();
	}
	// getEventByEventId() :void {
	// 	this.route.params
	// 		.switchMap((params : Params)=>this.eventService.getEventByEventId(+params["eventId"]))
	// 		.subscribe(reply => this.event = reply);
	// }
	// getAllEvents(): void {
	// 	this.eventService.getAllEvents()
	// 		.subscribe(events => this.events = events);
	//
	//
	// }

}