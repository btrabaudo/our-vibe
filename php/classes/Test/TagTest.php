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
	 * @var string $VALID_TAGNAME
	 **/
	protected $VALID_TAGNAME = "validTag";

	/**
	 * @var string $INVALID_TAGNAME
	 **/
	protected $INVALID_TAGNAME = "thisIsAnInvalidTagNameBecauseItIsWayTooLong";


	/**
	 * test inserting a valid Tag and verify that the actual mySQL data matches
	 **/
	public function testInsertValidTag(): void {
		$numRows = $this->getConnection()->getRowCount("tag");
		//var_dump($this->VALID_TAGNAME);
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagName(), $this->VALID_TAGNAME);
	}

	/**
	 * test inserting a tag that already exists
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidTag(): void {
		$tag = new Tag(OurVibeTest::INVALID_KEY, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());
	}

	/**
	 * test creating a tag and then deleting it
	 **/
	public function testDeleteValidTag(): void {
		$numRows = $this->getConnection()->getRowCount("tag");
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());

		//delete tag from mysql
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$tag->delete($this->getPDO());

		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertNull($pdoTag);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("tag"));
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
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagName(), $this->VALID_TAGNAME);
	}


	public function testGetValidTagByTagName() {
		$numRows = $this->getConnection()->getRowCount("tag");

		//create a new tag and insert to into mySQL
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());

		$results = Tag::getTagByTagName($this->getPDO(), $tag->getTagName());
		$this->assertEquals($numRows + 1,$this->getConnection()->getRowCount("tag"));
		$this->assertCount(1,$results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\OurVibe\\Tag", $results);

		$pdoTag = $results[0];
		// create assertEquals statements here to check TagName is what we inserted
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagName(), $this->VALID_TAGNAME);
	}

	/**
	 * test grabbing a tag by tagName that does not exist
	 **/
	public function testGetInvalidTagByTagName(): void {
		$tag = Tag::getTagByTagName($this->getPDO(), "@doesnotexist");
		$this->assertCount(0, $tag);
	}

	//do a getAllTags test method here

	/**
	 * test get all tags
	 */
	public function testAllValidTags() : void {
		$numrows = $this->getConnection()->getRowCount("tag");

		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());

		$results = Tag::getAllTags($this->getPDO());
		$this->assertEquals($numrows +1, $this->getConnection()->getRowCount("tag"));
		$this->assertCount(1,$results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\OurVibe\\Tag",$results);

		$pdoTag = $results[0];
		$this->assertEquals($pdoTag->getTagId(), $tag->getTagId());
		$this->assertEquals($pdoTag->getTagName(), $this->VALID_TAGNAME);
	}



}




























