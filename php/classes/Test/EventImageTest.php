<?php
namespace Edu\Cnm\OurVibe\Test;

use Edu\Cnm\OurVibe\EventImage;

//  grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

	/**
	 * Full php unit test for event image class
	 *
	 * this is a complete php unit test of the event image class. it's complete because all mySQL/PDO enabled methods are tested for both invalid and valid inputs.
	 *
	 * @see eventImage
	 * @author marcoder <mlester3@cnm.edu>
 **/

class EventImageTest extends OurVibeTest {

	/**
	 *
	 *
	 * @var EventImage eventImage
	 **/

	protected $eventImage = null;

	/**
	 * valid eventImageImageId to create the event image object to own the test
	 *
	 * @var $VALID_EVENT_IMAGE_IMAGE_ID
	 **/

	protected $VALID_EVENT_IMAGE_IMAGE_ID;

	/**
	 * test inserting a valid EventImage and verify that the actual mySQL data matches
	 **/

	public function testInsertValidEventImage(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventImage");

		// create a new eventImage and insert to into mySQL
		$eventImage = new eventImage(null, $this->VALID_EVENT_IMAGE_IMAGE_ID, $this->VALID_EVENT_IMAGE_EVENT_ID);
		//var_dump($eventImage);
		$eventImage->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEventImage = eventImage::getEventImageByEventImageImageId($this->getPDO(), $eventImage->geteventImageImageId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("eventImage"));
		$this->assertSame($pdoEventImage->geteventImageImageId(), $this->VALID_EVENT_IMAGE_IMAGE_ID);
		$this->assertSame($pdoEventImage->getEventImageEventIdId(), $this->VALID_EVENT_IMAGE_EVENT_ID);
	}

	/**
	 * test inserting a event image that already exists
	 *
	 * @expectedException \PDOException
	 **/

	public function testInsertInvalidEventImage(): void {

		// create a event image with a non null event image Id and watch it fail
		$eventImage = new eventImage(OurVibeTest::INVALID_KEY, $this->VALID_EVENT_IMAGE_IMAGE_ID, $this->VALID_EVENT_IMAGE_EVENT_ID);
		$eventImage->insert($this->getPDO());
	}

	/**
	 * test inserting a event image, editing it, and then updating it
	 **/

	public function testUpdateValidEventImage() {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventImage");

		// create a new event Image and insert to into mySQL
		$eventImage = new EventImage(null, $this->VALID_EVENT_IMAGE_IMAGE_ID, $this->VALID_EVENT_IMAGE_EVENT_I;
		$eventImage->insert($this->getPDO());
	}
	}