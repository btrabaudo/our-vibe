import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Image} from "../class/image-class";
import {Status} from "../class/status";
import {map} from "rxjs/operator/map";

@Injectable()
export class ImageService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private imageUrl = "api/image/";


	createImage(image: Image): Observable<Status> {
				return (this.http.post(this.imageUrl, image)
					.map(BaseService.extractData)
					.catch(BaseService.handleError));
	}

	getImageByImageId(imageId : number) : Observable<Image[]> {
				return (this.http.get(this.imageUrl + imageId)
					.map(BaseService.extractData)
					.catch(BaseService.handleError));
	}

	getImageByCloudinaryId(imageCloudinaryId: string): Observable<Image> {
				return (this.http.get(this.imageUrl + "?imageCloudinaryId=" + imageCloudinaryId)
						.map(BaseService.extractData)
						.catch(BaseService.handleError));
	}
}