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
	public function setEventTagEventId(int $newEventTagEventId): void {
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
		$query = "INSERT INTO eventTag(eventTagEventId,eventTagTagId) VALUES(:eventTagEventId, :eventTagTagId)";
		$statement = $pdo->prepare($query);
		// BIND PARAMETERS HERE
		$parameters = ["eventTagEventId" => $this->eventTagEventId, "eventTagTagId" => $this->eventTagTagId];
		$statement->execute($parameters);
		// EXECUTE STATEMENT HERE
	}

	/**
	 * deletes this EventTag from mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		if($this->eventTagEventId === null || $this->eventTagTagId === null) {
			throw(new \PDOException("unable to delete a event tag that does not exist"));
		}

		$query = "DELETE FROM eventTag WHERE (eventTagEventId = :eventTagEventId AND eventTagTagId = :eventTagTagId)";
		$statement = $pdo->prepare($query);
		// todo: update paramenters here

		$parameters = ["eventTagEventId" => $this->eventTagEventId,"eventTagTagId"=>$this->getEventTagTagId()];
		$statement->execute($parameters);
	}


	/**
	 * gets eventTag by EventTagEventId
	 * @param \PDO $pdo PDO connection objet
	 * @param int $EventTagEventId eventTag to search for
	 * @return eventTag|null eventTag found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 * @return \SplFixedArray splFixArray of event tags found
	 **/
	public static function getEventTagsByEventTagEventId(\PDO $pdo, int $eventTagEventId): \SplFixedArray {
		if($eventTagEventId <= 0) {
			throw(new \PDOException("eventTag id is not positive"));
		}
		//needs while loop
		$query = "SELECT eventTagEventId, eventTagTagId FROM eventTag WHERE eventTagEventId =:eventTagEventId";
		$statement = $pdo->prepare($query);
		$parameters = ["eventTagEventId" => $eventTagEventId];
		$statement->execute($parameters);
		$eventTags = new \SplFixedArray($statement->rowcount());
		while(($row = $statement->fetch()) !== false) {
			try {
				$eventTag = new EventTag( $row["eventTagEventId"], $row["eventTagTagId"]);
				$eventTags[$eventTags->key()] = $eventTag;
				$eventTags->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($eventTags);
	}

	/**
	 * gets eventTag by eventTagTagId
	 * @para \PDO $pdo PDO connection object
	 * @param int $eventTagTagId to search by
	 * @return \SplFixedArray splFixedArray of eventTags found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getEventTagsByEventTagTagId(\PDO $pdo, int $eventTagTagId): \SplFixedArray {
		if($eventTagTagId <= 0) {
			throw(new \RangeException("eventTag must be positive"));
		}
		$query = "SELECT eventTagEventId, eventTagTagId FROM eventTag WHERE eventTagTagId =:eventTagTagId";
		$statement = $pdo->prepare($query);
		$parameters = ["eventTagTagId" => $eventTagTagId];
		$statement->execute($parameters);
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		$eventTags = new \SplFixedArray($statement->rowCount());
		while(($row = $statement->fetch()) !== false) {
			try {
				$eventTag = new EventTag($row["eventTagEventId"], $row["eventTagTagId"]);
				$eventTags[$eventTags->key()] = $eventTag;
				$eventTags->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($eventTags);
	}

	/**
	 * gets eventTag by eventTagEventId and EventTagTagId
	 * @param \PDO $pdo PDO connection object
	 * @param int $eventTagEventId event id to search for
	 * @param int $eventTagTagId Event Tag id to search for
	 * @return Event|null Event found or null if not found
	 **/
	public static function getEventTagByEventTagEventIdAndEventTagTagId(\PDO $pdo, int $eventTagEventId, int $eventTagTagId): ?EventTag {
		// sanitize the tweet id and profile id before searching
		if($eventTagEventId <= 0) {
			throw(new \PDOException("eventTagEventId is not positive"));
		}
		if($eventTagTagId <= 0) {
			throw(new \PDOException("eventTagTagId is not positive"));
		}
		// create query template
		$query = "SELECT eventTagEventId, eventTagTagId FROM eventTag WHERE eventTagEventId = :eventTagEventId AND eventTagTagId = :eventTagTagId";
		$statement = $pdo->prepare($query);
		// bind the tweet id and profile id to the place holder in the template
		$parameters = ["eventTagEventId" => $eventTagEventId, "eventTagTagId" => $eventTagTagId];
		$statement->execute($parameters);
		try {
			$eventTag = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$eventTag = new EventTag($row["eventTagEventId"], $row["eventTagTagId"]);
			}

		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($eventTag);
	}


	/**
	 * gets all events tags
	 * @param \PDO $pdo PDO connection
	 * @return \SplFixedArray SplFixedArray of eventTags found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllEventTags(\PDO $pdo): \SplFixedArray {
		$query = "SELECT eventTagEventId,EventTagTagId FROM eventTag";
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
		$fields = get_object_vars($this);
		return ($fields);
		// TODO: Implement jsonSerialize() method.
	}


}