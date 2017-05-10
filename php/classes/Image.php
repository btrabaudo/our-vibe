<?php
namespace Edu\Cnm\OurVibe;
require_once("autoload.php");

/**
 * this is the primary key for Image class
 *
 * @author Marcoder <mlester3@cnm.edu>
 * @version 7.1.0
 **/
class Image implements \JsonSerializable {
	/**
	 * id for an event: this is the primary key
	 *
	 * @var int $imageId
	 **/
	private $imageId;
	/**
	 * api where images are stored
	 *
	 * @var string $productProfileId
	 **/
	private $imageCloudinaryId;

	/**
	 * this is the images constructor
	 *
	 * @param int|null $newImageId of this Image or null of a new image
	 *
	 * @param string $newImageCloudinaryId
	 */
}