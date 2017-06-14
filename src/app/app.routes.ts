import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home.component";
import {AboutComponent} from "./components/about.component";
import {LogInComponent} from "./components/log-in.component";
import {NavbarComponent} from "./components/navbar.component";
import {VenueComponent} from "./components/venue.component";
import {VenueService} from "./services/venue.service";
import {SignUpComponent} from "./components/sign-up.component";
import {ImageComponent} from "./components/image.component";
import {FileSelectDirective} from "ng2-file-upload";
import {EventComponent} from "./components/event.component";


export const allAppComponents = [HomeComponent,AboutComponent,LogInComponent, NavbarComponent, VenueComponent, SignUpComponent, FileSelectDirective, ImageComponent, EventComponent];

export const routes: Routes = [

	{path: "", component: HomeComponent},
	{path: "venue", component:VenueComponent},
	{path: "venue/:id", component: VenueComponent},
	{path: "create-event", component: EventComponent},
	{path: "image-test", component: ImageComponent},
	{path: "sign-up", component: SignUpComponent},
	{path: "about", component: AboutComponent},
	{path: "log-in", component: LogInComponent},
	{path: "**", redirectTo: ""}

];

export const appRoutingProviders: any[] = [VenueService];

export const routing = RouterModule.forRoot(routes);