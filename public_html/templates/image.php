<h1>Image Upload</h1>
<form class="form-horizontal" name="imageUpload" (submit)="uploadImage();">
	<div class="form-group">
		<label for="postImage" class="modal-labels">Upload an Image</label>
		<input type="file" name="event" id="event" ng2FileSelect [uploader]="uploader" />
	</div>
	<button type="submit" class="btn btn-info btn-lg"><i class="fa fa-file-image-o" aria-hidden="true"></i> Upload Image</button>
</form>
<p>Cloudinary Public Id {{cloudinaryPublicId}}</p>