<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\OurVibe\ {

    Venue

};

/**
 *
 * API for Venue
 *
 * @author QED
 */

//verify the session, if it is not active start it
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
    // mySQL connection
    $pdo = connectToEncryptedMySQL("INSERT PATH HERE");


    //is a an HTTP method
    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $venueCity = filter_input(INPUT_GET, "venueCity", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $venueName = filter_input(INPUT_GET, "venueName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
        throw(new InvalidArgumentException("ID cannot be empty or negative", 405));
    }
    if($method === "GET") {
        // Set XSRF cookie
        setXsrfCookie();

        if(empty($id) === false) {
            $venue = Venue::getVenueByVenueId($pdo, $id);
            if($venue !== null) {
                $reply->data = $venue;
            }

        } else if(empty($venueCity) === false) {
            $venue = Venue::getVenueByVenueCity($pdo, $venueCity);
                if($venue !== null) {
                    $reply->data = $venue;
                }

        } else if(empty($venueName) === false) {
            $venue = Venue::getVenueByVenueName($pdo, $venueName);
            if($venue !== null) {
                $reply->data = $venue;
            }
        }

    } elseif ($method === "PUT") {
        //Enforce the sign in
        if(empty($_SESSION["venue"]) === true || $_SESSION["venue"]->getVenueId() !==$id) {
            throw(new \InvalidArgumentException("Access Denied", 403));
        }

        //decode the front end response

        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);

        //retrieve the venue

        $venue = Venue::getVenueByVenueId($pdo, $id);
        if($venue === null) {
            throw(new RuntimeException("Venue does not exist", 404));
        }
        if(empty($requestObject->newPassword) === true) {

            //enforce the XSRF token
            verifyXSRF();

            //venue address1
            if(empty($requestObject->venueAddress1) === true) {
                throw(new \InvalidArgumentException("No venue address", 404));
            }

            //venue address2
            if(empty($requestObject->venueAddress2) === true) {
                throw(new \InvalidArgumentException("No venue address", 404));
            }


            //venue City
            if(empty($requestObject->venueCity) === true) {
                throw(new \InvalidArgumentException("No venue city", 404));
            }

            //venue Contact
            if(empty($requestObject->venueContact) === true) {
                throw(new \InvalidArgumentException("No venue contact", 404));
            }

            if(empty($requestObject->venueContent) === true) {
                throw(new \InvalidArgumentException("No venue content", 404));
            }


            if(empty($requestObject->venueName) === true) {
                throw(new \InvalidArgumentException("No venue name", 404));
            }
            if(empty($requestObject->venueState) === true) {
                throw(new \InvalidArgumentException("No venue State", 404));
            }

            $venue->setVenueCity($requestObject->venueCity);
            $venue->setVenueName($requestObject->venueName);

        }

    }





}
