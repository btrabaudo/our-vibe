<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Ourvibe\Venue;


if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/ourvibe.ini");
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	$activation = filter_input(INPUT_GET, "activation", FILTER_SANITIZE_STRING);
	if(strlen($activation) !== 32) {
		throw(new InvalidArgumentException("activation has an incorrect length", 405));
	}

	if(ctype_xdigit($activation) === false) {
		throw (new \InvalidArgumentException("activation is empty or has invalid contents", 405));
	}
	if($method === "GET") {
		setXsrfCookie();
		$venue = Venue::getVenueByVenueActivationToken($pdo, $activation);
		if($venue !== null) {
			if($activation === $venue->getVenueActivationToken()) {
				$venue->setVenueActivationToken(null);
				$venue->update($pdo);
				$reply->data = "Thank you for activating your account, you will be auto-redirected to your venue shortly.";
			}
		} else throw(new RuntimeException("invalid http request"));
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message->getMessage();
	header("Content-type: application/json");
	if($reply->data === null) {
		unset($reply->data);
	}
	echo json_encode($reply);
}