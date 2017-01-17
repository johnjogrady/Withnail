<?php
declare(strict_types=1);
use Itb\Product;
use Mattsmithdev\PdoCrud\DatabaseManager;
use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatatbaseUtility;
use PHPUnit_Framework_Assert as Assert;
// define DB constants
// ------------
define('DB_HOST', 'localhost');
define('DB_NAME', 'itb');
define('DB_USER', 'fred');
define('DB_PASS', 'smith');

class UpdateProductTest extends PHPUnit_Framework_TestCase

{
    // establish database connection using connection credentials defined in constants above
    public function getConnection()
    {
        $host = DB_HOST;
        $dbName = DB_NAME;
        $dbUser = DB_USER;
        $dbPass = DB_PASS;
        // mysql
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbName;
        $db = new \PDO($dsn, $dbUser, $dbPass);
        $connection = $this->createDefaultDBConnection($db, $dbName);
        return $connection;
    }

// this test tests creating a product in memory with id which mirrors the attributes of the same product instance
// in the database and checks that the two objects are the same

    public function testGetOneByIdExists()
    {
        // arrange
        $expected = new Product();
        $expected->setId('1');
        $expected->setDescription('Soundtrack (Vinyl)');
        $expected->setPrice('9');
        $expected->setStocklevel('25');
        $expected->setProductCategoryId('1');
        $expected->setImageUrl('../images/Withnail_soundtrack_cover_vinyl.jpg');

        // act
        $result = Product::getOneById(1);

        // assert
        $this->assertEquals($expected, $result);
    }

    // this test tests adding a single product then comparing against an XML file containing
    // the status of the test Product table prior to the insert
    // TO DO resolve object {product) to array type mismatch which is causing this test to fail
    public function testaddProductCheckExists()
    {
        // arrange
        $product = new Product();
        $product->setId('999');
        $product->setDescription('X');
        $product->setPrice('10');
        $product->setStocklevel('25');
        $product->setProductCategoryId('1');
        $product->setImageUrl('../images/Withnail_soundtrack_cover_vinyl.jpg');
        // create variable containing expected dataset (from XML)
        $dataFilePath = __DIR__ . '/databaseXml/expectedProductsWithX.xml';
        $expectedTable = $this->createXMLDataSet($dataFilePath)
            ->getTable('products');

        // act
        // add item to table in our test DB
        Product::insert($product);

        // retrieve dataset from our test DB
        //
        $productsInDatabaseAfterInsert = (array)Product::getAll();


        // assert
        Assert::assertEquals($expectedTable, $productsInDatabaseAfterInsert);

    }
    // TO DO resolve type mismatch OBject:

// this test tests that calling the getOneById result with the id of a product instance which does not exist returns NULL
    public function testGetOneByIdNoProductExistsForGivenId()
    {
        // arrange

        // act
        $result = Product::getOneById(9999);

        // assert
        $this->assertNull($result);
    }

    // utility functions
    protected function createXMLDataSet($xmlFile){

        return new PHPUnit_Extensions_Database_DataSet_XmlDataSet($xmlFile);
    }

    protected function createDefaultDBConnection(PDO $connection, $schema = '')
    {
        return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($connection, $schema);
    }


}