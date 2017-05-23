<?php

namespace Edu\Cnm\OurVibe\Test;

use Edu\Cnm\OurVibe\Tag;
use Edu\Cnm\OurVibe\Image;
use Edu\Cnm\OurVibe\Venue;
use Edu\Cnm\OurVibe\Event;
use Edu\Cnm\OurVibe\EventTag;

require_once(dirname(__DIR__) . "/autoload.php");

/**
 * full PHP unit test for the EventTag class
 * tested for invalid and valid inputs
 * @see Tag
 **/
class EventTagTest extends OurVibeTest {

	/**
	 * @var Venue Venue
	 **/
	protected $VALID_VENUE;

	/**
	 * @var Event Event
	 **/
	protected $VALID_EVENT;

	/**
	 * @var Image image
	 **/
	protected $VALID_IMAGE;

	/**
	 * @var Tag Tag
	 **/
	protected $VALID_TAG;

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
	 * @var $VALID_EVENTTAGEVENTID
	 **/
	protected $VALID_EVENTTAGEVENTID;

	public final function setUp(): void {
		parent::setUp();

		$password = "abc123";
		$this->VALID_PASS_SALT = bin2hex(random_bytes(32));
		$this->VALID_PASS_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PASS_SALT, 262144);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		$this->VALID_TAG = new Tag(null,"validTag");
		$this->VALID_TAG->insert($this->getPDO());

		$this->VALID_IMAGE_CLOUD_ID = bin2hex(random_bytes(14));
		$this->VALID_IMAGE = new Image(null, $this->VALID_IMAGE_CLOUD_ID);
		$this->VALID_IMAGE->insert($this->getPDO());

		$this->VALID_VENUE = new Venue(
			null,
			$this->VALID_IMAGE->getImageId(),
			$this->VALID_ACTIVATION,
			"123 High St.",
			"abq",
			"paul baca",
			"+12125551212",
			"boI",
			"theatre",
			"nm",
			"87114",
			$this->VALID_PASS_HASH,
			$this->VALID_PASS_SALT);
		$this->VALID_VENUE->insert($this->getPDO());

		$this->VALID_EVENT_DATE = new \DateTime();

		$this->VALID_EVENT = new Event(
			null,
			$this->VALID_VENUE->getVenueId(),
			"paul baca",
			"Boi",
			$this->VALID_EVENT_DATE,
			"theatre"
		);

		$this->VALID_EVENT->insert($this->getPDO());
	}

	/**`
	 * test inserting a valid Tag and verify that the actual mySQL data matches
	 **/
	public function testInsertValidEventTag(): void {
		$numRows = $this->getConnection()->getRowCount("eventTag");

//		var_dump($this->VALID_EVENT);

		$eventTag = new EventTag($this->VALID_EVENT->getEventId(),$this->VALID_TAG->getTagId());
		$eventTag->insert($this->getPDO());
		$pdoEventTag = EventTag::getEventTagByEventTagEventIdAndEventTagTagId($this->getPDO(), $eventTag->getEventTagEventId(),$eventTag->getEventTagTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("eventTag"));
		$this->assertEquals($pdoEventTag->getEventTagEventId(), $this->VALID_EVENT->getEventId());
	}

	/**
	 * test inserting a eventTag that already exists
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidEventTag(): void {
		$eventTag = new EventTag(OurVibeTest::INVALID_KEY, OurVibeTest::INVALID_KEY);
		$eventTag->insert($this->getPDO());
	}

	/**
	 * test creating a event tag and then deleting it
	 **/
	public function testDeleteValidEventTag(): void {
		$numRows = $this->getConnection()->getRowCount("event tag");
		$eventTag = new EventTag($this->VALID_EVENT->getEventId(), $this->VALID_TAG->getTagId());
		$eventTag->insert($this->getPDO());

		$pdoEventTag = EventTag::getEventTagByEventTagEventId($this->getPDO(), $eventTag->getEventTagEventId());
		$this->assertNull($pdoEventTag);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("eventTag"));
	}

	/**
	 * test deleting a event Tag that does not exist
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidEventTag(): void {
		$eventTag = new EventTag($this->VALID_EVENT->getEventId(), $this->VALID_TAG->getTagId());
		$eventTag->delete($this->getPDO());
	}

	/**
	 * test inserting a eventTagId and regrabbing it from mySQL
	 **/
	public function testGetValidEventTagsByEventTagEventId(): void {
		$numRows = $this->getConnection()->getRowCount("event tag");

		//create a new profile and insert to into mySQL
		$eventTag = new EventTag($this->VALID_EVENT->getEventId(), $this->VALID_TAG->getTagId());
		$eventTag->insert($this->getPDO());

		$pdoEventTag = EventTag::getEventTagsByEventTagEventId($this->getPDO(), $eventTag->getEventTagEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event tag"));
		$this->assertEquals($pdoEventTag->getEventTagTagId(), $this->VALID_TAG->getTagId());
	}


	public function testValidEventTagsByEventTagTagId() {
		$numRows = $this->getConnection()->getRowCount("eventTag");

		//create a new event event tag and insert to into mySQL
		$eventTag = new EventTag($this->VALID_EVENT->getEventId(),$this->VALID_TAG->getTagId());

		$eventTag = new EventTag(null, $this->VALID_EVENT->getEventId(), $this->VALID_TAG->getTagId());
		$eventTag->insert($this->getPDO());

		$results = EventTag::getEventTagsByEventTagTagId($this->getPDO(), $this->VALID_TAG->getTagId());

		$this->assertContainsOnlyInstancesOf("Edu\\CNM\\OurVibe\\EventTag", $results);

		$pdoEventTag = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event Tag"));
		$this->assertEquals($pdoEventTag->getTagTag(), $this->VALID_TAG->getTagId());
	}

	/**
	 * test grabbing a event tag by event tag tag that does not exist
	 **/
	public function testGetInvalidEventTagByEventTagTag(): void {
		$eventTag = EventTag::getEventTagbyEventTagTagId($this->getPDO(), "@doesnotexist");
	}

}