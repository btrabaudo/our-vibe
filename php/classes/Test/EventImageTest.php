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
	 * @var EventImage $eventImage
	 */

	protected $eventImage;

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
	 * @var venueImageId VenueImageId
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

		$this->event = new Event(
			null,
			$this->venue->getVenueId(),
			"paul baca",
			"Boi",
			$this->VALID_EVENT_DATE,
			"theatre");
		$this->event->insert($this->getPDO());
	}

	public function testInsertValidEventImage(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventImage");

		// create a new eventImage and insert to into mySQL
		$eventImage = new EventImage($this->event->getEventId(), $this->image->getImageId());

		//var_dump($eventImage);
		$eventImage->insert($this->getPDO());
 var_dump($this->event);
 // grab the data from mySQL and enforce the fields match our expectations
		$pdoEventImage = EventImage::getEventImageByEventImageEventIdAndEventImageImageId($this->getPDO(), $this->event->getEventId(), $this->image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventImage"));
		$this->assertEquals($pdoEventImage->getEventImageEventId(), $this->event->getEventId());
		$this->assertEquals($pdoEventImage->geteventImageImageId(), $this->image->getImageId());
	}

	/**
	 * test inserting a event image that already exists
	 *
	 * @expectedException \PDOException
	 **/

	public function testInsertInvalidEventImage(): void {

		// create a event image with a non null event image Id and watch it fail
		$eventImage = new eventImage( OurVibeTest::INVALID_KEY, OurVibeTest::INVALID_KEY);
		$eventImage->insert($this->getPDO());
	}

	/**
	 * test creating a EventImage and then deleting it
	 **/

	public function testDeleteValidEventImage(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("eventImage");

		// create a new EventImage and insert to into mySQL
		$eventImage = new EventImage($this->event->getEventId(), $this->image->getImageId());
		$eventImage->insert($this->getPDO());

		// delete the EventImage from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventImage"));
		$eventImage->delete($this->getPDO());

		// grab the data from mySQL and enforce the EventImage does not exist
		$pdoEventImage = EventImage::getEventImageByEventImageEventIdAndEventImageImageId($this->getPDO(), $this->event->getEventId(), $this->image->getImageId());
		$this->assertNull($pdoEventImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("eventImage"));
	}

	/**
	 * test grabbing a EventImage that does not exist
	 **/

	public function testGetInvalidEventImageByEventImageImageId(): void {

		// grab a event image id that exceeds the maximum allowable event image id
		$eventImage = EventImage::getEventByEventImageId($this->getPDO(), ourVibeTest::INVALID_KEY);
		$this->assertNull($eventImage);
	}
	// TODO add invalid valid getEventImageByEventImageEventId (expecting array), add and valid getEventImageByImageImageId (expecting array)

}
























