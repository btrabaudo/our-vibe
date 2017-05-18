<?php
namespace Edu\Cnm\OurVibe;
require_once ("autoload.php");
	/**
 	* Event for OurVibe
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
	private $eventDate;
	private $eventName;
	/**
	 * constructor for this event

	 * @param int|null $newEventId
	 * @param int|null $newEventVenueId
	 * @param string $newEventContact
	 * @param string $newEventContent
	 * @param \Date|string|null $newEventDate
	 * @param string $newEventName
	 *
	 * @throws \InvalidArgumentException
	 * @throws \InvalidArgumentException
	 * @throws \RangeException
	 * @throws \RangeException
	 * @throws \Exception
	 * @throws \RangeException
	 **/
	public function __construct(?int $newEventId, ?int $newEventVenueId, string $newEventContact, string $newEventContent, $newEventDate = null, string $newEventName) {
		try {
			$this->setEventId($newEventId);
			$this->setEventVenueId($newEventVenueId);
			$this->setEventContact($newEventContact);
			$this->setEventContent($newEventContent);
			$this->setEventDate($newEventDate);
			$this->setEventName($newEventName);
		}
		//determine the type of exception
		catch(\InvalidArgumentException | \RangeException | \RangeException | \Exception | \RangeException $exception) {
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
			if ($newEventId === null) {
				$this->eventId = null;
				return;
			}
			//enforce that event id is a positive int
			if ($newEventId <= 0) {
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
			//if event venue id is null return it
			if ($newEventVenueId === null) {
				$this->eventVenueId = null;
				return;
			}
			//enforce that event venue id is a positive int
			if ($newEventVenueId <= 0) {
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
		return $this->eventContact;
	}
	/**
	 * mutator for event contact
	 * @param string $newEventContact
	 * @throws \InvalidArgumentException if event contact is blank
	 * @throws \RangeException if event contact is more than 128 characters
	 **/
	public function setEventContact(string $newEventContact): void {
		$newEventContact = filter_var($newEventContact, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		//enforce can not be blank in event contact
		if (empty($newEventContact)) {
			throw(new \InvalidArgumentException("event contact can not be blank"));
		}
		//enforce less than 128 characters in event contact
		if (strlen($newEventContact) > 128) {
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
	 * @return \Date value of event date
	 **/
	public function getEventDate(): \DateTime {
		return $this->eventDate;
	}

		//* mutator method for event date

		public function setEventDate($newEventDate = null) : void {
			// base case: if the date is null, use the current date and time
			if($newEventDate === null) {
				$this->eventDate = new \DateTime();
				return;
			}
			// store the like date using the ValidateDate trait
			try {
				$newEventDate = self::validateDateTime($newEventDate);
			} catch(\InvalidArgumentException | \RangeException $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
			$this->eventDate = $newEventDate;
	}
	/**
	 * accessor for event name
	 * @return string for event name
	 **/
	public function getEventName(): string {
		return $this->eventName;
	}
	/**
	 * mutator for event name
	 * @param string $newEventName
	 * @throws \InvalidArgumentException if event name is blank
	 * @throws \RangeException if event content is more than 128 characters
	 **/
	public function setEventName(string $newEventName): void {
		$newEventName = filter_var($newEventName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		//enforce event name can not be blank
		if (!ctype_alnum($newEventName)) {
			throw(new \InvalidArgumentException("event name can not be blank"));
		}
		//enforce less than 128 characters in event name
		if (strlen($newEventName) < 128) {
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
	public function insert(\PDO $pdo) : void {
		// enforce the eventId is null
		if($this->eventId !== null) {
			throw(new \PDOException("not a new event"));
		}
		//create query
		$query = "INSERT INTO event(eventId, eventVenueId, eventContact, eventContent, eventDate, eventName) VALUES (:eventId, :eventVenueId, :eventContact, :eventContent, :eventDate, :eventName)";
		$statement = $pdo->prepare($query);
		// bind members to their place holders
		$formattedDate = $this->eventDate->format("Y-m-d H:i:s:u");
		$parameters = ["eventId" => $this->eventId, "eventVenueId" => $this->eventVenueId, "eventContact" => $this->eventContact, "eventContent" => $this->eventContent, "eventDate" => $formattedDate, "eventName" => $this->eventName];
		$statement->execute($parameters);
		$this->eventId = intval($pdo->lastInsertId());
	}
	/**
	 * Deletes event from mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors occur
	 * @throws  \TypeError if $pdo is not PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
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
	public function updated(\PDO $pdo) : void {
		// enforce the eventId is null
		if($this->eventId !== null) {
			throw(new \PDOException("not a new event"));
		}
		$query = "UPDATE event SET eventVenueId = :eventVenueId, eventContact = :eventContact, eventContent = :eventContent, eventDate = :eventDate, eventName = :eventName WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);
		//binds members to their place holder
		$formattedDate = $this->eventDate->format("Y-m-d H:i:s:u");
		$parameters = ["eventContact" => $this->eventContact, "eventContent" => $this->eventContent, "eventDate" => $formattedDate, "eventName" => $this->eventName];
		$statement->execute($parameters);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function JsonSerialize() {
		$fields = get_object_vars($this);
		//format the sate so that the front end can consume it
		$fields["eventDate"] = round(floatval($this->eventDate->format("U.u")) * 1000);
		return($fields);
	}
}