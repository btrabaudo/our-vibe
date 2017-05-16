<?php

namespace Edu\Cnm\OurVibe;
require_once ("autoload.php");
/**
 * this is each image for each event
 *
 * @author Marcoder <mlester3@cnm.edu
 * @version 7.1.0
 **/
class EventImage implements \JsonSerializable {

	/**
	 * id of the image being posted; this is a a component of a composite primary and foreign key
	 * @var int $eventImageImageId
	 **/
	private $eventImageImageId;

	/**
	 * id of the event the image belongs to; this is a a component of a composite primary and foreign key
	 * @var int $eventImageEventId
	 **/
	private $eventImageEventId;

	/**
	 * constructor for eventImage
	 *
	 * @param int $newEventImageImageId id of the parent Image
	 * @param int $newEventImageEventId id of the parent eventImage belongs to
	 * @throws \InvalidArgumentException if data values are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., stringstoo long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs

	 **/
	public function __construct(int $newEventImageImageId, int $newEventImageEventId = null) {
		try {
			$this->setEventImageImageId($newEventImageImageId);
			$this->setEventImageEventId($newEventImageEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

			// determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for image id
	 *
	 * @return int value of image id
	 **/
	public function getEventImageImageId(): int {
		return ($this->eventImageImageId);
	}

	/**
	 * mutator for image id
	 *
	 * @param int $newEventImageImageId new value of image id
	 * @throws \RangeException if $newImageId is not positive
	 * @throws \TypeError if $newImageId is not an integer
	 **/
	public function setEventImageImageId(int $newImageId): void {
		// verify the profile is positive
		if($newImageId <= 0) {
			throw(new \RangeException("image id is not positive"));
		}

		// convert and store the image id
		$this->eventImageImageId = $newImageId;
	}

	/**
	 * accessor method for event id
	 *
	 * @return int value of event id
	 **/
	public function getEventImageEventId(): int {
		return ($this->eventImageEventId);
	}

	/**
	 * mutator method for event id
	 *
	 * @param int $newEventImageEventId new value of  event id
	 * @throws \RangeException if $newEventId is not positive
	 * @throws \TypeError if $newEventId is not an integer
	 **/
	public function setEventImageEventId(int $newEventImageEventId): void {
		// verify the product id is positive
		if($newEventImageEventId <= 0) {
			throw(new \RangeException("event id is not positive"));
		}
		// convert and store the event id
		$this->eventImageEventId = $newEventImageEventId;
	}

	/**
	 * inserts this  into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException whe mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// ensure the object exists before inserting
		if($this->eventImageImageId === null || $this->eventImageEventId === null) {
			throw(new \PDOException("not a valid image"));
		}

		// create query template
		$query = "DELETE FROM eventImage WHERE eventImageImageId = :eventImageImageId AND eventImageEventId = :eventImageEventId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["eventImageImageId" => $this->eventImageImageId, "eventImageEventId" => $this->eventImageEventId];
		$statement->execute($parameters);
	}

	/**
	 * deletes this eventImage from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
				// ensure the object exists before deleting
				if($this->eventImageImageId === null || $this->eventImageEventId === null) {
							throw(new \PDOException("not a valid eventImage"));
				}

				// create query template
				$query = "DELETE FROM 'eventImage' WHERE eventImageImageId = :eventImageImageId AND eventImageEventId = :eventImageEventId";
				$statement = $pdo->prepare($query);

				// bind the member variables to the place holders in the template
				$parameters = ["eventImageImageId" => $this->eventImageImageId, "eventImageEventId" => $this->eventImageEventId];
				$statement->execute($parameters);
	}

	/**
	 * gets the eventImage by image id and event id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $eventImageImageId image id to search for
	 * @param int $eventImageEventId event id to search for
	 * @return EventImage|null eventImage found or null if not found
	 **/
	public static function getEventImageByEventImageEventIdAndEventImageImageId(\PDO $pdo, int $eventImageImageId, int $eventImageEventId) : ?EventImage {
				// sanitize the event id and image id before searching
				if($eventImageImageId<= 0) {
							throw(new \PDOException("image id is not positive"));
				}
				if($eventImageEventId <= 0) {
							throw(new \PDOException("event id is not positive"));
				}

				// create query template
				$query = "SELECT eventImageImageId, eventImageEventId FROM eventImage WHERE eventImageImageId = :eventImageImageId AND eventImageEventId = :eventImageEventId";
				$statement = $pdo->prepare($query);

				// bind the event id and image id to the place holder in the template
				$parameters = ["eventImageImageId" => $eventImageImageId, "eventImageEventId" => $eventImageEventId];
				$statement->execute($parameters);

				// grab the eventImage from mySQL
				try {
							$eventImage = null;
							$statement->setFetchMode(\PDO::FETCH_ASSOC);
							$row = $statement->fetch();
							if($row !== false) {
										$eventImage = new EventImage($row["eventImageImageId"], $row["eventImageEventID"]);
							}
				} catch(\Exception $exception) {
							// if the row couldn't be converted, rethrow it
							throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
				return ($eventImage);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
				$fields = get_object_vars($this);
	}

}
