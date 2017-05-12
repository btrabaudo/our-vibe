<?php

namespace Edu\Cnm\OurVibe\Test;


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
class eventTest extends OurVibeTest {
	/**
	 * valid venue id to use
	 * @var string $VALID_VENUE
	 **/
	protected $VALID_VENUE = "12345";
	/**
	 * valid contact to use
	 * @var string $VALID_CONTACT
	 **/
	protected $VALID_CONTACT = "555-555-5555, BLah blah blah blah blah@blah.com";
	/**
	 * valid content to use
	 * @var string $VALID_CONTENT
	 **/
	protected $VALID_CONTENT = "Blah blah blah blah blah ";
	/**
	 * valid name to use
	 * @var string $VALID_NAME
	 */
	protected $VALID_NAME = "austin thundercats";

	/**
	 * test inserting a valid event and verify the mySQL data
	 **/
	public function testInsertValidEvent(): void {
		//count the rows and save it
		$numRows = $this->getConnection()->getRowCount("event");
		//create a new event and insert it into mySQL DB
		$event = new event(null,null, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME);
		//var_dump($event);
		$event->insert($this->getPDO());
		//grab data from mySQL and enforce that they match our expectations
		$pdoevent = event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoevent->getEventVenueId(), $this->VALID_VENUE);
		$this->assertEquals($pdoevent->getEventContact(), $this->VALID_CONTACT);
		$this->assertEquals($pdoevent->getEventContent(), $this->VALID_CONTENT);
		$this->assertEquals($pdoevent->getEventName(), $this->VALID_NAME);
	}

	/**
	 * test inserting an event that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidEvent(): void {
		// create event with a non null eventId and see it fail
		$venue = new Event(EventTest::INVALID_KEY, null, $this->VALID_VENUE, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME);
		$venue->insert($this->getPDO());
	}

	/**
	 * test inserting an event, editing it, and then updating it
	 **/
	public function testUpdateValidEvent() {
		$numRows = $this->getConnection()->getRowCount("venue");
		//create a new event and insert it into mySQL DB
		$event = new event(null, null, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME);
		$event->insert($this->getPDO());
		//edit the event and then update
		$event->update($this->getPDO());
		//grab data from mySQL and enforce that they match our expectations
		$pdoevent = event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoevent->getEventVenueId(), $this->VALID_VENUE);
		$this->assertEquals($pdoevent->getEventContact(), $this->VALID_CONTACT);
		$this->assertEquals($pdoevent->getEventContent(), $this->VALID_CONTENT);
		$this->assertEquals($pdoevent->getEventName(), $this->VALID_NAME);
	}

	/**
	 * test updating a event
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidEvent() {
		//create a new event and insert it into mySQL DB
		$event = new event(null, null, $this->VALID_VENUE, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME);
		$event->update($this->getPDO());
	}

	/**
	 * test creating a event and then deleting it
	 **/
	public function testDeleteValidEvent(): void {
		// count the number of rows
		$numRows = $this->getConnection()->getRowCount("event");
		//create a new event and insert it into mySQL DB
		$event = new event(null, null, $this->VALID_VENUE, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME);
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
		$event = new event(null, null, $this->VALID_VENUE, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME);
		$event->delete($this->getPDO());
	}

	/**
	 * test inserting event and re-grab it from mySQL
	 */
	public function testGetValidEventByEventId(): void {
		// count the number of rows
		$numRows = $this->getConnection()->getRowCount("event");
		//create a new event and insert it into mySQL DB
		$event = new event(null, null, $this->VALID_VENUE, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME);
		$event->insert($this->getPDO());
		//grab data from mySQL and enforce that they match our expectations
		$pdoevent = event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoevent->getEventVenueId(), $this->VALID_VENUE);
		$this->assertEquals($pdoevent->getEventContact(), $this->VALID_CONTACT);
		$this->assertEquals($pdoevent->getEventContent(), $this->VALID_CONTENT);
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
		$event = new event(null, null, $this->VALID_VENUE, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME);
		$event->insert($this->getPDO());
		// grab data from mySQL and enforce the fields match expectations
		$pdoevent = event::getEventByEventName($this->getPDO(), $event->getEventName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoevent->getEventVenueId(), $this->VALID_VENUE);
		$this->assertEquals($pdoevent->getEventContact(), $this->VALID_CONTACT);
		$this->assertEquals($pdoevent->getEventContent(), $this->VALID_CONTENT);
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


