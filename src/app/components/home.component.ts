import {Component,OnInit} from "@angular/core";
import {ActivatedRoute,Params,Router} from "@angular/router";
import {Status} from "../classes/status";
import {Event} from  "../classes/event";
import {EventService} from "../services/event.service";
import "rxjs/add/operator/switchMap";

@Component({
	templateUrl: "./templates/home.php"
})
export class HomeComponent  implements  OnInit{
	event:Event = new Event(null,null,null,null,null,null, null);
	status: Status = null;
	events : Event[] = [];
	//
	constructor(private eventService:EventService, private route:ActivatedRoute, private router:Router){

	}
	ngOnInit(): void{
		this.getAllEvents();
	}

	getEventByEventId() :void {
		this.route.params
			.switchMap((params : Params)=>this.eventService.getEventByEventId(+params["eventId"]))
			.subscribe(reply => this.event = reply);
	}
	getAllEvents(): void {
		this.eventService.getAllEvents()
			.subscribe(events => this.events = events);
	}

	switchEvent(event:Event) : void {
		this.router.navigate(["/event/", event.eventId]);
	}

	eventUrl(event: Event) : string {
		return("venue/" + event.eventVenueId);
	}
}