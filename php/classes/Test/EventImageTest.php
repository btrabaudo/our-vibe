<?php

namespace Edu\Cnm\OurVibe\Test;

use Edu\Cnm\OurVibe\{
	Tag, Venue, Event, Image, EventImage
};

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
	 * finish this doc block
	 * @var Event event
	 **/
	protected $event;
	/**
	 * @var Venue Venue
	 **/
	protected $venue;

	/**
	 * @var Image image
	 **/
	protected $image;

	/**
	 * @var Tag Tag
	 **/
	protected $tag;

	/**
	 * @var string $valid_Activation
	 **/
	protected $VALID_ACTIVATION;

	/**
	 * @var \DateTime valid event datetime
	 **/
	protected $VALID_EVENT_DATE;

	/**
	 * @var $VALID__PASS_HASH ;
	 **/
	protected $VALID_PASS_HASH;

	/**
	 * @var string $VALID_PASS_SALT
	 **/
	protected $VALID_PASS_SALT;

	/**
	 * @var VenueImageId VenueImageId
	 **/
	protected $VALID_IMAGE_CLOUD_ID;

	/**
	 * test inserting a valid event image and verify that the actual mySQL data matches
	 **/
	public final function setUp(): void {
		parent::setUp();

		$password = "abc123";
		$this->VALID_PASS_SALT = bin2hex(random_bytes(32));
		$this->VALID_PASS_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PASS_SALT, 262144);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		$this->tag = new Tag(null, "validTag");
		$this->tag->insert($this->getPDO());

		$this->VALID_IMAGE_CLOUD_ID = bin2hex(random_bytes(16));
		$this->image = new Image(null, $this->VALID_IMAGE_CLOUD_ID);
		$this->image->insert($this->getPDO());

		$this->venue = new Venue(
			null,
			$this->image->getImageId(),
			$this->VALID_ACTIVATION,
			"321 mountain St.",
			"abq",
			"paul baca",
			"+12125551212",
			"boI",
			"theatre",
			"nm",
			"87221",
			$this->VALID_PASS_HASH,
			$this->VALID_PASS_SALT);
		$this->venue->insert($this->getPDO());

		$this->VALID_EVENT_DATE = new \DateTime();

		$this->VALID_EVENT = new Event(
			null,
			$this->venue->getVenueId(),
			"paul baca",
			"Boi",
			$this->VALID_EVENT_DATE,
			"theatre");
	}

	public function testInsertValidEventImage(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventImage");

		// create a new eventImage and insert to into mySQL
		$eventImage = new EventImage($this->event->getEventId(), $this->image->getImageId());

		//var_dump($eventImage);
		$eventImage->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEventImage = eventImage::getEventImageByEventImageImageId($this->getPDO(), $eventImage->geteventImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventImage"));
		$this->assertEquals($pdoEventImage->geteventImageImageId(), $this->VALID_EVENT_IMAGE_IMAGE_ID);
		$this->assertEquals($pdoEventImage->getEventImageEventIdId(), $this->VALID_EVENT_IMAGE_EVENT_ID);
	}

	/**
	 * test inserting a event image that already exists
	 *
	 * @expectedException \PDOException
	 **/

	public function testInsertInvalidEventImage(): void {

		// create a event image with a non null event image Id and watch it fail
		$eventImage = new eventImage($this->VALID_EVENT_IMAGE_IMAGE_ID, OurVibeTest::INVALID_KEY, $this->VALID_EVENT_IMAGE_EVENT_ID);
		$eventImage->insert($this->getPDO());
	}

	/**
	 * test inserting a event image, editing it, and then updating it
	 **/

	public function testUpdateValidEventImage() {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventImage");

		// create a new event Image and insert to into mySQL
		$eventImage = new EventImage($this->VALID_EVENT_IMAGE_EVENT_ID, null);
		$eventImage->insert($this->getPDO());

		// edit the  and update it in mySQL
		$eventImage->setEventId($this->VALID_EVENT__IMAGE_ID);
		$eventImage->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEventImage = EventImage::getEventImageByEventImageImageId($this->getPDO(), $eventImage->getEventImageImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventImage"));
		$this->assertEquals($pdoEventImage->getEventImageImageId(), $this->VALID_EVENT_IMAGE_IMAGE_ID);
		$this->assertEquals($pdoEventImage->getEventImageEventId(), $this->VALID_EVENT_IMAGE_EVENT_ID);
	}

	/**
	 *test updating an EventImage that does not exist
	 *
	 * @expectedException \PDOException
	 **/

	public function testUpdateInvalidEventImage() {

		// create a event image and try to update it without actually inserting it
		$eventImage = new eventImage($this->VALILD_EVENT_IMAGE_IMAGE_ID, null, $this->VALILD_EVENT_IMAGE_EVENT_ID);
		$eventImage->update($this->getPDO());
	}

	/**
	 * test creating a EventImage and then deleting it
	 **/

	public function testDeleteValidEventImage(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventImage");

		// create a new EventImage and insert to into mySQL
		$eventImage = new EventImage($this->VALID_EVENT_IMAGE_IMAGE_ID, null, $this->VALILD_EVENT_IMAGE_EVENT_ID);
		$eventImage->insert($this->getPDO());

		// delete the EventImage from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventImage"));
		$eventImage->delete($this->getPDO());

		// grab the data from mySQL and enforce the EventImage does not exist
		$pdoImage = EventImage::getImagleByImageId($this->getPDO(), $eventImage->getImageId());
		$this->assertNull($pdoImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("eventImage"));
	}

	/**
	 * test deleting a EventImage that does not exist
	 *
	 * @expectedException \PDOException
	 **/

	public function testDeleteInvalidEventImage(): void {

		// create a EventImage and try to delete it without actually inserting it
		$eventImage = new EventImage($this->VALID_EVENT_IMAGE_IMAGE_ID, null, $this->VALID_EVENT_IMAGE_EVENT_ID);
		$eventImage->delete($this->getPDO());
	}

	/**
	 * test inserting a EventImage and regrabbing it from mySQL
	 **/

	public function testGetValidEventImageByEventImageImageId(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventImage");

		// create a new EventImage and insert to into mySQL
		$eventImage = new EventImage($this->VALID_EVENT_IMAGE_IMAGE_ID, null, $this->VALID_EVENT_IMAGE_EVENT_ID);
		$eventImage->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoImage = EventImage::getEventImageByEventImageImageId($this->getPDO(), $eventImage->getEventImageImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventImage"));
		$this->assertEquals($pdoImage->getEventImageImageId(), $this->VALID_EVENT_IMAGE_IMAGE_ID);
		$this->assertEquals($pdoImage->getEventImageEventId(), $this->VALID_EVENT_IMAGE_EVENT_ID);
	}

	/**
	 * test grabbing a EventImage that does not exist
	 **/

	public function testGetInvalidEventImageByEventImageImageId(): void {

		// grab a event image id that exceeds the maximum allowable event image id
		$eventImage = EventImage::getEventByEventImageImageId($this->getPDO(), OurVibeTest::INVALID_KEY);
		$this->assertNull($eventImage);
	}
}























