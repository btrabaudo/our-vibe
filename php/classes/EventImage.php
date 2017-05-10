<?php

namespace Edu\Cnm\OurVibe;
require_once ("autoload.php");
/**
 * this is each image for each event
 *
 * @author Marcoder <mlester3@cnm.edu
 * @version 7.1.0
 **/
class EventImage \JsonSerializable {

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
	 * @param int $newEventImageEventId id of the parent event image belongs to
	 * @throws \Exception if some other exception occurs
	 * @throws \TypeError if data types violate type hints
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
	 * @return int value of profile id
	 **/
	public function getEventImageImageId(): int {
		return ($this->eventImageImageId);
	}

	/**
	 * mutator for image id
	 *
	 * @param int $newEventImageImageId new value of profile id
	 * @throws \RangeException if $newImageId is not posititve
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
	 * @return int value of image id
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
	 * inserts this event image into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException whe mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// ensure the object exists befor inserting
		if($this->eventImageImageId === null || $this->eventImageImageId === null) {
			throw(new \PDOException("not a valid image"));
		}

		// create query template
		$query = "DELETE FROM eventImage WHERE eventImageImageId = :eventImageImageId AND eventImageEventId = 		:eventImageEventId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the lace holders in the template
		$parameters = ["eventImageImageId" => $this->eventImageImageId, "eventImageEventId" => $this->eventImageImageId];
		$statement - execute($parameters);
	}

	/**
	 * deletes this event image from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
				// ensure the object exists before deleting
				if($this->eventImageImageId === null || $this->eventImageImageId ===) {
							throw(new \PDOException("not a valid event image"));
				}
	}
}