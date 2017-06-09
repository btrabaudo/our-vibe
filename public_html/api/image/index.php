<?php

require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


use Edu\Cnm\OurVibe\{
	EventImage, Event, Image, Venue
};

/** api for Image Class
 *
 * @author marcoder451 <mlester3@cnm.edu>
 **/

// verify the session, start if inactive
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/ourvibe.ini");

	/**
	 * Cloudinary API stuff
	 *
	 **/
	$config = readConfig("/etc/apache2/capstone-mysql/ourvibe.ini");
	$cloudinary = json_decode($config["cloudinary"]);
	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$imageCloudinaryId = filter_input(INPUT_GET, "imageCloudinaryId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// make sure the id is valid for methods that require it
	if(($method === "DELETE") && (empty($id) === true || $id < 0)) {
		throw (new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// handle get request
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		// get a specific image or all images and update reply
		if(empty($id) === false) {
			$image = Image::getImageByImageId($pdo, $id);
			if($image !== null) {
				$reply->data = $image;
			}
		} elseif(empty($imageCloudinaryId) === false) {
			$image = Image::getImageByImageCloudinaryId($pdo, $imageCloudinaryId);
			if($image !== null) {
				$reply->data = $image;
			}
			$reply->data = $image;
		}

	} elseif($method === "POST") {

		verifyXsrf();

		// verifying the user is logged in before creating an image
		if(empty($_SESSION["venue"]) === true) {
			throw(new \InvalidArgumentException(" You are not allowed to upload images unless you are logged in", 401));
		}
		// assigning variables to the user image name, and image extension
		$tempUserFileName = $_FILES["image"]["tmp_name"];


		// upload image to cloudinary and get public id
		$cloudinaryResult = \Cloudinary\Uploader::upload( $tempUserFileName, array("width" => 500, "crop" => "scale"));

		// after sending the image to Cloudinary, grab the public id and create a new image
		$image = new Image(null, $cloudinaryResult["public_id"]);
		$image->insert($pdo);

		$reply->data = $image->getImageId();
		$reply->message = "Image upload Ok";

	} elseif($method === "DELETE") {
		verifyXsrf();

		// verifying the user that posted these images is logged in before deleting
		if(empty($_SESSION["venue"]) === true || $_SESSION["image"]->getVenueId() !== $id) {
			throw(new \InvalidArgumentException("Must be logged in to delete image"));
		}

		// retrieve the image to be deleted
		$image = Image::getImageByImageId($pdo, $id);
		if($image === null) {
			throw(new RuntimeException("Image does not exist", 404));
		}
		$image->delete($pdo);

		$reply->message = "Image successfully deleted";

	} else {
		throw(new InvalidArgumentException("Invalid HTTP method request"));
	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-Type: application/json");
// encode and return reply to front end caller
echo json_encode($reply);



