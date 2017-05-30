<?php

require_once dirname(__DIR__, 3) . "/ourvibe/autoload.php";
require_once dirname(__DIR, 3) . "/php/classes/autoload.php";
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
}
