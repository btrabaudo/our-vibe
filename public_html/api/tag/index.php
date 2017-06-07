<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


use Edu\Cnm\OurVibe\{
    Tag

};

/**
 * API for the EventTag class
 * @author paul baca
 **/

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
    $pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/ourvibe.ini");

    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $tagName = filter_input(INPUT_GET, "tagName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    if ($method === "GET") {
        setXsrfCookie();

        if (empty($id) === false) {
            $tag = Tag::getTagByTagId($pdo, $id);
            if ($tag !== null) {
                $reply->data = $tag;
            }
        } elseif (empty($tagName) === false) {
            $tags = Tag::getTagByTagName($pdo, $tagName)->toArray();
            if ($tags !== null) {
                $reply->data = $tags;
            }
        } else {
            $tags = Tag::getAllTags($pdo)->toArray();
            if ($tags !== null) {
                $reply->data = $tags;
            }
        }
    } elseif ($method === "POST") {
        verifyXsrf();
        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);


        if (empty($requestObject->tagName) === true) {
            throw(new \InvalidArgumentException("no content for tag", 405));
        }

        if (empty($_SESSION["venue"]) === true) {
            throw(new \InvalidArgumentException("you must be signed in to post tags", 401));
        }
        $tag = new Tag(null, $requestObject->tagName);
        $tag->insert($pdo);
        $reply->message = "tag created ok";

    } else {
        throw (new InvalidArgumentException("Invalid HTTP method request"));
    }
} catch (\Exception | \TypeError $exception) {
    $reply->status = $exception->getCode();
    $reply->message = $exception->getMessage();
}
header("content-type:application/json");
if ($reply->data === null) {
    unset($reply->data);
}
echo json_encode($reply);