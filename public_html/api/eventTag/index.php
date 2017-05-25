<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");



use Edu\Cnm\OurVibe\{
	EventTag

};

/**
 * API for the EventTag class
 * @author paul baca
 **/

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;


$pdo = connectToEncryptedMySQL("/etc/apache2/Our-Vibe-mysql");

$method = array_key_exists("HTTP_X_HTTP_METHOD",$_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

$eventTagEventId = filter_input(INPUT_GET,"eventTagEventId", FILTER_VALIDATE_INT);
$eventaTagTagId = filter_input(INPUT_GET, "eventTagTagId", FILTER_VALIDATE_INT);
































