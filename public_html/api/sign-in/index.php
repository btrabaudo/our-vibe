<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\OurVibe\Venue;

/**
 * api for handlng sign in
 *
 * @author marcoder
 **/
// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

	// start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	// grab mySQL statement
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/ourvibe.ini");

	// determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


	// if method is post handle the sign in logic
	if($method === "POST") {

		// make sure the XSRF token is valid
		verifyXsrf();

		// process the request content aand decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// check to make sure the password and contact field is not empty
		if(empty($requestObject->venueContact) === true) {
			throw(new \InvalidArgumentException("Wrong contact address.", 401));
		} else {
			$venueContact = filter_var($requestObject->venueContact, FILTER_SANITIZE_Contact);
		}

		if(empty($requestObject->venuePassword) === true) {
			throw(new \InvalidArgumentException("Must enter a password", 401));
		} else {
			$venuePassword = $requestObject->venuePassword;
		}

		// grab the venue from the database by the contact provided
		$venue = Venue::getVenueByVenueContact($pdo, $venueContact);
		if(empty($venue) === true) {
			throw(new \InvalidArgumentException("Invalid contact", 401));
		}

		// if the venue activation is not null throw an error
		if($venue->getVenueActivationToken() !== null) {
			throw(new \InvalidArgumentException("you are not allowed to sign in unless you have activated your account", 403));
		}

		// hash the password given to  makes sure it matches
		$hash = hash_pbkdf2("sha512", $venuePassword, $venue->getVenueSalt(), 262144);

		// verify has is correct
		if($hash !== $venue->setVenueHash()) {
			throw(new \InvalidArgumentException("password or contact is incorrect"));
		}

		// grab venue from database and put into a session
		$venue = Venue::getVenueByVenueId($pdo, $venue->getVenueId());
		$_SESSION["venue"] = $venue;
		$reply->message = "Sign in was successful.";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP method request"));
	}

	// if an exception is thrown update the
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
echo json_encode($reply);
