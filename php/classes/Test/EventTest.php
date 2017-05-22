<?php

namespace Edu\Cnm\OurVibe\Test;


use Edu\Cnm\OurVibe\Event;
use Edu\Cnm\OurVibe\Image;
use Edu\Cnm\OurVibe\Venue;

// grabs the class to be tested
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * PhpUnit test for event class
 * This is a complete test of the event class, all mySQL/PDO methods are tested for both invalid and valid inputs.
 *
 * @see event
 * @author kkristl
 **/
class eventTest extends OurVibeTest {
	/**
	 * valid venue id to use
	 * @var string $VALID_VENUE
	 **/
	protected $VALID_VENUE;
	/**
	 * valid contact to use
	 * @var string $VALID_CONTACT
	 **/
	/**
	 * @var string $VALID_ACTIVATIONTOKEN
	 */
	protected $VALID_ACTIVATIONTOKEN;

	protected $VALID_CONTACT = "555-555-5555, BLah blah blah blah blah@blah.com";
	/**
	 * valid content to use
	 * @var string $VALID_CONTENT
	 **/
	protected $VALID_CONTENT = "Blah blah blah blah blah ";
	/**
	 * valid date to use
	 * @var string $VALID_DATE
	 */
	protected $VALID_EVENTDATE = "asd;lfkjads";
	/**
	 * valid hash to use
	 * @var string $VALID_HASH
	 */
	protected $VALID_HASH;
	/**
	 * valid image to use
	 * @var string $VALID_image
	 */
	protected $VALID_image;
	/**
	 * valid name to use
	 * @var string $VALID_NAME
	 */
	protected $VALID_NAME = "austin thundercats";
	/**
	 * valid salt to use
	 * @var string $VALID_SALT
	 */
	protected $VALID_SALT;

	// set up method
	public final function setUp() {
		parent::setUp();
		$this->VALID_ACTIVATIONTOKEN = bin2hex(random_bytes(16));
		$password = "abc123";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);

		$image = new Image(null, "asdfasdfasdfasdfasdf");
		$image->insert($this->getPDO());


		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_EVENTDATE = new \DateTime();

		$this->VALID_VENUE = new Venue(null, $image->getImageId(), $this->VALID_ACTIVATIONTOKEN , "address", "address2", "burque","505-709-0999", "this is a venue", "the unit test ampitheatre", "NM", "87106", $this->VALID_HASH, $this->VALID_SALT);
	$this->VALID_VENUE->insert($this->getPDO());
	}


	/**
	 * test inserting a valid event and verify the mySQL data
	 **/
	public function testInsertValidEvent(): void {
		//count the rows and save it
		$numRows = $this->getConnection()->getRowCount("event");
		//create a new event and insert it into mySQL DB
		var_dump($this->VALID_CONTACT);
		$event = new Event(null, $this->VALID_VENUE->getVenueId(), $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_NAME);
		//var_dump($event);
		$event->insert($this->getPDO());
		//grab data from mySQL and enforce that they match our expectations
		$pdoevent = event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoevent->getEventVenueId(), $this->VALID_VENUE);
		$this->assertEquals($pdoevent->getEventContact(), $this->VALID_CONTACT);
		$this->assertEquals($pdoevent->getEventContent(), $this->VALID_CONTENT);
		$this->assertEquals($pdoevent->getEventDate(), $this->VALID_EVENTDATE);
		$this->assertEquals($pdoevent->getEventName(), $this->VALID_NAME);
	}

	/**
	 * test inserting an event that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidEvent(): void {
		// create event with a non null eventId and see it fail
		$venue = new Event(EventTest::INVALID_KEY, $this->VALID_VENUE, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_NAME);
		$venue->insert($this->getPDO());
	}

	/**
	 * test inserting an event, editing it, and then updating it
	 **/
	public function testUpdateValidEvent() {
		$numRows = $this->getConnection()->getRowCount("venue");
		//create a new event and insert it into mySQL DB
		$event = new event(null, $this->VALID_VENUE, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_NAME);
		$event->insert($this->getPDO());
		//edit the event and then update
		$event->update($this->getPDO());
		//grab data from mySQL and enforce that they match our expectations
		$pdoevent = event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoevent->getEventVenueId(), $this->VALID_VENUE);
		$this->assertEquals($pdoevent->getEventContact(), $this->VALID_CONTACT);
		$this->assertEquals($pdoevent->getEventContent(), $this->VALID_CONTENT);
		$this->assertEquals($pdoevent->getEventDate(), $this->VALID_EVENTDATE);
		$this->assertEquals($pdoevent->getEventName(), $this->VALID_NAME);
	}

	/**
	 * test updating a event
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidEvent() {
		//create a new event and insert it into mySQL DB
		$event = new event(null, $this->VALID_VENUE, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_NAME);
		$event->update($this->getPDO());
	}

	/**
	 * test creating a event and then deleting it
	 **/
	public function testDeleteValidEvent(): void {
		// count the number of rows
		$numRows = $this->getConnection()->getRowCount("event");
		//create a new event and insert it into mySQL DB
		$event = new event(null, $this->VALID_VENUE, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_NAME);
		$event->insert($this->getPDO());
		//delete the event from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->delete($this->getPDO());
		// grab the data from mySQL and enforce the event does not exist
		$pdoevent = event::getEventByeventId($this->getPDO(), $event->getEventId());
		$this->assertNull($pdoevent);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
	}

	/**
	 * test deleting an event that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidEvent(): void {
		//create a new event but DO NOT INSERT and then delete
		$event = new event(null, $this->VALID_VENUE, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_NAME);
		$event->delete($this->getPDO());
	}

	/**
	 * test inserting event and re-grab it from mySQL
	 */
	public function testGetValidEventByEventId(): void {
		// count the number of rows
		$numRows = $this->getConnection()->getRowCount("event");
		//create a new event and insert it into mySQL DB
		$event = new event(null, $this->VALID_VENUE, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_NAME);
		$event->insert($this->getPDO());
		//grab data from mySQL and enforce that they match our expectations
		$pdoevent = event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoevent->getEventVenueId(), $this->VALID_VENUE);
		$this->assertEquals($pdoevent->getEventContact(), $this->VALID_CONTACT);
		$this->assertEquals($pdoevent->getEventContent(), $this->VALID_CONTENT);
		$this->assertEquals($pdoevent->getEventDate(), $this->VALID_EVENTDATE);
		$this->assertEquals($pdoevent->getEventName(), $this->VALID_NAME);
	}

	/**
	 * test grabbing an event that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testGetInvalidEventByEventId(): void {
		// grab an event id that exceeds the maximum allowable event id
		$event = Event::getEventByEventId($this->getPDO(), EventTest::INVALID_KEY);
		$this->assertNull($event);
	}

	/**
	 * test grabbing an event by its name
	 **/
	public function testGetValidEventByName(): void {
		// count the number of rows
		$numRows = $this->getConnection()->getRowCount("event");

		//create a new event and insert it into mySQL DB
		$event = new event(null, $this->VALID_VENUE, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_NAME);
		$event->insert($this->getPDO());

		// grab data from mySQL and enforce the fields match expectations
		$pdoevent = event::getEventByEventName($this->getPDO(), $event->getEventName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoevent->getEventVenueId(), $this->VALID_VENUE);
		$this->assertEquals($pdoevent->getEventContact(), $this->VALID_CONTACT);
		$this->assertEquals($pdoevent->getEventContent(), $this->VALID_CONTENT);
		$this->assertEquals($pdoevent->getEventDate(), $this->VALID_EVENTDATE);
		$this->assertEquals($pdoevent->getEventName(), $this->VALID_NAME);
	}

	/**
	 * test grabbing an event by a name that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testGetInvalidEventByName(): void {
		// grab an event that does not exist
		$event = Event::getEventByEventName($this->getPDO(), "aHappyPlace");
		$this->assertNull($event);
	}
}


