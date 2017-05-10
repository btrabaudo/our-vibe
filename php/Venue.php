<?php
namespace Edu\Cnm\OurVibe;


/**
 *TODO: ADD JSON, AUTO-LOADER, UNIT TEST
 * Class Venue
 * @package Edu\Cnm\OurVibe
 * @author QED
 */
class Venue implements \jsonSerialize{
    /**
     * @var int $venueId
     **/
    private $venueId;

    /**
     * @var int $venueImageId
     **/
    private $venueImageId;

    /**
     * @var string $venueActivationToken
     */
    private $venueActivationToken;
    /**
     * @var string $venueAddress1
     **/
    private $venueAddress1;
    /**
     * @var string $venueAddress2
     **/
    private $venueAddress2;

    /**
     * @var string $venueCity
     **/
    private $venueCity;
    /**
     * @var string $venueContact
     **/
    private $venueContact;
    /**
     * @var string $venueContent
     **/
    private $venueContent;
    /**
     * @var string $venueName
     **/
    private $venueName;
    /**
     * @var string $venuePassHash
     **/
    private $venuePassHash;
    /**
     * @var string $venuePassSalt
     **/
    private $venuePassSalt;
    /**
     * @var string $venueState
     **/
    private $venueState;
    /**
     * @var string $venueZip
     **/
    private $venueZip;

    public function __construct(?int $newVenueId, ?int $newVenueImageId, string $newVenueActivationToken, string $newVenueAddress1, ?string $newVenueAddress2, string $newVenueCity, string $newVenueContact, string $newVenueContent, string $newVenueName, string $newVenuePassHash, string $newVenuePassSalt, string $newVenueState, string $newVenueZip) {
        try {
            $this->setVenueId($newVenueId);
            $this->setVenueImageId($newVenueImageId);
            $this->setVenueActivationToken($newVenueActivationToken);
            $this->setVenueAddress1($newVenueAddress1);
            $this->setVenueAddress2($newVenueAddress2);
            $this->setVenueCity($newVenueCity);
            $this->setVenueContact($newVenueContact);
            $this->setVenueContent($newVenueContent);
            $this->setVenueName($newVenueName);
            $this->setVenuePassHash($newVenuePassHash);
            $this->setVenuePassSalt($newVenuePassSalt);
            $this->setVenueState($newVenueState);
            $this->setVenueZip($newVenueZip);
		}
		catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
	}
 /**
  * accessor method for venue id
  * @return int|null value of venue id
  **/

    public function getVenueId() : ?int {
        return($this->venueId);
    }

    /**
     * @param int|null $newVenueId
     * @throws \RangeException if $newVenueId is not positive
     * @throws \TypeError if $newVenueId is not an integer or null
     */
    public function setVenueId(?int $newVenueId) : void {
        //if new venue is is null return it posthaste
        if($newVenueId === null) {
            $this->venueId = null;
            return;
        }
        //verify that the venue id is positive
        if($newVenueId <=0) {
            throw(new \RangeException("venue id is not positive"));
        }

        //convert the new venue id to a venue id and store it
        $this->venueId = $newVenueId;
    }

    /**
     * accessor method for venue image id
     * @return int|null value of venue image id
     **/
    public function getVenueImageId(): ?int {
        return($this->venueImageId);
    }

    /**
     * mutator method for venue image id
     * @param int $newVenueImageId
     * @throws \RangeException if venue image id is not positive
     * @throws \TypeError if venue image id is not an int
     */
    public function setVenueImageId(?int $newVenueImageId) : void {

        //verify that the venue image id is positive
        if($newVenueImageId <=0) {
            throw(new \RangeException("venue image id is not positive"));
        }

        //convert the new venue image id to a venue image id and store it
        $this->venueImageId = $newVenueImageId;
    }



    /**
     * accessor method for Venue Activation Token
     * @return string
     */
    public function getVenueActivationToken(): string {
        return($this->venueActivationToken);
    }

    /**
     * mutator method for Venue Activation Token
     * @param string $newVenueActivationToken
     * enforced formatting on activation token
     * @throws \InvalidArgumentException if activation token is either empty or insecure
     * @throws \RangeException if activation token does not have 32 characters
     */
    public function setVenueActivationToken(string $newVenueActivationToken) : void {
        //enforce formatting on activation token
        $newVenueActivationToken = trim($newVenueActivationToken);
        $newVenueActivationToken = strtolower($newVenueActivationToken);

        //enforce content in venue activation Token
        if(empty($newVenueActivationToken) === true) {
            throw(new \InvalidArgumentException("venue activation token is either empty or insecure"));
        }
        //enforce hex in venue activation token
        if(!ctype_xdigit($newVenueActivationToken)) {
            throw(new \InvalidArgumentException("venue activation token is either empty or insecure"));
        }
        //enforce length on venue activation token
        if(strlen($newVenueActivationToken) !== 32) {
            throw(new \RangeException("venue activation token must be 32 characters"));
        }
        //store new venue authentication token in venue authentication token
        $this->venueActivationToken = $newVenueActivationToken;
    }


    /**
     * accessor method for venue address 1
     * @return string $newVenueAddress1
     */
    public function getVenueAddress1(): string {
        return($this->venueAddress1);
    }

    /**
     * mutator method for venue address 1
     * @param string $newVenueAddress1
     * @throws \InvalidArgumentException if venue address is not alphanumeric
     * @throws \RangeException if venue address 1 is more than 128 characters
     */
    public function setVenueAddress1(string $newVenueAddress1): void {
        $newVenueAddress1 = filter_var($newVenueAddress1, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        //if new venue address is null return it posthaste
        if($newVenueAddress1 === null) {
            $this->venueId = null;
            return;
        }
        //enforce alphanumeric content in venue address 1
        if(!ctype_alnum($newVenueAddress1)) {
            throw(new \InvalidArgumentException("product content must be alphanumeric"));
        }
        //enforce 128 characters in venue address 1
        if(strlen($newVenueAddress1) > 128) {
            throw(new \RangeException("venue address must be 128 characters"));
        }

        //convert new venue address 1 to venue address 1 and store it
        $this->venueAddress1 = $newVenueAddress1;
    }

    /**
     * accessor method for venue address 2
     * @return string for venue address 2
     */
    public function getVenueAddress2(): string {
        return($this->venueAddress2);
    }

    /**
     * mutator method for venue address 2
     * @param string $newVenueAddress2
     * @throws \InvalidArgumentException if new venue address 2 is not alphanumeric
     * @throws \RangeException if new venue address 2 is more than 128 characters
     */
    public function setVenueAddress2(string $newVenueAddress2): void {
        $newVenueAddress2 = filter_var($newVenueAddress2, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        //enforce alphanumeric content in venue address 2
        if(!ctype_alnum($newVenueAddress2)) {
            throw(new \InvalidArgumentException("venue address 2 must be alphanumeric"));
        }
        //enforce 128 characters in venue address 2
        if(strlen($newVenueAddress2) > 128) {
            throw(new \RangeException("venue address 2 must be 128 characters"));
        }
        // convert the new venue address 2 to a venue address and store it
        $this->venueAddress2 = $newVenueAddress2;
    }

    /**
     * accessor method for venue city
     * @return string for venue city
     */
    public function getVenueCity(): string {
        return($this->venueCity);
    }

    /**
     * mutator method for venue city
     * @param string $newVenueCity
     * @throws \InvalidArgumentException if the venue city is not composed with letters
     * @throws \RangeException if the the venue city is not less than 32 characters
     */
    public function setVenueCity(string $newVenueCity) : void {
        $newVenueCity = filter_var($newVenueCity, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        //if venue city is null return it posthaste
        if($newVenueCity === null) {
            $this->venueCity = null;
            return;
        }

        //enforce only letters in venue city
        if(!ctype_alpha($newVenueCity)) {
            throw(new \InvalidArgumentException("venue city must only be letters"));
        }
        //enforce 32 characters or less in venue city
        if(strlen($newVenueCity) > 32) {
            throw(new \RangeException("venue city must be less than 32 characters"));
        }

        //convert the new venue city to venue city and store it
        $this->venueCity = $newVenueCity;
    }

    /**
     * accessor method for venue contact
     * @return string venue contact
     */
    public function getVenueContact(): string{
        return($this->venueContact);
    }

    /**
     * ALERT STRANGE BUG IN THE FINAL LINE OF THIS FUNCTION
     * mutator method for venue contact
     * @param string $newVenueContact
     * @throws |\RangeException if venue contact is greater than 128 characters
     */
    public function setVenueContact(string $newVenueContact) : void {
        $newVenueContact = filter_var($newVenueContact, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        //if venue contact is null return it posthaste
        if($newVenueContact === null) {
            $this->venueContact = null;
            return;
        }

        //enforce that venue contact is less than 128 characters
        if(strlen($newVenueContact) < 128) {
            throw(new \RangeException("venue contact must be less than 128 characters"));
        }

        //convert new venue contact to venue contact at store it

        $this->venueContact = $newVenueContact;
    }

    /**
     * accessor method for venue content
     * @return string venue content
     */
    public function getVenueContent(): string {
        return($this->venueContent);
    }

    /**
     * ALERT WE MIGHT CONSIDER INCREASING THE SIZE OF THE CONTENT
     * mutator method for venue content
     * @param string $newVenueContent
     * @throws \InvalidArgumentException if venue content is not alphanumeric
     * @throws \RangeException if venue content is greater than 768
     */
    public function setVenueContent(string $newVenueContent) : void {
        $newVenueContent = filter_var($newVenueContent, FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);

        //if venue content is null return it posthaste
        if($newVenueContent === null) {
            $this->venueContent = null;
            return;
        }
        //enforce that venue content is alphanumeric
        if(!ctype_alnum($newVenueContent)) {
            throw(new \InvalidArgumentException("venue content must be alphanumeric"));
        }
         //enforce max string length of 768 on venue content
        if (strlen($newVenueContent) > 768) {
            throw(new \RangeException("venue content must be less than 768 characters"));
        }

        // take new venue content and store it in venue content
        $this->venueContent = $newVenueContent;
    }

    /**
     * accessor method for venue name
     * @return string for venue name
     */
    public function getVenueName(): string {
        return($this->venueName);
    }

    /**
     * mutator method for venue name
     * @param string $newVenueName
     * @throws \InvalidArgumentException if the venue name is not alphanumeric
     * @throws \RangeException if the venue name is greater than 32 characters
     */
    public function setVenueName(string $newVenueName) : void {
        $newVenueName = filter_var($newVenueName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        //if venue name is null return it posthaste
        if($newVenueName === null) {
            $this->venueName = null;
            return;
        }
        //enforce that venue name is alphanumeric
        if(!ctype_alnum($newVenueName)) {
            throw(new \InvalidArgumentException("venue name must be alphanumeric"));
        }
        //enforce max string length of venue name
        if(strlen($newVenueName) > 32) {
            throw(new \RangeException("venue name must be less than 32 characters"));
        }
        //take new venue name and store it in venue name
        $this->venueName = $newVenueName;
    }

    /**
     * accessor method for venue pass hash
     * @return string for venue pass hash
     */
    public function getVenuePassHash(): string {
        return($this->venuePassHash);
    }

    /**
     * mutator method for venue password hash
     * @param string $newVenuePassHash
     * $newVenuePassHash is trimmed and converted to lowercase
     * @throws \InvalidArgumentException if the hash is empty
     * @throws \InvalidArgumentException if the hash is not in hex
     * @throws \RangeException if the hash is not exactly 128 characters
     */
    public function setVenuePassHash(string $newVenuePassHash) : void {
        //enforce that the hash is formatted properly
        $newVenuePassHash = trim($newVenuePassHash);
        $newVenuePassHash = strtolower($newVenuePassHash);

        //enforce that the pass hash is not empty
        if(empty($newVenuePassHash) === true) {
            throw(new \InvalidArgumentException("pass hash is either empty or insecure"));
        }
        //enforce that the pass hash is hex
        if(!ctype_xdigit($newVenuePassHash)) {
            throw(new \InvalidArgumentException("pass hash is either empty or insecure"));
        }
        //enforce that the hash is exactly 128 characters
        if(strlen($newVenuePassHash) !==128) {
            throw(new \RangeException("pass hash must be exactly 128"));
        }

        //take new venue pass hash and store it in venue pass hash
        $this->venuePassHash = $newVenuePassHash;
    }

    /**
     * accessor method for venue pass salt
     * @return string for venue pass salt
     */
    public function getVenuePassSalt(): string {
        return($this->venuePassSalt);
    }

    /**
     * mutator method for venue pass salt
     * @param string $newVenuePassSalt
     * $newVenuePassSalt is trimmed and converted to lowercase
     * @throws \InvalidArgumentException when venue pass salt is not in hex
     * @throws \InvalidArgumentException when venue pass salt is empty
     * @throws \RangeException when venue pass salt is not exactly 64 characters
     */
    public function setVenuePassSalt(string $newVenuePassSalt) : void {
        //enforce that the salt is formatted properly
        $newVenuePassSalt = trim($newVenuePassSalt);
        $newVenuePassSalt = strtolower($newVenuePassSalt);

        //enforce that the pass hash is not empty
        if(empty($newVenuePassSalt) === true) {
            throw(new \InvalidArgumentException("pass salt is either empty or insecure"));
        }

        //enforce that the pass hash is hex
        if(!ctype_xdigit($newVenuePassSalt)) {
            throw(new \InvalidArgumentException("pass salt is either empty or insecure"));
        }

        //enforce that the salt is exactly 64 characters
        if(strlen($newVenuePassSalt) !== 64) {
            throw(new \RangeException("pass salt must be exactly 64 characters"));
        }
        //take new venue pass salt and store it in venue pass salt
        $this->venuePassSalt = $newVenuePassSalt;
    }

    /**
     * accessor method for venue state
     * @return string for venue state
     */
    public function getVenueState(): string {
        return($this->venueState);
    }

    /**
     * mutator method for venue state
     * @param string $newVenueState
     * @throws \InvalidArgumentException when venue state is not composed with letters
     * @throws \RangeException if venue state is greater than 32 characters
     */
    public function setVenueState(string $newVenueState){
        $newVenueState = filter_var($newVenueState, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        //if venue state is null return it posthaste
        if($newVenueState === null) {
            $newVenueState = null;
            return;
        }

        //enforce only letters in venue state
        if(!ctype_alpha($newVenueState)) {
            throw(new \InvalidArgumentException("venue state must only contain letters"));
        }

        //enforce that venue state is less than 32 characters
        if(strlen($newVenueState) > 32) {
            throw(new \RangeException("venue state must be less than 32 characters"));
        }

        //take new venue state and store it in venue state
        $this->venueState = $newVenueState;
    }

    /**
     * accessor method for venue zip
     * @return string for venue zip
     */
    public function getVenueZip(): string {
        return($this->venueZip);
    }

    /**
     * mutator method for venue zip
     * @param string $newVenueZip
     * @throws \RangeException if venue zip is longer than 10 characters
     */
    public function setVenueZip(string $newVenueZip) {
        $newVenueZip= filter_var($newVenueZip, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        //if venue zip is null return it posthaste
        if($newVenueZip === null) {
            $newVenueZip = null;
            return;
        }

        //enforce max length of 10 characters on venue zip
        if (strlen($newVenueZip) > 10) {
            throw(new \RangeException("venue zip can not be greater than 10 characters"));
        }

        //take new venue zip and store it in venue zip
        $this->venueZip = $newVenueZip;
    }

    /**
     *
     * @param \PDO $pdo connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     */

    public function insert(\PDO $pdo) : void {
        //enforce that venue id is not null
        if($this->venueId === null) {
            throw(new \PDOException("unable to insert into a profile that does not exist"));
        }
        //create query
         $query = "INSERT INTO venue(venueId, venueImageId, venueActivationToken, venueAddress1, venueAddress2, venueCity, venueContact, venueContent, venueName, venuePassHash, venuePassSalt, venueState, venueZip) VALUES (:venueId, :venueImageId, :venueActivationToken, :venueAddress1, :venueAddress2, :venueCity, :venueContact, :venueContent, :venueName, :venuePassHash, :venuePassSalt, :venueState, :venueZip)";
        $statement = $pdo-prepare($query);
        $parameters = ["venueId" => $this->venueId];
        $statement->execute($parameters);

    }

    /**
     * deletes this profile from mySQL
     * @param \PDO $pdo connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     *
     */

    public function delete(\PDO $pdo) : void {
        //enforce that venue id is not null

        if($this->venueId === null) {
            throw(new \PDOException("unable to delete a venue that does not exist"));
        }
        //create query
        $query = "DELETE FROM venue WHERE venueId = :venueId";
        $statement = $pdo->prepare($query);
        $parameters = ["venueId" => $this->venueId];
        $statement->execute($parameters);
    }

    /**
     * Updates this venue in mySQL
     * @param \PDO $pdo PDO connection style
     * @throws \PDOException when mySQL errors occur
     * @throws \TypeError if $pdo is not a pdo connection object
     */

    public function update(\PDO $pdo) : void {
        // enforce that venue id is not null
        if($this->venueId === null) {
            throw(new \PDOException("unable to update a profile that does not exist"));
        }

        $query = "UPDATE venue SET venueAddress1 = :venueAddress1, venueAddress2 = :venueAddress2, venueCity = :venueCity, venueContact = :venueContact, venueContent = :venueContent, venueName = :venueName, venueState = :venueState, venueZip = :venueZip";
        $statement = $pdo->prepare($query);
        $parameters = ["venueAddress1" => $this->venueAddress1, "venueAddress2" => $this->venueAddress2, "venueCity" => $this->venueCity, "venueContact" => $this->venueContact, "venueContent" => $this->venueContent, "venueName" => $this->venueName, "venueState" => $this->venueState, "venueZip" => $this->venueZip];
        $statement->execute($parameters);
    }

    public static function getVenueByVenueId(\PDO $pdo, int $venueId) : ?Venue {
        //make sure venue id is positive
        if($venueId <= 0) {
            throw(new \PDOException("venue id is not positive"));
        }
        //query for venue
        $query = "SELECT venueAddress1, venueAddress2, venueCity, venueContact, venueContent, venueName, venueState, venueZip FROM venue WHERE venueId = :venueId";
        $statement = $pdo->prepare($query);
        $parameters = ["venueId => $venueId"];
        $statement->execute($parameters);

        //fetch venue from mySQL
        try {
            $venue = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if(row !== false) {

            }
        }
    }














































}