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
	 * @var string $imageCloudinaryId
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
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/** accessor method for image id
	 *
	 * @return int value of image id (or null if new Image)
	 **/
	public function getImageId(): int {
		return ($this->imageId);
	}
	/**
	 * mutator method for image id
	 *
	 * @param int|null $newImageId value of new image id
	 * @throws \RangeException if $newImageId is not positive
	 * @throws |TypeError if $newImageId is not an integer
	 **/
	public function setImageId(?int $newImageId): void {
		if($newImageId === null) {
			$this->ImageId = null;
			return;
		}

		// verify that  the image id is Positive
		If($newImageId <= 0) {
			throw(new \RangeException("image id is not positive"));
		}

		// convert and store the image id
		$this->imageId = $newImageId;


	}
	/**
	 * accessor method for cloudinary id
	 *
	 * @return string value of cloudinary id or null
	 **/
	public function getImageCloudinaryId(): ?string {
		return ($this->imageCloudinaryId);
	}

	/**
	 * mutator method for cloudinary id
	 *
	 * @param string $newImageColudinaryId new value of cloudinary id
	 * @throws \InvalidArgumentException if $newImageCloudinaryId is not a string or is insecure
	 * @throws \RangeException if $newImageCloudinaryId > 32 characters
	 * @throws \TypeError if $newImageCloudinaryId is not a string
	 **/
	public function setImageCloudinaryId(?string $newImageCloudinaryId): void {
		// If $imageCloudinaryId is null return it right away
		if($newImageCloudinaryId === null) {
			$this->imageCloudinaryId = null;
			return;
		}


		// verify the imageCloudinaryId is secure
		$newImageCloudinaryId = trim($newImageCloudinaryId);
		$newImageCloudinaryId = filter_var($newImageCloudinaryId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newImageCloudinaryId) === true) {
			throw(new \RangeException("cloudinary id is empty or insecure"));
		}
		// verify the CloudinaryId will fit in the database
		if(strlen($newImageCloudinaryId) > 32) {
			throw(new \RangeException("cloudinary id is too large"));
		}

		// store the cloudinaryId
		$this->imageCloudinaryId = $newImageCloudinaryId;
	}

	/**
	 *inserts this image into mySQL
	 *@param \PDO $pdo connection object
	 *@throws \PDOException when mySQL related errors occur
	 *@throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// enforce the imageId is null (i.e., dont insert a image that already exists)
		if($this->imageId !== null) {
			throw(new \PDOException("not a new image"));
		}

		// create query template
		$query = "INSERT INTO image(imageId, imageCloudinaryId) VALUES (:imageId, :imageCloudinaryId)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholders in the template
		$parameters = ["imageId" => $this->imageId, "imageCloudinaryId" => $this->imageCloudinaryId];
		$statement->execute($parameters);

		//update the null imageId with mySQL just gave us
		$this->imageId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this image from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors that occur
	 * @throws \TypeError if $pdo is not a PDO connection objects
	 **/
	public function delete(\PDO $pdo): void {
		// enforce that imageId is not null (i/e., don't delete a image that does not exist)
		if($this->imageId === null) {
			throw(new \PDOException("there is no image to delete"));
		}

		// create query template
		$query = "DELETE FROM image WHERE imageId = :imageId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["imageId" => $this->imageId];
		$statement->execute($parameters);
	}

	/**
	 * gets the image by image id
	 *
	 * @param \PDO $pdo PDO connection objects
	 * @param int $imageId image id to search for
	 * @return Image|null Image or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function  getImageByImageId(\PDO $pdo, int $imageId):?Image {
		// sanitize the image id before searching
		if($imageId <= 0) {
			throw(new \PDOException("image id is not positive"));
		}

		// create query template
		$query = "SELECT imageId, imageCloudinaryId FROM image WHERE imageId = :imageId";
		$statement = $pdo->prepare($query);

		// bind the image id to the place holder in the template
		$parameters = ["imageId" => $imageId];
		$statement->execute($parameters);

		// grab the image from mySQL
		try {
					$image = null;
					$statement->setFetchMode(\PDO::FETCH_ASSOC);
					$row = $statement->fetch();
					if($row !== false) {
							$image = new Image($row["imageId"], $row["imageCloudinaryId"]);
					}
		} catch(\Exception $exception) {
					// if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
			return ($image);
	}
	/**
	 * gets an image by the imageCloudinaryId
	 * @param \PDO $pdo PDO Connection Object
	 * @param string $imageCloudinaryId image id from Cloudinary API to search for
	 * @return Image|null Image found or doesn't exist
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when variables are not correct type
	 **/
	public static function getImageByImageCloudinaryId(\PDO $pdo, string $imageCloudinaryId) {
		//throw an exception if imageId is empty
		if(is_string($imageCloudinaryId) !== true) {
			throw(new \TypeError("Image Cloudinary ID is not a string"));
		} elseif(strlen($imageCloudinaryId) > 32) {
			throw(new \RangeException("ID is too long"));
		}
		$query = "SELECT imageId, imageCloudinaryId FROM image WHERE imageCloudinaryId = :imageCloudinaryId";
		$statement = $pdo->prepare($query);
		$parameters = ["imageCloudinaryId" => $imageCloudinaryId];
		$statement->execute($parameters);
		try {
			$image = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$image = new Image($row["imageId"], $row["imageCloudinaryId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($image);
	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables for JSON serialization
	 **/
	public function jsonSerialize() {
				return (get_object_vars($this));
	}
}