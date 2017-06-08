import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base.service";
import {Status, tag} from "../classes/tag";
import {Dog} from "../classes/dog";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class tagService extends BaseService{
	constructor(protected http: Http){
		super(http);
	}
	private tagUrl = "api/tag/";
	createTag(tag : tag) : Observable<status>{
		return(this.http.post(this.tagUrl,tag))
			.map(BaseService.extractMessage)
			.catch(BaseService.handleError);
	}
	editTag(tag : tag) :Observable<status>{
		return(this.http.put(this.tagUrl,tag))
			.map(BaseService.extractMessage)
			.catch(BaseService.handleError);
	}
	getTag(tagId : number) : Observable <tag> {
		return (this.http.get(this.tagUrl + tagId)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	getTagByTagId(tagId: number): Observable <tag[]> {
		return (this.http.get(this.tagUrl + tagId)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}
	getTagByTagName(tagName: string): Observable <tag []> {
		return(this.http.get(this.tagUrl + tagName)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}
}

























