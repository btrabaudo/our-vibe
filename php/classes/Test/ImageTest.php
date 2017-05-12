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
 * @author marcoder (mlester3@cnm.edu>
 **/
class ImageTest extends OurVibeTest {
	/**
	 * Image that created the Image; this is for foreign key relations
	 *
	 * @var Image image
	 **/
	protected $image = null;

	/**
	 * valid image hash to create the image object to own the test
	 *
	 * @var $VALID_HASH
	 */
	protected $VALID_IMAGE_HASH;

	/**
	 * valid salt to use to create the image object to own the test
	 * @var string $VALID_SALT
	 */
	protected $VALID_PROFILE_SALT;


}