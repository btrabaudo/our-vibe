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

if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	$pdo = connectToEncryptedMySQL("/etc/apache2/Our-Vibe-mysql/ourvibe.ini");

	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	$tagId = filter_input(INPUT_GET, "tagId", FILTER_VALIDATE_INT);
	$tagName = filter_input(INPUT_GET, "tagName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	if(($method === "DELETE" || $method === "PUT") && (empty($tagId) < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	if($method === "GET") {
		setXsrfCookie();

		if(empty($tagId) === false) {
			$tag = Tag::getTagByTagId($pdo, $tagId);
			if($tag !== null) {
				$reply->data = $tag;
			}
		} elseif(empty($tagName) === false) {
			$tags = Tag::getTagByTagName($pdo, $tagName)->toArray();
			if($tags !== null) {
				$reply->data = $tags;
			}
		} else {
			$tags = Tag::getAllTags($pdo)->toArray();
			if($tags !== null) {
				$reply->data = $tags;
			}
		}
	} elseif($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);


		if(empty($requestObject->tagName) === true) {
			throw(new \InvalidArgumentException("no content for tag", 405));
		}
		if(empty($requestObject->tagId) === true) {
			throw (new \InvalidArgumentException("no tag id", 405));
		}
		if($method === "PUT") {
			$tag = Tag::getTagByTagId($pdo, $tagId);
			if($tag === null) {
				throw (new \RangeException("tag does not exist", 404));
			}
			if(empty($_SESSION["tag"]) === true || $_SESSION["tag"]->getTagId() !== $tag->getTagName()) {
				throw (new \InvalidArgumentException("you are not allowed to edit this tag", 403));
			}
			$tag->setTagName($requestObject->tagName);
			$tag->update($pdo);
			$reply->message = "tag updated ok";
		} elseif($method === "POST") {
			if(empty($_SESSION["tag"]) === true) {
				throw(new \InvalidArgumentException("you must be signed in to post tags", 403));
			}
			$tag = new Tag(null, $requestObject->tagId, $requestObject->tagName);
			$tag->insert($pdo);
			$reply->message = "tag created ok";
		}
	} elseif($method === "DELETE") {
		verifyXsrf();
		$tag = Tag::getTagByTagId($pdo, $tagId);
		if($tag === null) {
			throw(new \RuntimeException("tag does not exist", 404));
		}
		if(empty($_SESSION["tag"]) === true || $_SESSION["tag"]->getTagId() !== $tag->getTagId()) {
			throw(new \InvalidArgumentException("you are not allowed to delete this tag", 403));
		}
		// delete tweet
		$tag->delete($pdo);
		// update reply
		$reply->message = "Tweet deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("content-type:application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);