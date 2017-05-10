<?php

namespace Edu\Cnm\OurVibe\Test;

use Edu\Cnm\OurVibe\EventTag;


require_once(dirname(__DIR__) . "/autoload.php");

/**
 * full PHP unit test for the EventTag class
 * tested for invalid and valid inputs
 * @see Tag
 **/
class EventTagTest extends OurVibeTest {
	/**
	 * @var string $valid_Activation
	 **/
	protected $VALID_ACTIVATION;

	/**
	 * @var int $VALID_EVENTTAGEVENTID
	 **/
	protected $VALID_EVENTTAGEVENTID = @"passingtests";

	/**
	 * test inserting a valid Tag and verify that the actual mySQL data matches
	 **/
	public function testInsertValidTag(): void {
		$numRows = $this->getConnection()->getRowCount("tag");
		$eventTag = new Tag(null, $this->VALID_ACTIVATION, $this->VALID_EVENTTAGEVENTID);
		$eventTag->insert($this->getPDO());
		$pdoTag = EventTag::getEventTagByEventTagEventId($this->getPDO(), $eventTag->getEventTagEventId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("eventTag"));
		$this->assertSame($pdoEventTag->getEventTagTagId(), $this->VALID_EVENTTAGEVENTID);
	}

	/**
	 * test inserting a eventTag that already exists
	 * @expectedExxception \PDOException
	 **/
	public function testInsertInvalidTag(): void {
		$eventTag = new Tag(OurVibeTest::INVALID_KEY, $this->VALID_EVENTTAGEVENTID);
		$eventTag->insert($this->getPDO());
	}

	/**
	 * test inserting a event, editing it, and then updating it
	 **/
	public function testUpdateValidEventTag() {
		$numRows = $this->getConnection()->getRowCount("eventTag");
		$eventTag = new EventTag(null, $this->VALID_EVENTTAGEVENTID);
		$eventTag->insert($this->getPDO());
		$eventTag->setEventTagEventId($this->VALID_EVENTTAGEVENTID);
		$eventTag->update($this->getPDO());

		$pdoTag = EventTag::getEventTagByEventTagEventId($this->getPDO(), $eventTag->getEventTagEventId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("eventTag"));
		$this->assertSame($pdoEventTag->setEventTagEventId(), $this->VALID_EVENTTAGEVENTID);
	}

	/**
	 * test updating  event tag that does not exist
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidTag() {
		$eventTag = new EventTag(null, $this->VALID_EVENTTAGEVENTID);
		$eventTag->update($this->getPDO());
	}

	/**
	 * test creating a event tag and then deleting it
	 **/
	public function testDeleteValidEventTagId(): void {
		$numRows = $this->getConnection()->getRowCount("event tag");
		$eventTag = new EventTag(null, $this->VALID_EVENTTAGEVENTID);
		$eventTag->insert($this->getPDO());

		$pdoTag = EventTag::getEventTagByEventTagEventId($this->getPDO(), $eventTag->getEventTagEventId());
		$this->assertNUll($pdoEventTag);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * test deleting a event Tag that does not exist
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidEventTag(): void {
		$eventTag = new EventTag(null, $this->VALID_EVENTTAGEVENTID);
		$eventTag->delete($this->getPDO());
	}

	/**
	 * test inserting a eventTagId and regrabbing it from mySQL
	 **/
	public function testGetValidTagByEventTagEventId(): void {
		$numRows = $this->getConnection()->getRowCount("event tag");

		//create a new profile and insert to into mySQL
		$eventTag = new EventTag(null, $this->VALID_TAGTAGID);
		$eventTag->insert($this->getPDO());

		$pdoTag = EventTag::getEventTagByEventTagEventId($this->getPDO(), $tag->getEventTagEventId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("event tag"));
		$this->assertSame($pdoTag->getEventTagTagId(), $this->VALID_TAGTAGID);
	}


	public function testValidEventTagByEventTagTag() {
		$numRows = $this->getConnection()->getRowCount("event tag");
		//create a new event tag and insert to into mySQL
		$eventTag = new EventTag(null, $this->VALID_TAGTAGID);
		$eventTag->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event tag"));

		$this-> assertContainsOnlyInstancesOf("Edu\\CNM\\OurVibe\\EventTag", $results);
		$pdoTag = $results[0];
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("event Tag"));
		$this->assertSame($pdoTag->getTagTag(), $this->VALID_TAGTAGID);
	}

	/**
	 * test grabbing a event tag by event tag tag that does not exist
	 **/
	public function testGetInvalidEventTagByEventTagTag(): void {
		$eventTag = EventTag::getEventTagbyEventTagTagId($this->getPDO(), "@doesnotexist");
	}

}