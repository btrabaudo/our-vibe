import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home.component";
import {AboutComponent} from "./components/about.component";
import {LogInComponent} from "./components/log-in.component";
import {NavbarComponent} from "./components/navbar.component";


export const allAppComponents = [HomeComponent,AboutComponent,LogInComponent, NavbarComponent];

export const routes: Routes = [
	{path: "about", component: AboutComponent},
	{path: "log-in", component: LogInComponent},
	{path: "", component: HomeComponent},
	{path: "**", component: HomeComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);