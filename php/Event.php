<?php
namespace Edu\Cnm\DataDesign;
/**
 * Profile for Data Design
 * @author kkristl <kkristl@cnm.edu>
 **/
class Event implements \jsonSerialize{
	/**
	 * Id for this Event; this is the primary key
	 */
	private $eventId;
	private $eventContact;
	private $eventContent;
	private $eventDateTime;
	private $eventName;
/**
 * constructor for this event
 *
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
 */
	public function __construct(?int $newEventId, string $newEventContact, string $newEventContent, $newEventDateTime = null, string $newEventName) {
		try {
			$this->setEventId($newEventId);
			$this->setEventContact($newEventContact);
			$this->setEventContent($newEventContent);
			$this->setEventDateTime($newEventDateTime);
			$this->setEventName($newEventName);
		} //determine the type of exception
		catch(\InvalidArgumentException | \RangeException | \RangeException | \Exception | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}