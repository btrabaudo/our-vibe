import {Component,OnInit,} from "@angular/core";
import {ActivatedRoute,Router,Params} from "@angular/router";
import {Status} from "../classes/status";
import {Venue} from "../classes/venue";
import {VenueService} from "../services/venue.service";
import "rxjs/add/operator/switchMap";

@Component({
    templateUrl: "./templates/venue.php"
})

export class VenueComponent  implements  OnInit{
    venue:Venue = new Venue(null, null, null,null,null,null,null,null,null,null,null,null,null,null);
    status: Status = null;
    //
    constructor(private venueService:VenueService, private route:ActivatedRoute, private router: Router){
        console.log("Venue Constructor");

    }
    ngOnInit(): void{
        console.log("Venue Init");
        this.getVenueByVenueId();
    }
    getVenueByVenueId() :void {
        console.log("Get Venue");
        this.route.params
			  .switchMap((params : Params)=>this.venueService.getVenueByVenueId(+params["id"]))
			  .subscribe(reply => this.venue = reply);
        console.log("Get venue 2");
    }
}