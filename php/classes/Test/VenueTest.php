<?php
namespace Edu\Cnm\OurVibe\Test;

use Edu\Cnm\OurVibe\OurVibeTest;
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
     * Placeholder until account activation is created
     * @var string $VALID_ACTIVATION
     */

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

    }

    /**
     * test inserting a valid venue and verify the mySQL data
     **/

    public function testInsertValidVenue() : void {
        //count the rows and save it

        $numRows = $this->getConnection()->getRowCount("venue");

        //create a new venue and insert it into mySQL DB

        $venue = new Venue(null, null, $this->VALID_ACTIVATION, $this->VALID_ADDRESS1, $this->VALID_ADDRESS2, $this->VALID_CITY, $this->VALID_CONTACT, $this->VALID_CONTENT, $this->VALID_NAME, $this->VALID_STATE, $this->VALID_ZIP, $this->VALID_HASH, $this->VALID_SALT);

        //var_dump($venue);

        $venue->insert($this->getPDO());

        //grab data from mySQL and enforce that they match our expectations
        $pdoVenue = Venue::getVenueByVenueId($this->getPDO(), $venue->getVenueId());
        $this->assertSame($numRows + 1, $this->getConnection()->getRowCount("venue"));
        $this->assertSame($pdoVenue->getVenueActivationToken(), $this->VALID_ACTIVATION);
        $this->assertSame($pdoVenue->getVenueAddress1(), $this->VALID_ADDRESS1);
        $this->assertSame($pdoVenue->getVenueAddress2(), $this->VALID_ADDRESS2);
        $this->assertSame($pdoVenue->getVenueCity(), $this->VALID_CITY);
        $this->assertSame($pdoVenue->getVenueContact(), $this->VALID_CONTACT);
        $this->assertSame($pdoVenue->getVenueContent(), $this->VALID_CONTENT);
        $this->assertSame($pdoVenue->getVenueName(), $this->VALID_NAME);
        $this->assertSame($pdoVenue->getVenueState(), $this->VALID_STATE);
        $this->assertSame($pdoVenue->getVenueZip(), $this->VALID_ZIP);
        $this->assertSame($pdoVenue->getVenuePassHash(), $this->VALID_HASH);
        $this->assertSame($pdoVenue->getVenuePassSalt(), $this->VALID_SALT);
    }







}


