<?php

namespace Edu\Cnm\OurVibe;

require_once("autoload.php");

class EventTag implements \jsonSerializable {
	/**
	 * id of eventTag
	 * @var int eventTagEventId
	 **/
	private $eventTagEventId;
	/**
	 * id of the eventTagTagid
	 * @var int $eventTagTagId
	 **/
	private $eventTagTagId;

	/**
	 * constructor for this eventTag
	 * @param int|null $newEventTagEventId
	 * @param int $newEventTagTagId
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds negative integers
	 * @throws \TypeError id data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newEventTagEventId, int $newEventTagTagId) {
		try {
			$this->setEventTagEventId($newEventTagEventId);
			$this->setEventTagTagId($newEventTagTagId);

		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for eventTagEventId
	 * @return int|null value of eventTagEventId
	 **/

	public function getEventTagEventId(): int {
		return ($this->eventTagEventId);
	}

	/**
	 * mutator method for eventTagEventId
	 * @param int|null $newEventTagEventId
	 * @throws \RangeException if $newEventTagEventId is not positive
	 * @throws \TypeError if $newEventTagEventId is not an integer
	 **/
	public function setEventTagEventId(?int $newEventTagEventId): void {
		if($newEventTagEventId === null) {
			return;
		}
		if($newEventTagEventId <= 0) {
			throw(new \RangeException("EventTagEventId is not positive"));
		}
		$this->eventTagEventId = $newEventTagEventId;
	}

	/**
	 * accessor method for EventTagTagId
	 * @return int value of EventTagTagId
	 **/
	public function getEventTagTagId(): int {
		return ($this->eventTagTagId);
	}

	/**
	 * mutator method for eventTagTagId
	 * @param int $newEventTagTagId new value of eventTag
	 * @throws \RangeException if $newEventTagTagId is not positive
	 * @throws \TypeError if $newEventTagTagId is not an integer
	 **/

	public function setEventTagTagId(int $newEventTagTagId): void {
		if($newEventTagTagId <= 0) {
			throw(new \RangeException("EventTagTagId is not positive"));
		}
		$this->eventTagTagId = $newEventTagTagId;
	}

	/**
	 * inserts EventTag into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function insert(\PDO $pdo): void {
		if($this->eventTagEventId !== null) {
			throw(new \PDOException("not a new EventTagEventId"));
		}
		$query = "INSERT INTO eventTag(eventTagEventId,eventTagTagId) VALUES(:eventTagEventId,eventTagTagId)";
		 $statement = $pdo->prepare($query);
		$this->eventTagEventId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this EventTag from mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		if($this->eventTagEventId === null) {
			throw(new \PDOException("unable to delete a event tag that does not exist"));
		}
		$query = "DELETE FROM eventTag WHERE eventTagTagId = :evenTagTagId";
		$statement = $pdo->prepare($query);
		$parameters = ["eventTagEventId" => $this->eventTagEventId];
		$statement->execute($parameters);
	}

	/**
	 * updates eventTag in mySQL
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function update(\PDO $pdo): void {
		if($this->eventTagEventId === null) {
			throw(new \PDOException("unable to update a eventTag that does not exist"));
		}
		$query = "UPDATE eventTag SET eventTagEventId = :eventTagTagId = : evenTagEvent WHERE eventTagTagId =:eventTagEventId";
		$statement = $pdo->prepare($query);
	}

	/**
	 * gets eventTag by EventTagEventId
	 * @param \PDO $pdo PDO connection objet
	 * @param int $EventTagEventId eventTag to search for
	 * @return eventTag|null eventTag found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getEventTagByEventTagEventId(\PDO $pdo, int $eventTagEventId): ?eventTag {
		if($eventTagEventId <= 0) {
			throw(new \PDOException("eventTag id is not positive"));
		}
		$query = "SELECT eventTag, eventTagEventId, EventTagTagId FROM eventTag WHERE eventTagEventId =:eventTag";
		$statment = $pdo->prepare($query);
		try {
			$eventTag = null;
			$statment->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statment->fetch();
			if($row !== false) {
				$eventTag = new eventTag($row["eventTagEventTagId"], $row["evenTagTagId"]);
			}

		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($eventTag);
	}

	/**
	 * gets eventTag by eventTagTagId
	 * @para \PDO $pdo PDO connection object
	 * @param int $eventTagTagId to search by
	 * @return \SplFixedArray splFixedArray of eventTags found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getEventTagbyEventTagTagId(\PDO $pdo, int $eventTagTagId): \SplFixedArray {
		if($eventTagTagId <= 0) {
			throw(new \RangeException("eventTag must be positive"));
		}
		$query = "SELECT eventTag.eventTagEventId, eventTagTagId FROM eventTag WHERE eventTagTagId =:eventTagTagId";
		$statement = $pdo->prepare($query);
		$parameters = ["eventTagTagId" => $eventTagTagId];
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$eventTag = new eventTag($row["eventTag"], $row["eventTagTagId"], $row["eventTagEventId"]);
				$eventTags[$eventTags->key()] = $eventTag;
				$eventTags->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($eventTags);
	}

	/**
	 * gets event by eventTagEventId and EventTagTagId
	 * @param \PDO $pdo PDO connection object
	 * @param int $eventTagEventId event id to search for
	 * @param int $eventTagTagId Event Tag id to search for
	 * @return Event|null Event found or null if not found
	**/

	public static function getEventTagEventByEventTagIdAndEvenTagTagId(\PDO $pdo, int $eventTagEventId, int $eventTagTagId) : ?Event{
		// sanitize the tweet id and profile id before searching
		if($eventTagEventId <= 0) {
			throw(new \PDOException("eventTagEventId is not positive"));
		}
		if($eventTagTagId <= 0) {
			throw(new \PDOException("eventTagTagId is not positive"));
		}
		// create query template
		$query = "SELECT eventTagEventId, eventTagTagId FROM `eventTag` WHERE eventTagEventId= :EventTagEventId AND eventTagEventId = :EventTagEventId";
		$statement = $pdo->prepare($query);
		// bind the tweet id and profile id to the place holder in the template
		$parameters = ["eventTagEventId" => $eventTagEventId, "eventTagTagID" => $eventTagEventId];
		$statement->execute($parameters);}

	/**
	 * gets all events tags
	 * @param \PDO $pdo PDO connection
	 * @return \SplFixedArray SplFixedArray of eventTags found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/

	public static function getAllEventTags(\PDO $pdo): \SplFixedArray {
		$query = "SELECT eventTag, eventTagEventId,EventTagTagId FROM eventTag";
		$statement = $pdo->prepare($query);
		$statement->execute();
		$eventTags = new \SplFixedArray($statement->rowcount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$eventTag = new eventTag($row["eventTag"], $row["eventTagEventId"], ["eventTagTagId"]);
				$eventTags[$eventTags->key()] = $eventTag;
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($eventTags);
	}

	/**
	 * formats the state variables for JSON serialization
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		// TODO: Implement jsonSerialize() method.
	}

}