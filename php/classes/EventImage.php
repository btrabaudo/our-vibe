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
	public function __construct(int $newEventImageImageId, int $newEventImageEventId, = null) {
		try {
			$this->setEventImageImageId($newEventImageImageId);
			$this->setEventIm
		}
	}
}