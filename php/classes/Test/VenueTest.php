<?php
namespace Edu\Cnm\OurVibe\Test;

use Edu\Cnm\OurVibe\Image;
use Edu\Cnm\OurVibe\Venue;

// grabs the class to be tested
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * PhpUnit test for Venue class
 * This is a complete test of the Venue class, all mySQL/PDO methods are tested for both invalid and valid inputs.
 *
 * @see Venue
 * @author QED with thanks to @deepdivedylan
 **/

class VenueTest extends OurVibeTest {
    /**
     * this is cmd space's fault
     * @var Image $VALID_IMAGE
     **/

    protected $VALID_IMAGE = null;


    /**
     * Placeholder until account activation is created
     * @var string $VALID_ACTIVATION
     **/

    protected $VALID_ACTIVATION;

    /**
     * valid address 1 to use
     * @var string $VALID_ADDRESS1
     **/

    protected $VALID_ADDRESS1 = "3237 Bartlett Avenue";

    /**
     * valid address 2 to use
     * @var string $VALID_ADDRESS2
     **/

    protected $VALID_ADDRESS2 = "509 Webster Street";

    /**
     * valid city to use
     * @var string $VALID_CITY
     **/

    protected $VALID_CITY = "POLARIS";

    /**
     * valid contact to use
     * @var string $VALID_CONTACT
     **/

    protected $VALID_CONTACT = "732-626-8903, Vegan meggings pop-up green juice, VHS pickled lumber. lumber@lumber.com";

    /**
     * valid content to use
     * @var string $VALID_CONTENT
     **/

    protected $VALID_CONTENT = "Kale chips thundercats umami next level. ";

    /**
     * valid name to use
     * @var string $VALID_NAME
     */

    protected $VALID_NAME = "austin thundercats";

    /**
     * valid state to use
     * @var string $VALID_STATE
     **/

    protected $VALID_STATE = "round";

    /**
     * valid zip to use
     * @var string $VALID_ZIP
     **/

    protected $VALID_ZIP = "59746-6666";

    /**
     * valid hash to use
     * @var string $VALID_HASH
     **/

    protected $VALID_HASH;

    /**
     * valid salt to use
     * @var string $VALID_SALT;
     **/

    protected $VALID_SALT;



    /**
     * run default setup operation to create salt and hash
     */

    public final function setUp() : void {
        parent::setUp();

        //inputs for setup
        $password = "InsertYourSudoPassHere";
        $this->VALID_SALT = bin2hex(random_bytes(32));
        $this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 275142);
        $this->VALID_ACTIVATION = bin2hex(random_bytes(32));

        $this->VALID_IMAGE = new Image(null, null);
        $this->VALID_IMAGE->insert($this->getPDO());

    }

    /**
     * test inserting a valid venue and verify the mySQL data
     **/

    public function testInsertValidVenue() : void {
        //count the rows and save it

        $numRows = $this->getConnection()->getRowCount("venue");

        //create a new venue and insert it into mySQL DB

        $venue = new Venue(null,  $this->VALID_IMAGE->getImageId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_HASH, $this->VALID_SALT);

        //var_dump($venue);

        $venue->insert($this->getPDO());

        //grab data from mySQL and enforce that they match our expectations
        $pdoVenue = Venue::getVenueByVenueId($this->getPDO(), $venue->getVenueId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
        $this->assertEquals($pdoVenue->getVenueActivationToken(), $this->VALID_ACTIVATION);
        $this->assertEquals($pdoVenue->getVenueAddress1(), $this->VALID_ADDRESS1);
        $this->assertEquals($pdoVenue->getVenueAddress2(), $this->VALID_ADDRESS2);
        $this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_CITY);
        $this->assertEquals($pdoVenue->getVenueContact(), $this->VALID_CONTACT);
        $this->assertEquals($pdoVenue->getVenueContent(), $this->VALID_CONTENT);
        $this->assertEquals($pdoVenue->getVenueName(), $this->VALID_NAME);
        $this->assertEquals($pdoVenue->getVenueState(), $this->VALID_STATE);
        $this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_ZIP);
        $this->assertEquals($pdoVenue->getVenuePassHash(), $this->VALID_HASH);
        $this->assertEquals($pdoVenue->getVenuePassSalt(), $this->VALID_SALT);
    }

    /**
     * test inserting a profile that already exists
     *
     * @expectedException \PDOException
     **/

    public function testInsertInvalidVenue() : void {
        // create venue with a non null venueId and see it fail
        $venue = new Venue(VenueTest::INVALID_KEY, null, $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_HASH, $this->VALID_SALT);

        $venue->insert($this->getPDO());
    }

    /**
     * test inserting a venue, editing it, and then updating it
     **/

    public function testUpdateValidProfile() {
        $numRows = $this->getConnection()->getRowCount("venue");

        //create a new venue and insert it into mySQL DB

        $venue = new Venue(null, $this->VALID_IMAGE->getImageId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_HASH, $this->VALID_SALT);

        $venue->insert($this->getPDO());

        //edit the venue and then update
        $venue->setVenueAddress1($this->VALID_ADDRESS2);
        $venue->update($this->getPDO());

        //grab data from mySQL and enforce that they match our expectations
        $pdoVenue = Venue::getVenueByVenueId($this->getPDO(), $venue->getVenueId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
        $this->assertEquals($pdoVenue->getVenueActivationToken(), $this->VALID_ACTIVATION);
        $this->assertEquals($pdoVenue->getVenueAddress1(), $this->VALID_ADDRESS1);
        $this->assertEquals($pdoVenue->getVenueAddress2(), $this->VALID_ADDRESS2);
        $this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_CITY);
        $this->assertEquals($pdoVenue->getVenueContact(), $this->VALID_CONTACT);
        $this->assertEquals($pdoVenue->getVenueContent(), $this->VALID_CONTENT);
        $this->assertEquals($pdoVenue->getVenueName(), $this->VALID_NAME);
        $this->assertEquals($pdoVenue->getVenueState(), $this->VALID_STATE);
        $this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_ZIP);
        $this->assertEquals($pdoVenue->getVenuePassHash(), $this->VALID_HASH);
        $this->assertEquals($pdoVenue->getVenuePassSalt(), $this->VALID_SALT);

    }

    /**
     * test updating a venue that is the product of lies
     *
     * @expectedException \PDOException
     **/

    public function testUpdateInvalidProfile() {

        //create a new venue and insert it into mySQL DB

        $venue = new Venue(null, $this->VALID_IMAGE->getImageId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_HASH, $this->VALID_SALT);
        $venue->update($this->getPDO());

    }

    /**
     * test creating a venue and then deleting it
     **/

    public function testDeleteValidProfile() : void {

        // count the number of rows
        $numRows = $this->getConnection()->getRowCount("venue");

        //create a new venue and insert it into mySQL DB

        $venue = new Venue(null, $this->VALID_IMAGE->getImageId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_HASH, $this->VALID_SALT);

        $venue->insert($this->getPDO());

        //delete the Venue from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
        $this->delete($this->getPDO());

        // grab the data from mySQL and enforce the Venue does not exist
        $pdoVenue = Venue::getVenueByVenueId($this->getPDO(), $venue->getVenueId());
        $this->assertNull($pdoVenue);
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));


    }

    /**
     * test deleting a venue that does not exist
     *
     * @expectedException \PDOException
     **/

    public function testDeleteInvalidVenue() : void {

        //create a new venue but DO NOT INSERT and then delete

        $venue = new Venue(null, $this->VALID_IMAGE->getImageId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_HASH, $this->VALID_SALT);

        $venue->delete($this->getPDO());


    }

    /**
     * test inserting venue and re-grab it from mySQL
     */

    public function testGetValidVenueByVenueId() : void {

        // count the number of rows
        $numRows = $this->getConnection()->getRowCount("venue");

        //create a new venue and insert it into mySQL DB
        $venue = new Venue(null, $this->VALID_IMAGE->getImageId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_HASH, $this->VALID_SALT);

        $venue->insert($this->getPDO());


        //grab data from mySQL and enforce that they match our expectations
        $pdoVenue = Venue::getVenueByVenueId($this->getPDO(), $venue->getVenueId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
        $this->assertEquals($pdoVenue->getVenueActivationToken(), $this->VALID_ACTIVATION);
        $this->assertEquals($pdoVenue->getVenueAddress1(), $this->VALID_ADDRESS1);
        $this->assertEquals($pdoVenue->getVenueAddress2(), $this->VALID_ADDRESS2);
        $this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_CITY);
        $this->assertEquals($pdoVenue->getVenueContact(), $this->VALID_CONTACT);
        $this->assertEquals($pdoVenue->getVenueContent(), $this->VALID_CONTENT);
        $this->assertEquals($pdoVenue->getVenueName(), $this->VALID_NAME);
        $this->assertEquals($pdoVenue->getVenueState(), $this->VALID_STATE);
        $this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_ZIP);
        $this->assertEquals($pdoVenue->getVenuePassHash(), $this->VALID_HASH);
        $this->assertEquals($pdoVenue->getVenuePassSalt(), $this->VALID_SALT);
    }

    /**
     * test grabbing a venue that does not exist
     *
     *  @expectedException \PDOException
     **/

    public function testGetInvalidVenueByVenueId() : void {
        // grab a venue id that exceeds the maximum allowable venue id
        $venue = Venue::getVenueByVenueId($this->getPDO(), VenueTest::INVALID_KEY);
        $this->assertNull($venue);
    }

    /**
     * test grabbing a venue by venue city
     **/

    public function testGetVenuebyVenueCity() : void {
        // count the number of rows
        $numRows = $this->getConnection()->getRowCount("venue");

        //create a new venue and insert it into mySQL DB
        $venue = new Venue(null, $this->VALID_IMAGE->getImageId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_HASH, $this->VALID_SALT);

        $venue->insert($this->getPDO());

        //grab data from mySQL
        $results = Venue::getVenueByVenueCity($this->getPDO (), $this->VALID_CITY);
        $this->assertEquals($numRows +1, $this->getConnection()->getRowCount("venue"));

        //enforce that no other class is bleeding into venue
        $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\OurVibe\\Venue", $results);

        // enforce that the results meet expectations

        $pdoVenue = $results[0];
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
        $this->assertEquals($pdoVenue->getVenueActivationToken(), $this->VALID_ACTIVATION);
        $this->assertEquals($pdoVenue->getVenueAddress1(), $this->VALID_ADDRESS1);
        $this->assertEquals($pdoVenue->getVenueAddress2(), $this->VALID_ADDRESS2);
        $this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_CITY);
        $this->assertEquals($pdoVenue->getVenueContact(), $this->VALID_CONTACT);
        $this->assertEquals($pdoVenue->getVenueContent(), $this->VALID_CONTENT);
        $this->assertEquals($pdoVenue->getVenueName(), $this->VALID_NAME);
        $this->assertEquals($pdoVenue->getVenueState(), $this->VALID_STATE);
        $this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_ZIP);
        $this->assertEquals($pdoVenue->getVenuePassHash(), $this->VALID_HASH);
        $this->assertEquals($pdoVenue->getVenuePassSalt(), $this->VALID_SALT);
    }

    /**
     * test grabbing a venue by a city that does not exist
     * @expectedException \PDOException
     **/
    public function testGetInvalidVenueByVenueCity() : void {
        $venue = Venue::getVenueByVenueCity($this->getPDO(), "truthCity");
        $this->assertCount(0, $venue);


    }

    /**
     * test grabbing a venue by its name
     **/

    public function testGetValidProfileByName() : void {
        // count the number of rows
        $numRows = $this->getConnection()->getRowCount("venue");

        //create a new venue and insert it into mySQL DB
        $venue = new Venue(null, $this->VALID_IMAGE->getImageId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_HASH, $this->VALID_SALT);

        $venue->insert($this->getPDO());

        // grab data from mySQL and enforce the fields match expectations
        $pdoVenue = Venue::getVenueByVenueName($this->getPDO(), $venue->getVenueName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
        $this->assertEquals($pdoVenue->getVenueActivationToken(), $this->VALID_ACTIVATION);
        $this->assertEquals($pdoVenue->getVenueAddress1(), $this->VALID_ADDRESS1);
        $this->assertEquals($pdoVenue->getVenueAddress2(), $this->VALID_ADDRESS2);
        $this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_CITY);
        $this->assertEquals($pdoVenue->getVenueContact(), $this->VALID_CONTACT);
        $this->assertEquals($pdoVenue->getVenueContent(), $this->VALID_CONTENT);
        $this->assertEquals($pdoVenue->getVenueName(), $this->VALID_NAME);
        $this->assertEquals($pdoVenue->getVenueState(), $this->VALID_STATE);
        $this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_ZIP);
        $this->assertEquals($pdoVenue->getVenuePassHash(), $this->VALID_HASH);
        $this->assertEquals($pdoVenue->getVenuePassSalt(), $this->VALID_SALT);


    }

    /**
     * test grabbing a venue by a name that does not exist
     *
     * @expectedException \PDOException
     **/

    public function testGetInvalidVenueByName() : void {
        // grab a venue that does not exist
        $venue = Venue::getVenueByVenueName($this->getPDO(), "aHappyPlace");

        $this->assertNull($venue);
    }

    /**
     * test grabbing a venue by its activation
     **/
    public function testGetValidVenueByActivationToken() : void {
        // count the number of rows
        $numRows = $this->getConnection()->getRowCount("venue");

        //create a new venue and insert it into mySQL DB
        $venue = new Venue(null, $this->VALID_IMAGE->getImageId(), $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_HASH, $this->VALID_SALT);

        $venue->insert($this->getPDO());

        // grab data from mySQL and enforce the fields match expectations
        $pdoVenue = Venue::getVenueByVenueActivationToken($this->getPDO(), $venue->getVenueActivationToken());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("venue"));
        $this->assertEquals($pdoVenue->getVenueActivationToken(), $this->VALID_ACTIVATION);
        $this->assertEquals($pdoVenue->getVenueAddress1(), $this->VALID_ADDRESS1);
        $this->assertEquals($pdoVenue->getVenueAddress2(), $this->VALID_ADDRESS2);
        $this->assertEquals($pdoVenue->getVenueCity(), $this->VALID_CITY);
        $this->assertEquals($pdoVenue->getVenueContact(), $this->VALID_CONTACT);
        $this->assertEquals($pdoVenue->getVenueContent(), $this->VALID_CONTENT);
        $this->assertEquals($pdoVenue->getVenueName(), $this->VALID_NAME);
        $this->assertEquals($pdoVenue->getVenueState(), $this->VALID_STATE);
        $this->assertEquals($pdoVenue->getVenueZip(), $this->VALID_ZIP);
        $this->assertEquals($pdoVenue->getVenuePassHash(), $this->VALID_HASH);
        $this->assertEquals($pdoVenue->getVenuePassSalt(), $this->VALID_SALT);
    }


    /**
     * test grabbing a venue by an activation Token that does not exist
     *
     * @expectedException \PDOException
     **/

    public function testGetInvalidProfileActivation() : void {
        // grab an activation token does not exist
        $venue = Venue::getVenueByVenueActivationToken($this->getPDO(), "PtPf67rUtkfs5tIXHkWo3QHofdXGc9Fm");
        $this->assertNull($venue);
    }


}


