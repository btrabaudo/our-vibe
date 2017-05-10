<?php
namespace Edu\Cnm\OurVibe;
/**
 * Event for OurVibe
 * @author kkristl <kkristl@cnm.edu>
 **/
class Event implements \jsonSerialize{
	/**
	 * Id for this Event; this is the primary key
	 **/
	private $eventId;
	private $eventContact;
	private $eventContent;
	private $eventDateTime;
	private $eventName;
	/**
	 * constructor for this event

	 * @param int|null $newEventId
	 * @param string $newEventContact
	 * @param string $newEventContent
	 * @param \DateTime|string|null $newEventDateTime
	 * @param string $newEventName
	 *
	 * @throws \InvalidArgumentException
	 * @throws \RangeException
	 * @throws \RangeException
	 * @throws \Exception
	 * @throws \RangeException
	 **/
	public function __construct(?int $newEventId, string $newEventContact, string $newEventContent, $newEventDateTime = null, string $newEventName) {
		try {
			$this->setEventId($newEventId);
			$this->setEventContact($newEventContact);
			$this->setEventContent($newEventContent);
			$this->setEventDateTime($newEventDateTime);
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
	public function setEventId(int $newEventId): void {
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
		if (!ctype_alnum($newEventContact)) {
			throw(new \InvalidArgumentException("event contact can not be blank"));
		}
		//enforce less than 128 characters in event contact
		if (strlen($newEventContact) !== 128) {
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
		$newEventContent = filter_var($newEventContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		//enforce can not be blank in event content
		if (!ctype_alnum($newEventContent)) {
			throw(new \InvalidArgumentException("event content can not be blank"));
		}
		//enforce less than 768 characters in event content
		if (strlen($newEventContent) !== 768) {
			throw(new \RangeException("event content must be less than 768 characters"));
		}
		$this->eventContent = $newEventContent;
	}
	/**
	 * accessor method for event date
	 * @return \DateTime value of event date
	 **/
	public function getEventDateTime(): \DateTime {
		return $this->eventDateTime;
	}
	/**
	 * @param \DateTime $eventDateTime
	 **/
	public function setEventDateTime($newEventDateTime = null): void {
		if($newEventDateTime === null) {
			$this->eventDateTime = new \DateTime();
			return;
		}
		try {
			$newEventDateTime = self::validateDateTime($newEventDateTime);
		} catch (\InvalidArgumentException | \RangeException  $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->eventDateTime = $newEventDateTime;
	}