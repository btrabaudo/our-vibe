import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base.service";
import {Tag} from "../classes/tag";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";

@Injectable ()
export class TagService extends BaseService{
	constructor(protected http: Http){
		super(http);
	}
	private tagUrl = "api/tag/";
	createTag(tag : Tag) : Observable<Status>{
		return(this.http.post(this.tagUrl,tag))
			.map(this.extractMessage)
			.catch(this.handleError);
	}
	editTag(tag : Tag) :Observable<Status>{
		return(this.http.put(this.tagUrl,tag))
			.map(this.extractMessage)
			.catch(this.handleError);
	}
	getTag(tagId : number) : Observable <Tag> {
		return (this.http.get(this.tagUrl + tagId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getTagByTagId(tagId: number): Observable <Tag[]> {
		return (this.http.get(this.tagUrl + tagId)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getTagByTagName(tagName: string): Observable <Tag []> {
		return(this.http.get(this.tagUrl + tagName)
			.map(this.extractData)
			.catch(this.handleError));
	}
}

























