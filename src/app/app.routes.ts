import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home.component";
import {AboutComponent} from "./components/about.component";
import {LogInComponent} from "./components/log-in.component";
import {NavbarComponent} from "./components/navbar.component";
import {VenueComponent} from "./components/venue.component";
import {SignUpComponent} from "./components/sign-up.component";


export const allAppComponents = [HomeComponent,AboutComponent,LogInComponent, NavbarComponent, VenueComponent, SignUpComponent];

export const routes: Routes = [
	{path: "venue/:id", component: VenueComponent},
	{path: "sign-up", component: SignUpComponent},
	{path: "about", component: AboutComponent},
	{path: "log-in", component: LogInComponent},
	{path: "", component: HomeComponent},
	{path: "**", component: HomeComponent}

];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);