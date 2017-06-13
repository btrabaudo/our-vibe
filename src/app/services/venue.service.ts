import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Venue} from "../classes/venue";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class VenueService extends BaseService {

    constructor(protected http:Http) {
        super(http);
    }

    // Define the API endpoint
    private venueUrl = "api/venue/";

    // Reach out to the venue API, and delete the venue in question.
    deleteVenue(id: number) : Observable<Status> {
        return(this.http.delete(this.venueUrl + id)
            .map(this.extractMessage)
            .catch(this.handleError));
    }

    // Call to the Venue API, and edit the venue in question.
    editVenue(venue: Venue) : Observable<Status> {
        return(this.http.put(this.venueUrl + venue.venueId, venue)
            .map(this.extractMessage)
            .catch(this.handleError));
    }

    // Call to the Profile API, and get a venue object by its id.
    getVenue(id: number) : Observable<Venue> {
        return(this.http.get(this.venueUrl + id)
            .map(this.extractData)
            .catch(this.handleError));
    }

    // Call to the API to grab an array of venue based on the user input.
    getVenueByVenueName(venueName: string) :Observable<Venue[]> {
        return (this.http.get(this.venueUrl + venueName)
            .map(this.extractData)
            .catch(this.handleError));
    }

    // Call to the venue API, and grab the corresponding venue by its contact.
    getVenueByVenueContact(venueContact: string) :Observable<Venue> {
        return(this.http.get(this.venueUrl + venueContact)
            .map(this.extractData)
            .catch(this.handleError));
    }

}