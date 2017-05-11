<?php
namespace Edu\Cnm\OurVibe\Test;
use Edu\Cnm\OurVibe\OurVibeTest;
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
	public function testInsertValidEvent() : void {
		//count the rows and save it
		$numRows = $this->getConnection()->getRowCount("event");
		//create a new event and insert it into mySQL DB
		$event = new event(null, null, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME);
		//var_dump($event);
		$event->insert($this->getPDO());
		//grab data from mySQL and enforce that they match our expectations
		$pdoevent = event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertSame($pdoevent->geteventContact(), $this->VALID_CONTACT);
		$this->assertSame($pdoevent->geteventContent(), $this->VALID_CONTENT);
		$this->assertSame($pdoevent->geteventName(), $this->VALID_NAME);
	}
