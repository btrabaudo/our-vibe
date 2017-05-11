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
	 * @param string $newImageCloudinaryId this string contains cloudinary api
	 * @throws \InvalidArgumentException if data values are not valid
	 * @throws \RangeException if data values are out of bounds (e.g, strings too long, negative integers
	 * @throws \TypeError if data types violate type hints
	 * @throws \ Exception if some other exception occurs
	 **/
	public function __construct(?int $newImageId, ?string $newImageCloudinaryId) {
		try {
			$this->setImageId($newImageId);
			$this->setImageCloudinaryId($newImageCloudinaryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			// determine what exception is thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage("say what you will"), 0, $exception));
		}
	}

	/** accessor method for image id
	 *
	 * @return int value of image id (or null if new Image)
	 **/
	public function getImageId(): int {
		return ($this->ImageId);
	}
	/**
	 * mutator method for image id
	 *
	 * @param int|null $newImageId value of new image id
	 * @throws \RangeException if $newImageId is not positive
	 * @throws |TypeError if $newImageId is not an integer
	 **/
	public function setmageId(?int $newImageId): void {
		if($newImageId === null) {
			$this->ImageId = null;
			return;
		}

		// verify the image id is Positive
		If($newImageId <= 0) {
			throw(new \RangeException("image id is not positive"));
		}

		// convert and store the image id
		$this->profileId = $newImageId;

	}

	}






























