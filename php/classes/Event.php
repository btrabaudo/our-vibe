<?php

namespace Edu\Cnm\OurVibe;
require_once("autoload.php");

/**
 * Event class for OurVibe Capstone Project. These are events hosted by venues all over Albuquerque.
 * @author kkristl <kkristl@cnm.edu>
 **/
class Event implements \JsonSerializable {
	use ValidateDate;
	/**
	 * Id for this Event; this is the primary key
	 **/
	private $eventId;
	private $eventVenueId;
	private $eventContact;
	private $eventContent;
	private $eventDateTime;
	private $eventName;

	/**
	 * constructor for this event
	 * @param int|null $newEventId id of this Event or null if a new Event
	 * @param int $newEventVenueId id of the Event Venue that sent this Event
	 * @param string $newEventContact string containing contact information
	 * @param string $newEventContent string containing actual content
	 * @param \DateTime|string $newEventDateTime date and time of event
	 * @param string $newEventName string containing name of event
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \Exception if some other exception occurs
	 * @throws \RangeException if data values are out of bounds
	 **/
	public function __construct(?int $newEventId, int $newEventVenueId, string $newEventContact, string $newEventContent, $newEventDateTime, string $newEventName) {
		try {
			$this->setEventId($newEventId);
			$this->setEventVenueId($newEventVenueId);
			$this->setEventContact($newEventContact);
			$this->setEventContent($newEventContent);
			$this->setEventDateTime($newEventDateTime);
			$this->setEventName($newEventName);
		} //determine the type of exception
		catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor for event id
	 * @return int|null $eventId
	 **/
	public function getEventId(): ?int {
		return ($this->eventId);
	}

	/**
	 * mutator for event id
	 * @param int|null for event id
	 * @throws \RangeException if event id is not positive
	 * @throws \InvalidArgumentException if event id is not an integer
	 **/
	public function setEventId(?int $newEventId): void {
		//if event id is null return it
		if($newEventId === null) {
			$this->eventId = null;
			return;
		}
		//enforce that event id is a positive int
		if($newEventId <= 0) {
			throw(new \RangeException("event id is not positive"));
		}
		//store this event id
		$this->eventId = $newEventId;
	}

	/**
	 * accessor for event venue id
	 * @return int|null $eventVenueId
	 **/
	public function getEventVenueId(): ?int {
		return ($this->eventVenueId);
	}

	/**
	 * mutator for event venue id
	 * @param int|null for event venue id
	 * @throws \RangeException if event venue id is not positive
	 * @throws \InvalidArgumentException if event venue id is not an integer
	 **/
	public function setEventVenueId(int $newEventVenueId): void {
		//enforce that event venue id is a positive int
		if($newEventVenueId <= 0) {
			throw(new \RangeException("event venue id is not positive"));
		}
		//store this event venue id
		$this->eventVenueId = $newEventVenueId;
	}

	/**
	 * accessor for event contact
	 * @return string for event contact
	 **/
	public function getEventContact(): string {
		return ($this->eventContact);
	}

	/**
	 * mutator for event contact
	 * @param string $newEventContact
	 * @throws \InvalidArgumentException if event contact is blank
	 * @throws \RangeException if event contact is more than 128 characters
	 **/
	public function setEventContact(string $newEventContact): void {
		// verify the event content is secure
		$newEventContact = trim($newEventContact);
		$newEventContact = filter_var($newEventContact, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		//enforce can not be blank in event contact
		if(empty($newEventContact) === true) {
			throw(new \InvalidArgumentException("event contact can not be blank"));
		}
		//enforce less than 128 characters in event contact
		if(strlen($newEventContact) > 128) {
			throw(new \RangeException("event contact must be less than 128 characters"));
		}
		$this->eventContact = $newEventContact;
	}

	/**
	 * accessor for event content
	 * @return string for event content
	 **/
	public function getEventContent(): string {
		return $this->eventContent;
	}

	/**
	 * mutator for event content
	 * @param string $newEventContent
	 * @throws \InvalidArgumentException if event content is blank
	 * @throws \RangeException if event content is more than 768 characters
	 **/
	public function setEventContent(string $newEventContent): void {
		// verify the event content is secure
		$newEventContent = trim($newEventContent);
		$newEventContent = filter_var($newEventContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventContent) === true) {
			throw(new \InvalidArgumentException("event content is empty or insecure"));
		}
		// verify the event content will fit in the database
		if(strlen($newEventContent) > 768) {
			throw(new \RangeException("event content too large"));
		}
		// store the tweet content
		$this->eventContent = $newEventContent;
	}

	/**
	 * accessor method for event date
	 * @return $eventDate value of event date
	 **/
	public function getEventDateTime(): \DateTime {
		return ($this->eventDateTime);
	}
	/**
	 * mutator method for tweet date
	 *
	 * @param \DateTime|string|null $newEventDateTime event date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newEventDateTime is not a valid object or string
	 * @throws \RangeException if $newEventDateTime is a date that does not exist
	 **/


	public function setEventDateTime($newEventDateTime): void {
		// base case: if the date is null, use the current date and time
		if($newEventDateTime === null) {
			// throw exception
		}

		// store the event date using the ValidateDate trait
		try {
			$newEventDateTime = self::validateDateTime($newEventDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->eventDateTime = $newEventDateTime;
	}

	/**
	 * accessor for event name
	 * @return string for event name
	 **/
	public function getEventName(): string {
		return ($this->eventName);
	}

	/**
	 * mutator for event name
	 * @param string $newEventName
	 * @throws \InvalidArgumentException if event name is blank
	 * @throws \RangeException if event content is more than 128 characters
	 **/
	public function setEventName(string $newEventName): void {
		// verify the event name is secure
		$newEventName = trim($newEventName);
		$newEventName = filter_var($newEventName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		//enforce event name can not be blank
		if(empty($newEventName) === true) {
			throw(new \InvalidArgumentException("event name can not be blank"));
		}
		//enforce less than 128 characters in event name
		if(strlen($newEventName) > 128) {
			throw(new \RangeException("event name must be less than 128 characters"));
		}
		$this->eventName = $newEventName;
	}

	/**
	 * Inserts event into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws  \TypeError if $pdo is not PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// enforce the eventId is null
		if($this->eventId !== null) {
			throw(new \PDOException("not a new event"));
		}

		//create query
		$query = "INSERT INTO event(eventVenueId, eventContact, eventContent, eventDateTime, eventName) VALUES (:eventVenueId, :eventContact, :eventContent, :eventDateTime, :eventName)";
		$statement = $pdo->prepare($query);

		// bind members to their place holders
		$formattedDate = $this->eventDateTime->format("Y-m-d H:i:s.u");
		$parameters = [
			"eventVenueId" => $this->eventVenueId,
			"eventContact" => $this->eventContact,
			"eventContent" => $this->eventContent,
			"eventDateTime" => $formattedDate,
			"eventName" => $this->eventName
		];
		$statement->execute($parameters);
		$this->eventId = intval($pdo->lastInsertId());
	}

	/**
	 * Deletes event from mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws  \TypeError if $pdo is not PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		//enforce that the event is not null i.e. that it exists
		if($this->eventId === null) {
			throw(new \PDOException("unable to delete an event that does not exist"));
		}
		//create a query
		$query = "DELETE FROM event WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);
		// bind members to their place
		$parameters = ["eventId" => $this->eventId];
		$statement->execute($parameters);
	}

	/**
	 * Updates an event in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws  \TypeError if $pdo is not PDO connection object
	 **/
	public function update(\PDO $pdo): void {
		// enforce the eventId is null
		if($this->eventId === null) {
			throw(new \PDOException("not a new event"));
		}
		$query = "UPDATE event SET eventVenueId = :eventVenueId, eventContact = :eventContact, eventContent = :eventContent, eventDateTime = :eventDateTime, eventName = :eventName WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);
		//binds members to their place holder
		$formattedDate = $this->eventDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["eventVenueId" => $this->eventVenueId, "eventContact" => $this->eventContact, "eventContent" => $this->eventContent, "eventDateTime" => $formattedDate, "eventName" => $this->eventName, "eventId" => $this->eventId];
		$statement->execute($parameters);
	}


	public static function getEventByEventId(\PDO $pdo, int $eventId): ?Event {
		// sanitize the eventId before searching
		if($eventId <= 0) {
			throw(new \PDOException("event id is not positive"));
		}
		// create query template
		$query = "SELECT eventId, eventVenueId, eventContact, eventContent, eventDateTime, eventName FROM event WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);
		// bind the event id to the place holder in the template
		$parameters = ["eventId" => $eventId];
		$statement->execute($parameters);
		// grab the event from mySQL
		try {
			$event = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$event = new Event($row["eventId"], $row["eventVenueId"], $row["eventContact"], $row["eventContent"], $row["eventDateTime"], $row["eventName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($event);
	}
	/**
	 * gets Events by event venue id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $eventVenueId venue id to search by
	 * @return \SplFixedArray SplFixedArray of Events found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getEventByEventVenueId(\PDO $pdo, int $eventVenueId): \SplFixedArray {
		// sanitize the eventVenueId before searching
		if($eventVenueId <= 0) {
			throw(new \PDOException("event venue id is not positive"));
		}
		// create query template
		$query = "SELECT eventId, eventVenueId, eventContact, eventContent, eventDateTime, eventName FROM event WHERE eventVenueId = :eventVenueId";
		$statement = $pdo->prepare($query);
		// bind the event venue id to the place holder in the template
		$parameters = ["eventVenueId" => $eventVenueId];
		$statement->execute($parameters);
		// build an array of tweets
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$event = new Event($row["eventId"], $row["eventVenueId"], $row["eventContact"], $row["eventContent"], $row["eventDateTime"], $row["eventName"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($events);
	}

	/**
	 * gets Event by content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $eventContent event content to search for
	 * @return \SplFixedArray SplFixedArray of Events found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getEventByEventContent(\PDO $pdo, string $eventContent) : \SplFixedArray {
		// sanitize the description before searching
		$eventContent = trim($eventContent);
		$eventContent = filter_var($eventContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($eventContent) === true) {
			throw(new \PDOException("event content is invalid"));
		}
		// create query template
		$query = "SELECT eventId, eventVenueId, eventContact, eventContent, eventDateTime, eventName FROM event WHERE eventContent LIKE :eventContent";
		$statement = $pdo->prepare($query);
		// bind the tweet content to the place holder in the template
		$eventContent = "%$eventContent%";
		$parameters = ["eventContent" => $eventContent];
		$statement->execute($parameters);
		// build an array of tweets
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$event = new Event($row["eventId"], $row["eventVenueId"], $row["eventContact"], $row["eventContent"], $row["eventDateTime"], $row["eventName"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($events);
	}
	/**
	 * gets an array of events based on its date
	 * (this is an optional get by method and has only been added for when specific edge cases arise in capstone projects)
	 *
	 * @param \PDO $pdo connection object
	 * @param \DateTime $sunriseEventDate beginning date to search for
	 * @param \DateTime $sunsetEventDate ending date to search for
	 * @return \SplFixedArray of tweets found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 * @throws \InvalidArgumentException if either sun dates are in the wrong format
	 */
	public static function getEventByEventDate (\PDO $pdo, \DateTime $sunriseEventDate, \DateTime $sunsetEventDate ) : \SplFixedArray {
		//enforce both date are present
		if((empty ($sunriseEventDate) === true) || (empty($sunsetEventDate) === true)) {
			throw (new \InvalidArgumentException("dates are empty or insecure"));
		}
		//ensure both dates are in the correct format and are secure
		try {
			$sunriseEventDate = self::validateDateTime($sunriseEventDate);
			$sunsetEventDate = self::validateDateTime($sunsetEventDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT eventId, eventVenueId, eventContact, eventContent, eventDateTime, eventName from event WHERE eventDateTime >= :sunriseEventDate AND eventDateTime <= :sunsetEventDate";
		$statement = $pdo->prepare($query);
		//format the dates so that mySQL can use them
		$formattedSunriseDate = $sunriseEventDate->format("Y-m-d H:i:s");
		$formattedSunsetDate = $sunsetEventDate->format("Y-m-d H:i:s");
		$parameters = ["sunriseEventDate" => $formattedSunriseDate, "sunsetEventDate" => $formattedSunsetDate];
		$statement->execute($parameters);
		//build an array of tweets
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch())  !== false) {
			try {
				$event = new Event($row["eventId"], $row["eventVenueId"], $row ["eventContact"], $row["eventContent"], $row["eventDateTime"], $row["eventName"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				throw (new \PDOException($exception->getMessage(),0, $exception));
			}
		}
		return($events);
	}
	/**
	 * get Event by Event Name
	 */
	// @expectedException \PDOException
	public static function getEventByEventName(\PDO $pdo, string $eventName): \SplFixedArray {
		//Sanitiz\e city
		$eventName = trim($eventName);
		$eventName = filter_var($eventName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		// sanitize the event name before searching
		if(empty($eventName) === true) {
			throw(new \PDOException("event name is either empty or insecure"));
		}
		// create query template
		$query = "SELECT eventId, eventVenueId, eventContact, eventContent, eventDateTime, eventName FROM event WHERE eventName LIKE :eventName";
		$statement = $pdo->prepare($query);
		// bind the event name to the place holder in the template
		$eventName = "%$eventName%";
		$parameters = ["eventName" => $eventName];
		$statement->execute($parameters);

		//build the array of events
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$event = new Event($row["eventId"], $row["eventVenueId"], $row ["eventContact"], $row["eventContent"], $row["eventDateTime"], $row["eventName"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($events);
	}
	/**
	 * gets all Events
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Events found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllEvents(\PDO $pdo) : \SplFixedArray {
		// create query template
		$query = "SELECT eventId, eventVenueId, eventContact, eventContent, eventDateTime, eventName FROM event";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of events
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$event = new Event($row["eventId"], $row["eventVenueId"], $row ["eventContact"], $row["eventContent"], $row["eventDateTime"], $row["eventName"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($events);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function JsonSerialize() {
		$fields = get_object_vars($this);
		//format the sate so that the front end can consume it
		$fields["eventDateTime"] = round(floatval($this->eventDateTime->format("U.u")) * 1000);
		return ($fields);


	}
}