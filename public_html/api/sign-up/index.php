<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\OurVibe\Venue;

/**
 * api for signing up to venue
 *
 * @author QED
 **/
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
    // grab the mySQL connection
    $pdo = connectToEncryptedMySQL ("/etc/apache2/capstone-mysql/ourvibe.ini");
    //determine http method
    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ?$_SERVER ["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
    if($method === "POST") {
        // Set XSRF cookie
        setXsrfCookie();
        //decode json and turn it into php object

        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);

        //venue address 1 is required
        if(empty($requestObject->venueAddress1) === true) {
            throw(new \InvalidArgumentException ("No venue address", 405));
        }
        //venue city is required
        if(empty($requestObject->venueCity) === true) {
            throw(new \InvalidArgumentException ("No venue city", 405));
        }
        //venue contact is required
        if(empty($requestObject->venueContact) === true) {
            throw(new \InvalidArgumentException ("No venue contact", 405));
        }
        //venue content is required
        if(empty($requestObject->venueContent) === true) {
            throw(new \InvalidArgumentException ("No venue content", 405));
        }
        //venue name is required
        if(empty($requestObject->venueName) === true) {
            throw(new \InvalidArgumentException ("No venue name", 405));
        }
        //venue state is required
        if(empty($requestObject->venueState) === true) {
            throw(new \InvalidArgumentException ("No venue address", 405));
        }
        //venue zip is required
        if(empty($requestObject->venueZip) === true) {
            throw(new \InvalidArgumentException ("No venue address", 405));
        }
        //check if password is present
        if(empty($requestObject->profilePassword) === true) {
            throw(new \InvalidArgumentException ("Must input valid password", 405));
        }

        //check password and confirm match
        if ($requestObject->profilePassword !== $requestObject->profilePasswordConfirmed) {
            throw(new \InvalidArgumentException("passwords do not match"));
        }

        if(empty($requestObject->venueAddress2) === true) {
            $requestObject->venueAddress2 = null;
        }




        $salt = bin2hex(random_bytes(32));
        $hash = hash_pbkdf2("sha512", $requestObject->profilePassword, $salt, 262144);

        $venueActivationToken = bin2hex(random_bytes(16));
        // create venue and prepare the insert into the database
        $venue = new Venue(null, null, $venueActivationToken, $requestObject->venueAddress1, $requestObject->venueCity, $requestObject->venueContact, $requestObject->venueContent,$requestObject->venueName, $requestObject->venueState, $requestObject->venueZip, $requestObject->venueAddress2, $salt, $hash);
        //insert venue into database
        $venue->insert($pdo);
        //compose email and send with activation.php token
        $messageSubject = "Please activate your account";

        //build the link
        $basePath = dirname($_SERVER["SCRIPT_NAME"], 3);
        //create path
        $urlglue = $basePath . "/api/activation.php/?activation.php=" . $venueActivationToken;
        //create the link redirect
        $confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;

        //compose message in email
        $message = <<< EOF
<h2>Welcome to Our Vibe!</h2>
<p>Please confirm your account by clicking the link below</p>
<p><a href="$confirmLink">$confirmLink</a></p>
EOF;

        //create swift mail
        $swiftMessage = new Swift_Message();
        // attach the sender to the message

        $swiftMessage->setForm(["EMAIL GOES HERE" => "Our VIbe"]);

        /**
         * attach recipients to the message
         **/

        $recipients = [$requestObject->venueContact];

        $swiftMessage->setTo($recipients);

        $swiftMessage->setSubject($messageSubject);

        $swiftMessage->setBody($message, "text/html");

        $swiftMessage->addPart(html_entity_decode($message), "text/plain");

        $smtp = new Swift_SmtpTransport(
            "localhost", 25);
        $mailer = new Swift_Mailer($smtp);

        //send the message
        $numSent = $mailer->send($swiftMessage, $failedRecipients);

        if($numSent !== count($recipients)) {
            throw(new RuntimeException("unable to send email"));
        }

        //reply
        $reply->message = "Thank you for signing up with Our Vibe";
    } else {
        throw (new \InvalidArgumentException("invalid http request"));

    }
} catch(\Exception $exception) {
    $reply->status = $exception->getCode();
    $reply->message = $exception->getMessage();
} catch(\TypeError $typeError) {
    $reply->status = $typeError->getCode();
    $reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
echo json_encode($reply);


