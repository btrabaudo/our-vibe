<?php

namespace Edu\Cnm\OurVibe\Test;

use Edu\Cnm\OurVibe\Tag;

require_once(dirname(__DIR__) . "/autoload.php");

/**
 * full PHP unit test for the tag class
 * tested for invalid and valid inputs
 * @see Tag
 **/
class TagTest extends OurVibeTest {
	/**
	 * @var string $valid_Activation
	 **/
	protected $VALID_ACTIVATION;

	/**
	 * @var string $VALID_TAGNAME
	 **/
	protected $VALID_TAGNAME = @"passingtests";

	/**
	 * test inserting a valid Tag and verify that the actual mySQL data matches
	 **/
	public function testInsertValidTag(): void {
		$numRows = $this->getConnection()->getRowCount("tag");
		$tag = new Tag(null, $this->VALID_ACTIVATION, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertSame($pdoTag->getTagName(), $this->VALID_TAGNAME);
	}

	/**
	 * test inserting a tag that already exists
	 * @expectedExxception \PDOException
	 **/
	public function testInsertInvalidTag(): void {
		$tag = new Tag(OurVibeTest::INVALID_KEY, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());
	}

	/**
	 * test inserting a tag, editing it, and then updating it
	 **/
	public function testUpdateValidTag() {
		$numRows = $this->getConnection()->getRowCount("tag");
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());
		$tag->setTagName($this->VALID_TAGNAME);
		$tag->update($this->getPDO());

		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertSame($pdoTag->setTagName(), $this->VALID_TAGNAME);
	}

	/**
	 * test updating tag that does not exist
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidTag() {
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->update($this->getPDO());
	}

	/**
	 * test creating a tag and then deleting it
	 **/
	public function testDeleteValidTag(): void {
		$numRows = $this->getConnection()->getRowCount("tag");
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());

		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertNUll($pdoTag);
		$this->assertSame($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * test deleting a Tag that does not exist
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidTag(): void {
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->delete($this->getPDO());
	}

	/**
	 * test inserting a tag and regrabbing it from mySQL
	 **/
	public function testGetValidTagByTagId(): void {
		$numRows = $this->getConnection()->getRowCount("tag");

		//create a new profile and insert to into mySQL
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());

		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertSame($pdoTag->getTagName(), $this->VALID_TAGNAME);
	}


	public function testValidTagByTagName() {
		$numRows = $this->getConnection()->getRowCount("tag");
		//create a new tag and insert to into mySQL
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));

		$this-> assertContainsOnlyInstancesOf("Edu\\CNM\\OurVibe\\Tag", $results);
		$pdoTag = $results[0];
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("Tag"));
		$this->assertSame($pdoTag->getTagName(), $this->VALID_TAGNAME);
	}

	/**
	 * test grabbing a tag by tagName that does not exist
	 **/
	public function testGetInvalidTagByTagName(): void {
		$tag = Tag::getTagByTagName($this->getPDO(), "@doesnotexist");
	}

}