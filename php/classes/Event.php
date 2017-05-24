<?php

namespace Edu\Cnm\OurVibe;
require_once("autoload.php");

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
    private $eventDateTime;
    private $eventName;

    /**
     * constructor for this event
     * @param int|null $newEventId
     * @param int $newEventVenueId
     * @param string $newEventContact
     * @param string $newEventContent
     * @param \DateTime|string $newEventDateTime
     * @param string $newEventName
     * @throws \InvalidArgumentException
     * @throws \RangeException
     * @throws \Exception
     * @throws \RangeException
     **/
    public function __construct(?int $newEventId, int $newEventVenueId, string $newEventContact, string $newEventContent, $newEventDateTime, string $newEventName){
        try {
            $this->setEventId($newEventId);
            $this->setEventVenueId($newEventVenueId);
            $this->setEventContact($newEventContact);
            $this->setEventContent($newEventContent);
            $this->setEventDateTime($newEventDateTime);
            $this->setEventName($newEventName);
        } //determine the type of exception
        catch (\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }

    /**
     * accessor for event id
     * @return int|null $eventId
     **/
    public function getEventId(): ?int
    {
        return ($this->eventId);
    }

    /**
     * mutator for event id
     * @param int|null for event id
     * @throws \RangeException if event id is not positive
     * @throws \InvalidArgumentException if event id is not an integer
     **/
    public function setEventId(?int $newEventId): void
    {
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
    public function getEventVenueId(): ?int
    {
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
    public function getEventContact(): string
    {
        return ($this->eventContact);
    }

    /**
     * mutator for event contact
     * @param string $newEventContact
     * @throws \InvalidArgumentException if event contact is blank
     * @throws \RangeException if event contact is more than 128 characters
     **/
    public function setEventContact(string $newEventContact): void
    {
        // verify the event content is secure
        $newEventContact = trim($newEventContact);
        $newEventContact = filter_var($newEventContact, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        //enforce can not be blank in event contact
        if (empty($newEventContact) === true) {
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
    public function getEventContent(): string
    {
        return $this->eventContent;
    }

    /**
     * mutator for event content
     * @param string $newEventContent
     * @throws \InvalidArgumentException if event content is blank
     * @throws \RangeException if event content is more than 768 characters
     **/
    public function setEventContent(string $newEventContent): void
    {
        // verify the event content is secure
        $newEventContent = trim($newEventContent);
        $newEventContent = filter_var($newEventContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (empty($newEventContent) === true) {
            throw(new \InvalidArgumentException("event content is empty or insecure"));
        }
        // verify the event content will fit in the database
        if (strlen($newEventContent) > 768) {
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

    //* mutator method for event date

    public function setEventDateTime($newEventDateTime): void {
        // base case: if the date is null, use the current date and time
        if ($newEventDateTime === null) {
            // throw exception
        }

        // store the event date using the ValidateDate trait
        try {
            $newEventDateTime = self::validateDateTime($newEventDateTime);
        } catch (\InvalidArgumentException | \RangeException $exception) {
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
        if (empty($newEventName) === true) {
            throw(new \InvalidArgumentException("event name can not be blank"));
        }
        //enforce less than 128 characters in event name
        if (strlen($newEventName) > 128) {
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
        $formattedDate = $this->eventDateTime->format("Y-m-d H:i:s");
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
        if ($this->eventId === null) {
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
        $formattedDate = $this->eventDateTime->format("Y-m-d H:i:s");
        $parameters = ["eventVenueId" => $this->eventVenueId, "eventContact" => $this->eventContact, "eventContent" => $this->eventContent, "eventDateTime" => $formattedDate, "eventName" => $this->eventName, "eventId" => $this->eventVenueId];
        $statement->execute($parameters);
    }


    public static function getEventByEventId(\PDO $pdo, int $eventId): ?Event
    {
        // sanitize the eventId before searching
        if ($eventId <= 0) {
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
            if ($row !== false) {
                $event = new Event($row["eventId"], $row["eventVenueId"], $row["eventContact"],$row["eventContent"], $row["eventDateTime"], $row["eventName"]);
            }
        } catch (\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return ($event);
    }

    // Y U No docblock? Needs to rtn SplFixed
    public static function getEventsByEventVenueId(\PDO $pdo, int $eventVenueId): ?Event
    {
        // sanitize the eventVenueId before searching
        if ($eventVenueId <= 0) {
            throw(new \PDOException("event venue id is not positive"));
        }
        // create query template
        $query = "SELECT eventId, eventVenueId, eventContact, eventContent, eventDateTime, eventName FROM event WHERE eventVenueId = :eventVenueId";
        $statement = $pdo->prepare($query);
        // bind the event venue id to the place holder in the template
        $parameters = ["eventVenueId" => $eventVenueId];
        $statement->execute($parameters);
        // grab the event from mySQL
        try {
            $event = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if ($row !== false) {
                $event = new Event($row["eventId"], $row["eventVenueId"],$row ["eventContact"], $row["eventContent"], $row["eventDateTime"], $row["eventName"]);
            }
        } catch (\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return ($event);
    }

    // no docblock! rewrite for SplFixedArray
    public static function getEventByEventContent(\PDO $pdo, int $eventContent): \SplFixedArray
    {
        // sanitize the eventContent before searching
        if ($eventContent <= 0) {
            throw(new \PDOException("event content is not positive"));
        }
        // create query template
        $query = "SELECT eventId, eventVenueId, eventContact, eventContent, eventDateTime, eventName FROM event WHERE eventContent LIKE :eventContent";
        $statement = $pdo->prepare($query);
        // bind the event content to the place holder in the template
        $parameters = ["eventContent" => $eventContent];
        $statement->execute($parameters);
        // grab the tweet from mySQL
        try {
            $event = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if ($row !== false) {
                $event = new Event($row["eventId"], $row["eventVenueId"],$row ["eventContact"], $row["eventContent"], $row["eventDateTime"], $row["eventName"]);
            }
        } catch (\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return ($event);
    }

    // finsih docblock and also see Tweet example of getting by sunrise/sunset
    public static function getEventByEventDate(\PDO $pdo, $eventDateTime): ?Event
    {
        // sanitize the event date before searching
        if ($eventDateTime <= 0) {
            throw(new \PDOException("event date is not positive"));
        }
        // create query template
        $query = "SELECT eventId, eventVenueId, eventContact, eventContent, eventDateTime, eventName FROM event WHERE eventDateTime = :eventDateTime";
        $statement = $pdo->prepare($query);
        // bind the event date to the place holder in the template
        $parameters = ["eventDateTime" => $eventDateTime];
        $statement->execute($parameters);
        // grab the tweet from mySQL
        try {
            $event = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if ($row !== false) {
                $event = new Event($row["eventId"], $row["eventVenueId"],$row ["eventContact"], $row["eventContent"], $row["eventDateTime"], $row["eventName"]);
            }
        } catch (\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return ($event);
    }
		// @expectedException \PDOException
    public static function getEventByEventName(\PDO $pdo, string $eventName): ?Event
    {
        // sanitize the event name before searching
        if ($eventName <= 0) {
            throw(new \PDOException("event name is not positive"));
        }
        // create query template
        $query = "SELECT eventId, eventVenueId, eventContact, eventContent, eventDateTime, eventName FROM event WHERE eventContent LIKE :eventContent";
        $statement = $pdo->prepare($query);
        // bind the event name to the place holder in the template
        $parameters = ["eventName" => $eventName];
        $statement->execute($parameters);
        // grab the event from mySQL
        try {
            $event = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if ($row !== false) {
                $event = new Event($row["eventId"], $row["eventVenueId"],$row ["eventContact"], $row["eventContent"], $row["eventDateTime"], $row["eventName"]);
            }
        } catch (\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return ($event);
    }

    // GET ALL EVENTS!!!! :D

    /**
     * formats the state variables for JSON serialization
     *
     * @return array resulting state variables to serialize
     **/
    public function JsonSerialize()
    {
        $fields = get_object_vars($this);
        //format the sate so that the front end can consume it
        $fields["eventDateTime"] = round(floatval($this->eventDateTime->format("U.u")) * 1000);
        return ($fields);


    }
}