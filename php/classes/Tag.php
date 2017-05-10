<?php
namespace Edu\Cnm\OurVibe;

class tag implements \JsonSerializable {

	/**
	 * id for this tag; this is the primary key
	 * @var int $tagId
	 */
	private $tagId;

	/**
	 * tagName for this tag
	 * @var string $tagName
	 **/

	private $tagName;


	/**
	 * constructor for this tag
	 * @param int|null $newTagId id of this tag or null if new tag
	 * @param string $newTagName name of the tag
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/

	public function __construct(?int $newTagId, ?string $newTagName) {
		try {
			$this->setTagId($newTagId);
			$this->setTagName($newTagName);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

	}
/**
 * accessor method for tagId
 * @return int value of profile id
 **/
public function getTagId(): int{
	return($this->tagId);
}

/**
 * mutator method for tag id
 * @param int|null $newTagId value of new tag id
 * @throws \RangeException if $newTagId is not positive
 * @throws \TypeError if $newTagId is not an integer
 **/

public function setTagId(?int $newTagId): void{
	if($newTagId ===null){
		$this->tagId = null;
		return;
	}
	if($newTagId <=0){
		throw(new \RangeException("tag id is not positive"));
	}
	$this->tagId = $newTagId;
}

/**
 * accessor method for tagName
 * @return string value of the tagName
 **/
public function getTagName() : ?string {
	return ($this->tagName);
}
/**
 * mutator method for tagName
 * @param string $newTagName
 * @throws \InvalidArgumentException if the tag name is not a string or insecure
 * @throws \RangeException if the tag name is not exactly 32 characters
 * @throws \TypeError id the tag name is not a string
 **/

public function setTagName(?string $newTagName): void {
	if($newTagName ===null){
		$this->tagName = null;
		return;
	}
$newTagName = strtolower(trim($newTagName));
	if(ctype_xdigit($newTagName) ===false){
		throw(new \RangeException("user tag name is not valid"));
	}
	if (strlen($newTagName) !==32) {
		throw(new \RangeException("user tag name has to be 32"));

	}
	$this->tagName = $newTagName;
}

/**
 * insert tag name into mySQL
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/

public function insert(\PDO $pdo): void{
	if($this->tagName !==null){
		throw(new \PDOException("not a new tag name"));
	}
$query = "INSERT INTO tag(tagId,tagName) VALUES (:tagId,tagName)";
	$statement = $pdo->prepare($query);

	$parameters =["tagId"=>$this->tagId,"tagName"=> $this->tagName];
	$statement->execute($parameters);

	$this->tagId= intval($pdo->lastInsertId());
}

/**
 * deletes this profile from mySQL
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function delete(\PDO $pdo): void {
	if($this->tagId===null){
		throw(new \PDOException("unable to delete a tag that does not exist"));
	}
$query = "DELETE FROM tag WHERE tagId=:tagId";
	$statement = $pdo->prepare($query);
	$parameters = ["tagId"=> $this->tagId];
	$statement->execute($parameters);
}
/**
 * updates this profile from mySQL
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function update(\PDO $pdo, $statement): void {
	if($this->tagId ===null){
		throw(new \PDOException("unable to delete a tag that does not exist"));
	}
	$query = "UPDATE tag SET tagId = :tagId,tagName = :tagId,tagName =tagName WHERE tagId=:tagId";

	$parameters = ["tagId"=> $this->tagId,"tagName"=> $this->tagName];

	$statement->execute($parameters);

}
/**
 * gets the tag by the tag id
 * @param \PDO $pdo PDO connection object
 * @param int $tagId tag id to search for
 * @return tag|null tag or null if not found
 * @throws \PDOException when mySQL related errors occcur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getTagByTagId(\PDO $pdo,int $tagId):?\tag {
	if($tagId <=0) {
		throw(new \PDOException("tag id is not positive"));
	}
$query = "SELECT tagId, tagName";
$statement = $pdo->prepare($query);
$parameters = ["tagId => $tagId"];
$statement->execute($parameters);
try {
	$tag = null;
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	$row = $statement->fetch();
	if($row !==false){
		$tag = new tag($row["tagId"],$row["tagName"]);

	}
}
catch(\Exception $exception){throw(new \PDOException($exception->getMessage(),0, $exception));
}
return($tag);
}

/**
 * get the tag by the tag name
 * @param \PDO $pdo connection object
 * @string $tagName to search for
 * @return \SplFixedArray of all tags found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
	public static function getTagByTagName(\PDO $pdo, string $tagName) : \SplFixedArray {
		$tagName = trim($tagName);
		$tagName = filter_var($tagName,FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($tagName)===true){
			throw(new \PDOException("not a valid tag"));
		}
	$query = "SELECT tagId, tagName FROM tag WHERE tagName = :tagName";
		$statement = $pdo->prepare($query);
		$parameters = ["tagName"=> $tagName];
		$statement->execute($parameters);


		$tags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while(($row = $statement->fetch())!==false){
			try{
				$tag = new tag($row["tagId"], $row["tagName"]);
				$tags[$tags->key()]=$tag;
				$tags->next();
			} catch(\Exception $exception){
				throw(new \PDOException($exception->getMessage(),0,$exception));
			}
		}
	}
	/**
	 * formats state variables for json serialization
	 * @return array resulting
	 **/
	public function jsonSerialize() {
		// TODO: Implement jsonSerialize() method.
	}


}