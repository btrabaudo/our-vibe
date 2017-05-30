<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/our-vibe/encrypted-config.php");
use Edu\Cnm\Ourvibe\{
	eventTag
};


/**
 * api for the event tag class
 * author @paulBaca
 **/


if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;


try {
	$pdo = connectToEncryptedMySQL("/etc/apache2/OurVibe");

	$_SESSION["eventTag"] = EventTag::getEventTagsByEventTagEventId($pdo, 732);

	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	$eventTagEventId = filter_input(INPUT_GET, "eventTagEventId", FILTER_VALIDATE_INT);
	$eventTagTagId = filter_input(INPUT_GET, "eventTagTagId", FILTER_VALIDATE_INT);

	if($method === "GET") {
		setXsrfCookie();
		if($eventTagEventId !== null && $eventTagTagId !== null) {
			$eventTag = EventTag::getEventTagByEventTagEventIdAndEventTagTagId($pdo, $eventTagEventId, $eventTagTagId);
			if($eventTag !== null) {
				$reply->data = $eventTag;
			}
		} elseif(empty($eventTagTagId) === false) {
			$eventTag = EventTag::getEventTagsByEventTagTagId($pdo, $eventTagTagId)->toArray();
			if($eventTag !== null) {
				$reply->data = $eventTag;
			}
		} else {
			throw new InvalidArgumentException("incorrect search parameters", 404);
		}
	} elseif($method === "POST" || $method === "PUT") {
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		if(empty($requestObject->eventTagEventId) === true) {
			throw(new InvalidArgumentException("no event tag event id linked to event tag", 405));
		}
		if(empty($requestObject->EventTagTagId) === true) {
			throw(new InvalidArgumentException("no event tag tag id linked to the event tag", 405));
		}
		if($method === "POST") {
			if(empty($_SESSION["eventTag"]) === true) {
				throw(new InvalidArgumentException("you must be logged in too post tags", 403));
			}
			$eventTag = new  EventTag($requestObject->eventTagEventId, $requestObject->eventTagTagId);
			$eventTag->insert($pdo);
			$reply->message = "event tag post successful";
		} elseif($method === "PUT") {
			verifyXsrf();
			$eventTag = EventTag::getEventTagsByEventTagTagId($pdo, $requestObject->eventTagTagId);
			if($eventTag === null) {
				throw(new RuntimeException("event tag does not exist"));

			}
			if(empty($_SESSION["eventTag"]) === true || $_SESSION["eventTag"]->getEventTagTagId() !== $eventTag->getEventTagTagId()) {
				throw(new InvalidArgumentException("you are not allowed to delete this event tag", 403));
			}
			$eventTag->delete($pdo);
			$reply->message = "event tag successfully deleted";
		}

	} else {
		throw(new \InvalidArgumentException("invalid http request", 400));
	}
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);