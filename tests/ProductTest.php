<?php
declare(strict_types=1);
use Itb\Product;
use Mattsmithdev\PdoCrud\DatabaseManager;
use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatatbaseUtility;
// define DB constants
// ------------
define('DB_HOST', 'localhost');
define('DB_NAME', 'itb');
define('DB_USER', 'fred');
define('DB_PASS', 'smith');

class UpdateProductTest extends PHPUnit_Framework_TestCase

{

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

    public function testupdateProduct($productId, $newDescription, $expectedResult)
    {
        // Arrange
        $product = Product::getOneProductById($productId);
        $product->getDescription();

        //Act
        $result = $product->setDescription($newDescription);
        $expectedResult='new description';
        // Assert
        $this->assertEquals($result, $expectedResult);

    }
    public function updateProductTester()
    {
        return array(
            array(1, 'new description','new description'));
    }

    public function testGetOneByIdExists()
    {
        // arrange
        $expected = new Product();
        $expected->setId(1);
        $expected->setDescription('Soundtrack (Vinyl)');
        $expected->setPrice(9);
        $expected->setStocklevel(25);
        $expected->setProductCategoryId(1);
        $expected->setImageUrl('../images/Withnail_soundtrack_cover_vinyl.jpg');

        // act
        $result = Product::getOneById(1);

        // assert
        $this->assertEquals($expected, $result);
    }

    public function testNumRowsFromSeedData()
    {
        // arrange
        $numRowsAtStart = 6;
        $expectedResult = $numRowsAtStart;

        // act

        // assert
        $this->assertEquals($expectedResult, $this->getConnection()->getRowCount('products'));
    }



}