<?php
namespace Edu\Cnm\OurVibe;

require_once("autoload.php");

class eventTag implements \jsonSerializable {
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
	public function __construct(?int $newEventTagEventId, ?int $newEventTagTagId = null){try{
		$this->setEventTagEventId($newEventTagEventId);
		$this->setEventTagTagId($newEventTagTagId);

	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
	$exceptionType = get_class($exception);
	throw(new $exceptionType($exception->getMessage(),0,$exception));}
	}

	/**
	 * accessor method for eventTagEventId
	 * @return int|null value of eventTagEventId
	 **/

	public function getEventTagEventId() : int {
		return($this->eventTagEventId);
	}
	/**
	 * mutator method for eventTagEventId
	 * @param int|null $newEventTagEventId
	 * @throws \RangeException if $newEventTagEventId is not positive
	 * @throws \TypeError if $newEventTagEventId is not an integer
	 **/
	public function setEventTagEventId(?int $newEventTagEventId) : void{
		if($newEventTagEventId ===null){
			return;
		}
	   if($newEventTagEventId <= 0){
			throw(new \RangeException("EventTagEventId is not positive"));
		}
	$this->eventTagEventId = $newEventTagEventId;
	}

	/**
	 * accessor method for EventTagTagId
	 * @return int value of EventTagTagId
	 **/
	public function getEventTagTagId() : int{
		return($this->eventTagTagId);
	}

	/**
	 * mutator method for eventTagTagId
	 * @param int $newEventTagTagId new value of eventTag
	 * @throws \RangeException if $newEventTagTagId is not positive
	 * @throws \TypeError if $newEventTagTagId is not an integer
	 **/

	public function setEventTagTagId(int $newEventTagTagId) : void {
		if($newEventTagTagId <= 0) {
			throw(new \RangeException("EventTagTagId is not positive"));
		}
	$this->eventTagTagId = $newEventTagTagId;
	}




}