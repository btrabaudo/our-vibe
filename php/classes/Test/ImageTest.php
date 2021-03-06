<?php
namespace Edu\Cnm\OurVibe\Test;

use Edu\Cnm\OurVibe\Image;

//  grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full php unit test for image class
 *
 * this is a complete php unit test of the image class. it's complete because all mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Image
 * @author marcoder <mlester3@cnm.edu>
 **/

class ImageTest extends OurVibeTest {
	/**
	 *
	 *
	 * @var Image image
	 **/

	protected $image = null;

	/**
	 * cloudinary id this image belongs to
	 *
	 * @Var $VALID_CLOUDINARY_ID
	 **/

	protected $VALID_CLOUDINARY_ID ="skdueidhfj";

	/**
	 * test inserting a valid Image and verify that the actual mySQL data matches
	 **/

	public function testInsertValidImage(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		// create a new Image and insert to into mySQL
		$image = new Image(null, $this->VALID_CLOUDINARY_ID);

		//var_dump($Image);
		$image->insert($this->getPDO());
		// grab the image we just inserted and make sure it meets expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageCloudinaryId(), $image->getImageCloudinaryId());
	}

	/**
	 * test inserting a Image that already exists
	 *
	 * @expectedException \PDOException
	 **/

	public function testInsertInvalidImageId(): void {

		// create a image with a non null imageId and watch it fail
		$image = new Image(OurVibeTest::INVALID_KEY, $this->VALID_CLOUDINARY_ID);
		$image->insert($this->getPDO());
	}

	/**
	 * test creating a Image and then deleting it
	 **/

	public function testDeleteValidImage(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		// create a new Image and insert to into mySQL
		$image = new Image(null,$this->VALID_CLOUDINARY_ID);
		$image->insert($this->getPDO());

		// delete the Image from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$image->delete($this->getPDO());


		// grab the data from mySQL and enforce the Image does not exist
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());


		$this->assertNull($pdoImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("image"));

	}

	/**
	 * test deleting a Image that does not exist
	 *
	 * @expectedException \PDOException
	 **/

	public function testDeleteInvalidImage(): void {

		// create a Image and try to delete it without actually inserting it
		$image = new Image(null, $this->VALID_CLOUDINARY_ID);
		$image->delete($this->getPDO());
	}

	/**
	 * test inserting a Image and regrabing it from mySQL
	 **/

	public function testGetValidImageByImageId(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		// create a new Image and insert to into mySQL
		$image = new Image(null, $this->VALID_CLOUDINARY_ID);
		$image->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageCloudinaryId(), $image->getImageCloudinaryId());
	}

	/**
	 * test grabbing a Image that does not exist
	 **/

	public function testGetInvalidImageByImageId() : void {

		// grab a image id that exceeds the maximum allowable image id
		$image = Image::getImageByImageId($this->getPDO(), OurVibeTest::INVALID_KEY);
		$this->assertNull($image);
	}

}