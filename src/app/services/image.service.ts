import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Image} from "../classes/image";
import {Status} from "../classes/status";
import {map} from "rxjs/operator/map";

@Injectable()
export class ImageService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	//define the API endpoint
	private imageUrl = "api/image/";


	// call to the image api and create a new image
	createImage(image: Image): Observable<Status> {
				return (this.http.post(this.imageUrl, image)
					.map(BaseService.extractData)
					.catch(BaseService.handleError));
	}

	// all to the image api and gets an image by image id
	getImageByImageId(imageId : number) : Observable<Image[]> {
				return (this.http.get(this.imageUrl + imageId)
					.map(BaseService.extractData)
					.catch(BaseService.handleError));
	}

	// all to the image api and gets an image by cloudinary id
	getImageByCloudinaryId(imageCloudinaryId: string): Observable<Image> {
				return (this.http.get(this.imageUrl + "?imageCloudinaryId=" + imageCloudinaryId)
						.map(BaseService.extractData)
						.catch(BaseService.handleError));
	}
}