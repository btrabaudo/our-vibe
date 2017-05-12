<?php
namespace Edu\Cnm\OurVibe\Test;
// Test Case is the blank test from phpUnit. framework is core phpUnit
use PHPUnit\Framework\TestCase;
// Dbunit is the subproject for database testing, testcase traits is an injeted trait
use PHPUnit\DbUnit\TestCaseTrait;
// Tells phpUnit what our set looks like
use PHPUnit\DbUnit\DataSet\QueryDataSet;
// The connection to the database
use PHPUnit\DbUnit\Database\Connection;
// Composit is for creating multi step tear down, operation is the member of an array
use PHPUnit\DbUnit\Operation\{Composite, Factory, Operation};

// grab the encrypted properties file
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

// autoload Composer packages
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");

/**
 * Abstract class containing universal and project specific mySQL parameters
 *
 * This class is designed to lay the foundation of the unit tests per project. It loads the all the database
 * parameters about the project so that table specific tests can share the parameters in on place. To use it:
 *
 * 1. Rename the class from DataDesignTest to a project specific name (e.g., ProjectNameTest)
 * 2. Rename the namespace to be the same as in (e.g. Edu\Cnm\ProjectName\Test)
 * 3. Modify DataDesignTest::getDataSet() to include all the tables in your project.
 * 4. Modify DataDesignTest::getConnection() to include the correct mySQL properties file.
 * 5. Have all table specific tests include this class.
 *
 * *NOTE*: Tables must be added in the order they were created in step (2).
 *
 * @author  QED special thanks to @DeepDiveDylan
 **/
abstract class OurVibeTest extends TestCase {

    use TestCaseTrait;

    /**
     * invalid id to use for an INT UNSIGNED field (maximum allowed INT UNSIGNED in mySQL) + 1
     * @see https://dev.mysql.com/doc/refman/5.6/en/integer-types.html mySQL Integer Types
     * @var int INVALID_KEY
     **/
    const INVALID_KEY = 4294967296;

    /**
     * PHPUnit database connection interface
     * @var Connection $connection
     **/
    protected $connection = null;

    /**
     * assembles the table from the schema and provides it to PHPUnit
     *
     * @return QueryDataSet assembled schema for PHPUnit
     **/
    public final function getDataSet() {
        $dataset = new QueryDataSet($this->getConnection());

        // add all the tables for the project here
        // THESE TABLES *MUST* BE LISTED IN THE SAME ORDER THEY WERE CREATED!!!!
        $dataset->addTable("image");
        $dataset->addTable("venue");
        $dataset->addTable("event");
        $dataset->addTable("tag");
        $dataset->addTable("eventTag");
        $dataset->addTable("eventImage");
        return($dataset);
    }

    /**
     * templates the setUp method that runs before each test; this method expunges the database before each run
     *
     * @see https://phpunit.de/manual/current/en/fixtures.html#fixtures.more-setup-than-teardown PHPUnit Fixtures: setUp and tearDown
     * @see https://github.com/sebastianbergmann/dbunit/issues/37 TRUNCATE fails on tables which have foreign key constraints
     * @return Composite array containing delete and insert commands
     * These are required templetes
     **/
    public final function getSetUpOperation() {
        return new Composite([
            Factory::DELETE_ALL(),
            Factory::INSERT()
        ]);
    }

    /**
     * templates the tearDown method that runs after each test; this method expunges the database after each run
     *
     * @return Operation delete command for the database
     **/
    public final function getTearDownOperation() {
        return(Factory::DELETE_ALL());
    }

    /**
     * sets up the database connection and provides it to PHPUnit
     *
     * @see <https://phpunit.de/manual/current/en/database.html#database.configuration-of-a-phpunit-database-testcase>
     * @return Connection PHPUnit database connection interface
     **/
    public final function getConnection() {
        // if the connection hasn't been established, create it
        if($this->connection === null) {
            // connect to mySQL and provide the interface to PHPUnit
            $config = readConfig("/etc/apache2/capstone-mysql/ourvibe.ini");
            $pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/ourvibe.ini");
            $this->connection = $this->createDefaultDBConnection($pdo, $config["database"]);
        }
        return($this->connection);
    }

    /**
     * returns the actual PDO object; this is a convenience method
     *
     * @return \PDO active PDO object
     **/
    public final function getPDO() {
        return($this->getConnection()->getConnection());
    }
}