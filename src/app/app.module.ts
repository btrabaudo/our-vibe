import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {AppComponent} from "./app.component";

import {SignUpService} from "./services/sign-up.service";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {LogInService} from "./services/log-in.service";

const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [BrowserModule, FormsModule, HttpModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [appRoutingProviders, SignUpService,LogInService]
})
export class AppModule {}