import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Event} from "../classes/event";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class EventService extends BaseService {

	constructor(protected http:Http ) {
		super(http);
	}

	//define the API endpoint
	private eventUrl = "api/event/";

	// call to the event API and delete the event in question
	deleteEvent(eventId: number) : Observable<Status> {
		return(this.http.delete(this.eventUrl + eventId)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	// call to the event API and edit the event in question
	editEvent(event : Event) : Observable<Status> {
		return(this.http.put(this.eventUrl + event.eventId, event)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	// call to the event API and create the event in question
	createEvent(event : Event) : Observable<Status> {
		return(this.http.post(this.eventUrl, event)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	// call to the event API and get a event object based on its Id
	getEventByEventId(eventId : number) : Observable<Event> {
		return(this.http.get(this.eventUrl + eventId)
			.map(this.extractData)
			.catch(this.handleError));
	}


	// call to the API and get an array of events based off the venueId
	getEventByVenueId(eventVenueId : number) : Observable<Event[]> {
		return(this.http.get(this.eventUrl + eventVenueId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// call to event API and get an array of events based off the eventContent
	getEventByEventContent(eventContent : string) : Observable<Event[]> {
		return(this.http.get(this.eventUrl +eventContent)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// call to event API and get an array of events based off the eventDateTime
	getEventByEventDate(eventDateTime : string) : Observable<Event[]> {
		return(this.http.get(this.eventUrl +eventDateTime)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// call to event API and get an array of events based off the eventName
	getEventByEventName(eventName : string) : Observable<Event[]> {
		return(this.http.get(this.eventUrl +eventName)
			.map(this.extractData)
			.catch(this.handleError));
	}

	//call to the API and get an array of all the events in the database
	getAllEvents() : Observable<Event[]> {
		return(this.http.get(this.eventUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

}