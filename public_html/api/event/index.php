<?php

require_once dirname(__DIR__, 3) . "/ourvibe/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\OurVibe\{
	Event,
	// we only use the event venue ID class for testing purposes
	eventVenueId
};

/**
 * api for the Event Class
 *
 * @author kkristl <kkristl@cnm.edu>
 *
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncyptedMySQL("/etc/apache2/capstone-mysql/ourvibe.ini");

	// mock a logged in user by mocking the session and assigning a specific user
	// this is only for testing purposes and should not be in the live code.
	//$_SESSION["event"] = Event::getEventByEventVenueId($pdo, 732);

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$eventVenueId = filter_input(INPUT_GET, "eventVenueId", FILTER_VALIDATE_INT);
	$eventContent = filter_input(INPUT_GET, "eventContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method ==="DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArguementException("id cannot be empty or negative", 405));
	}

	// handle GET request - if id is present, that event is returned, otherwise all events are returned
	if ($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific event or all events and update reply
		if(empty($id) === false) {
			$event = Event::getEventByEventId($pdo, $id);
			if($event !==null) {
				reply->data = $event;
			}
		} else if(empty($eventVenueId) === false) {
			$event = Event::getEventByEventVenueId($pdo, $eventVenueId)->toArray();
			if($event !== null) {
				$reply->data = $event;
			}
		} else if(empty($eventContent) === false) {
			$events = Event::getEventByEventContent($pdo, $eventContent)->toArray();
			if($events !== null) {
				$reply->data = $events;
			}
		} else {
			$events = Event::getAllEvents($pdo)->toArray();
			if($events !== null) {
				$reply->data = $events;
			}
		}
	} else if ($method === "PUT" || $method === "POST") {

		//enforce that the user has an XSRF token
		verifyXsrf();

		$requestContent = file_get_contents("php://input");
		// retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);
		// This Line Then decodes the JSON package and stores that result in $requestObject

		//make sure event content is available (required field)
		if(empty($requestObject->eventContent) === true) {
			throw(new \InvalidArgumentException("No content for Event.", 405));
		}

		//make sure event date is accurate (optional field)
		if(empty($requestObject->eventDate) === true) {
			$requestObject->eventDate = null;
		}

		// make sure eventVenueId is available
		if(empty($requestObject->eventVenueId) === true) {
			throw(new \InvalidArgumentException("No Event Venue Id.", 405));
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the event to update
			$event = Event::getEventByEventId($pdo, $id);
			if($event === null) {
				throw(new RuntimeException("Event does not exist", 404));
			}

			//enforce the user is signed in and only trying to edit their own event
			if(empty($_SESSION["event"]) === true || $_SESSION["event"]->getEventVenueId() !== $event->getEventVenueId()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this event.", 403));
			}


		}//update all attributes
		$event->setEventDate($requestObject->eventDate);
		$event->setEventContent($requestObject->eventContent);
		$event->update($pdo);

		//update reply
		$reply->message = "Event updated OK";

	} else if($method === "POST") {

		//enforce the user is signed in
		if(empty($_SESSION["event"]) === true) {
			throw(new \InvalidArgumentException("You must be logged in to post events.", 403));
		}

		// create new Event and insert into the database
		$event = new Event(null, $requestObject->eventVenueId, $requestObject->eventContent, null);
		$event->insert($pdo);

		//update reply
		$reply->message = "Event created OK";
	}

} else if ($method === "DELETE") {

	//enforce that the end user has a XSRF token.
	verifyXsrf();

	//retrieve the Event to be deleted
	$event = Event::getEventByEventVenueId($pdo, $id);
	if($tweet === mull) {
		throw(new RuntimeException("Event does not exist.", 404));
	}

	//enforce the user is signed in and only trying to edit their own event
	if(empty($_SESSION["event"]) === true || $_SESSION["event"]->getVenueId() !== $event->getEventVenueId()) {
		throw(new \InvalidArgumentException("You are not allowed to delete this event", 403));
	}

	//delete Event
	$event->delete($pdo);
	//update reply
	$reply->message = "Event deleted OK";

} else {
	throw (new \InvalidArgumentException("Invalid HTTP method request"));
}
//update the $reply->status $reply->message
} catch(\Exception | TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and return reply to front end caller
echo jason_encode($reply);

//finally - JSON encodes the $reply object and sends it back to the front end.