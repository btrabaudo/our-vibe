import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home-components";
import {AboutComponent} from "./components/about-component";
import {LogInComponent} from "./components/log-in.component";

export const allAppComponents = [HomeComponent,AboutComponent,LogInComponent];

export const routes: Routes = [
	{path: "about", component: AboutComponent},
	{path: "log-in", component: LogInComponent},
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);