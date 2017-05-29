<?php

namespace Edu\Cnm\OurVibe\Test;

use Edu\Cnm\OurVibe\Image;
use Edu\Cnm\OurVibe\Venue;
use Edu\Cnm\OurVibe\Event;

// grabs the class to be tested
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * PhpUnit test for event class
 * This is a complete test of the event class, all mySQL/PDO methods are tested for both invalid and valid inputs.
 *
 * @see event
 * @author kkristl
 **/
class EventTest extends OurVibeTest {

	/**
	 * valid venue id to use
	 * @var Venue $VALID_VENUE
	 **/
	protected $VALID_VENUE;

	/**
	 * valid image to use
	 * @var Image $VALID_IMAGE
	 **/
	protected $VALID_IMAGE;

	/**
	 * valid contact to use
	 * @var string $VALID_CONTACT
	 **/
	protected $VALID_CONTACT = "555-555-5555";

	/**
	 * valid content to use
	 * @var string $VALID_CONTENT
	 **/
	protected $VALID_CONTENT = "Blah blah blah blah blah";
	/**
	 * valid date to use
	 * @var string $VALID_DATE
	 */
	protected $VALID_EVENTDATE = null;
	/**
	 * valid date to use
	 * @var string $VALID_SUNRISEEVENTDATE
	 */
	protected $VALID_SUNRISEEVENTDATE = null;
	/**
	 * valid date to use
	 * @var string $VALID_SUNSETEVENTDATE
	 */
	protected $VALID_SUNSETEVENTDATE = null;

	/**
	 * @var $VALID_EVENTNAME
	 */
	protected $VALID_EVENTNAME = "Banana Bear";

	/**
	 * valid hash to use
	 * @var string $VALID_HASH
	 **/
	protected $VALID_HASH;

	/**
	 * valid salt to use
	 * @var string $VALID_SALT ;
	 **/
	protected $VALID_SALT;

	/**
	 * Placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 **/
	protected $VALID_ACTIVATION;

	/**
	 * set it up
	 */
	public final function setUp(): void {
		parent::setUp();

		$password = "abc123";
		$this->VALID_SALT = bin2hex(random_bytes(32));

		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		$this->VALID_IMAGE = new Image(null, null);
		$this->VALID_IMAGE->insert($this->getPDO());

		$this->VALID_VENUE = new Venue(
			null,
			$this->VALID_IMAGE->getImageId(),
			$this->VALID_ACTIVATION,
			"3237 Bartlett Avenue",
			"abq",
			"ourvibe",
			"+12125551212",
			"Kale chips",
			"theatre",
			"nm",
			"87114",
			$this->VALID_HASH,
			$this->VALID_SALT);

		$this->VALID_VENUE->insert($this->getPDO());

		$this->VALID_SUNRISEEVENTDATE = new \DateTime();
		$this->VALID_SUNSETEVENTDATE = new \DateTime();
		$this->VALID_SUNSETEVENTDATE->add(new \DateInterval("P10D"));
		$this->VALID_EVENTDATE = new \DateTime();
	}

	/**
	 * test inserting a valid event and verify the mySQL data
	 **/
	public function testInsertValidEvent(): void {
		//count the rows and save it
		$numRows = $this->getConnection()->getRowCount("event");
		//create a new event and insert it into mySQL DB
		$event = new Event(
			null,
			$this->VALID_VENUE->getVenueId(),
			$this->VALID_CONTACT,
			$this->VALID_CONTENT,
			$this->VALID_EVENTDATE,
			$this->VALID_EVENTNAME
		);
		$event->insert($this->getPDO());

		//grab data from mySQL and enforce that they match our expectations
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());

		//var_dump($pdoEvent);

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoEvent->getEventVenueId(), $this->VALID_VENUE->getVenueId());
		$this->assertEquals($pdoEvent->getEventContact(), $this->VALID_CONTACT);
		$this->assertEquals($pdoEvent->getEventContent(), $this->VALID_CONTENT);
		$this->assertEquals($pdoEvent->getEventDateTime(), $this->VALID_EVENTDATE);
		$this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
	}

	/**
	 * test inserting an event that already exists
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidEvent(): void {
		// create event with a non null eventId and see it fail
		$venue = new Event(EventTest::INVALID_KEY, $this->VALID_VENUE->getVenueId(), $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_EVENTNAME);
		$venue->insert($this->getPDO());
	}

	/**
	 * test inserting an event, editing it, and then updating it
	 **/
	public function testUpdateValidEvent() {
		$numRows = $this->getConnection()->getRowCount("event");
		//create a new event and insert it into mySQL DB
		$event = new Event(null, $this->VALID_VENUE->getVenueId(), $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_EVENTNAME);
		$event->insert($this->getPDO());
		//edit the event and then update
		$event->setEventContent("this is new event content");
		$event->update($this->getPDO());

		//grab data from mySQL and enforce that they match our expectations
		$pdoEvent = event::getEventByEventId($this->getPDO(), $event->getEventId());
//		var_dump($pdoEvent);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoEvent->getEventVenueId(), $this->VALID_VENUE->getVenueId());
		$this->assertEquals($pdoEvent->getEventContact(), $this->VALID_CONTACT);
		$this->assertEquals($pdoEvent->getEventContent(), "this is new event content");
		$this->assertEquals($pdoEvent->getEventDateTime(), $this->VALID_EVENTDATE);
		$this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
	}

	/**
	 * test updating a event
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidEvent() {
		//create a new event and insert it into mySQL DB
		$event = new event(null, $this->VALID_VENUE->getVenueId(), $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_EVENTNAME);
		$event->update($this->getPDO());
	}

	/**
	 * test creating a event and then deleting it
	 **/
	public function testDeleteValidEvent(): void {
		// count the number of rows
		$numRows = $this->getConnection()->getRowCount("event");
		//create a new event and insert it into mySQL DB
		$event = new Event(null, $this->VALID_VENUE->getVenueId(), $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_EVENTNAME);

		$event->insert($this->getPDO());

		//delete the event from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));

		$event->delete($this->getPDO());
		// grab the data from mySQL and enforce the event does not exist

		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertNull($pdoEvent);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("event"));
	}

	/**
	 * test deleting an event that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidEvent(): void {
		//create a new event but DO NOT INSERT and then delete
		$event = new event(null, $this->VALID_VENUE->getVenueId(), $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_EVENTNAME);
		$event->delete($this->getPDO());
	}

	/**
	 * test inserting event and re-grab it from mySQL
	 */
	public function testGetValidEventByEventId(): void {
		// count the number of rows
		$numRows = $this->getConnection()->getRowCount("event");
		//create a new event and insert it into mySQL DB


		$event = new event(null, $this->VALID_VENUE->getVenueId(), $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_EVENTNAME);
		$event->insert($this->getPDO());
		//grab data from mySQL and enforce that they match our expectations
		$pdoEvent = event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoEvent->getEventVenueId(), $this->VALID_VENUE->getVenueId());
		$this->assertEquals($pdoEvent->getEventContact(), $this->VALID_CONTACT);
		$this->assertEquals($pdoEvent->getEventContent(), $this->VALID_CONTENT);
		$this->assertEquals($pdoEvent->getEventDateTime(), $this->VALID_EVENTDATE);
		$this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
	}

	/**
	 * test grabbing an event that does not exist
	 *
	 *
	 **/
	public function testGetInvalidEventByEventId(): void {
		// grab an event id that exceeds the maximum allowable event id
		$event = Event::getEventByEventId($this->getPDO(), EventTest::INVALID_KEY);
		$this->assertNull($event);
	}
	/**
	 * test grabbing an Event by event content
	 **/
	public function testGetValidEventByEventContent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new event and insert to into mySQL
		$event = new Event(null, $this->VALID_VENUE->getVenueId(), $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_EVENTNAME);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = event::getEventByEventContent($this->getPDO(), $event->getEventContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\OurVibe\\Event", $results);

		// grab the result from the array and validate it
		$pdoevent = $results[0];
		$this->assertEquals($pdoevent->getEventVenueId(), $this->venue->getVenueId());
		$this->assertEquals($pdoevent->getEventContent(), $this->VALID_EVENTCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoevent->geteventDate()->getTimestamp(), $this->VALID_EVENTDATE->getTimestamp());
	}
	/**
	 * test grabbing a event by content that does not exist
	 **/
	public function testGetInvalidEventByEventContent() : void {
		// grab an event by content that does not exist
		$event = Event::getEventByEventContent($this->getPDO(), "nobody ever evented this");
		$this->assertCount(0, $event);
	}
	
	/**
	 * test grabbing a valid Event by Date
	 */
	public function testGetValidEventByDate() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");
//		var_dump($this->VALID_SUNRISEEVENTDATE);
//		var_dump($this->VALID_SUNSETEVENTDATE);
		var_dump($this->VALID_VENUE->getVenueId());
		//create a new Event and insert it into the database
		$event = new Event(null, $this->VALID_VENUE->getVenueId(), $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_EVENTNAME);
		$event->insert($this->getPDO());

//		var_dump($event);

		// grab the event from the database and see if it matches expectations
		$results = Event::getEventByEventDate($this->getPDO(), $this->VALID_SUNRISEEVENTDATE, $this->VALID_SUNSETEVENTDATE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1,$results);

		//enforce that no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\OurVibe\\Event", $results);

		//use the first result to make sure that the inserted event meets expectations
		$pdoEvent = $results[0];
		$this->assertEquals($pdoEvent->getEventId(), $event->getEventId());
		$this->assertEquals($pdoEvent->getEventVenueId(), $this->VALID_VENUE->getVenueId());
		$this->assertEquals($pdoEvent->getEventContact(), $this->VALID_CONTACT);
		$this->assertEquals($pdoEvent->getEventContent(), $this->VALID_CONTENT);
		$this->assertEquals($pdoEvent->getEventDateTime(), $this->VALID_EVENTDATE);
		$this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
	}

	/**
	 * test grabbing an event by its name
	 **/
	public function testGetValidEventByEventName(): void {
		// count the number of rows
		$numRows = $this->getConnection()->getRowCount("event");

		//create a new event and insert it into mySQL DB
		$event = new Event(null, $this->VALID_VENUE->getVenueId(), $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_EVENTNAME);
		$event->insert($this->getPDO());

//		var_dump($this->VALID_EVENTNAME);

		$results = Event::getEventByEventName($this->getPDO(), $this->VALID_EVENTNAME);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);

		$this->assertContainsOnlyInstancesOf
		("Edu\\Cnm\\OurVibe\\Event", $results);

		// grab data from mySQL and enforce the fields match expectations
		$pdoEvent = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoEvent->getEventVenueId(), $this->VALID_VENUE->getVenueId());
		$this->assertEquals($pdoEvent->getEventContact(), $this->VALID_CONTACT);
		$this->assertEquals($pdoEvent->getEventContent(), $this->VALID_CONTENT);
		$this->assertEquals($pdoEvent->getEventDateTime(), $this->VALID_EVENTDATE);
		$this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
	}

	/**
	 * test grabbing an event by a name that does not exist
	 *
	 **/
	public function testGetInvalidEventByEventName(): void {
		// grab an event that does not exist
		$event = Event::getEventByEventName($this->getPDO(), "aHappyPlace");
		$this->assertEmpty($event);
	}
	/**
	 * test grabbing all Events
	 **/
	public function testGetAllValidEvents() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert to into mySQL
		$event = new Event(null, $this->VALID_VENUE->getVenueId(), $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_EVENTDATE, $this->VALID_EVENTNAME);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getAllEvents($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\OurVibe\\Event", $results);

		// grab the result from the array and validate it
		$pdoEvent = $results[0];
		$this->assertEquals($pdoEvent->getEventVenueId(), $this->VALID_VENUE->getVenueId());
		$this->assertEquals($pdoEvent->getEventContent(), $this->VALID_CONTENT);
		$this->assertEquals($pdoEvent->getEventDateTime(), $this->VALID_EVENTDATE);
		$this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventDateTime()->getTimestamp(), $this->VALID_EVENTDATE->getTimestamp());
	}
}


