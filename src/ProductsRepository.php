<?php
/**
 * Class Category | core/ProductsRepository.php
 *
 * @version     v.1.0 (06/01/2016)
 * @Author John O'Grady
 *
 */
namespace Itb;

/**
 * Database utility functions for writing and reading data into the Database, uses Matt Smith DEv pdo crud for free
 */
class ProductsRepository
{
    /**
     * Open database connection
     */public function getConnection()
    {
        // DSN - the Data Source Name - requred by the PDO to connect
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;

        // attempt to create a connection to the database
        try {
            $connection = new \PDO($dsn, DB_USER, DB_PASS);
        } catch (\PDOException $e) {
            // deal with connection error
            print 'ERROR - there was a problem trying to create DB connection' . PHP_EOL;
            return null;
        }

        return $connection;
    }
    /**
     * retrieve all products
     * returns an array of product objects
     */
    public function getAll()
    {
        $connection = $this->getConnection();

        // SQL query
        $sql = 'SELECT ProductID,Description,Price, StockLevel,Image_Path, CategoryDescription
 FROM products as p JOIN productcategories as pc ON pc.ProductCategoryId= p.ProductCategoryId';

        // execute query and collect results
        $statement= $connection->query($sql);
        $statement->setFetchMode(\PDO::FETCH_CLASS, '\\Itb\\Product');

        $products = $statement->fetchAll();

        return $products;
    }
    /**
     * Get a single product by ID
     * returns a single product object
     */
    public function get_one_product($id)
    {
        $connection = $this->getConnection();
        $sql = "SELECT ProductID,Description,Price, StockLevel,Image_Path, CategoryDescription
 FROM products as p JOIN productcategories as pc ON pc.ProductCategoryId= p.ProductCategoryId
 WHERE Productid=$id 
";
        $statement= $connection->query($sql);
        $statement->setFetchMode(\PDO::FETCH_CLASS, '\\Itb\\Product');
        $products = $statement->fetchAll();
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();


        if ($row = $statement->fetch()) {
            return $row;
        } else {
            return null;
        }

    }

    /**
     * Retrieve all categories
     */
    public function getCategories()
    {
        $connection = $this->getConnection();

        // SQL query
        $sql = 'SELECT * from productcategories as pc ';

        // execute query and collect results
        $statement= $connection->query($sql);
        $categories = $statement->fetchAll();


        return $categories;
    }

    /**
     * Delete a single product passing its id
     */
    function delete_product($connection, $id)
    {
        $sql = "DELETE FROM products WHERE ProductID=$id";

        $numRowsAffected = $connection->exec($sql);

        if($numRowsAffected > 0){
            $queryWasSuccessful = true;
        } else {
            $queryWasSuccessful = false;
        }

        return $queryWasSuccessful;
    }

    /**
     * create a single new product and populate its initial state into the database
     */
    function create_product($connection, $description, $price, $stockLevel,$categoryId)
    {
        $sql = "INSERT into products (description, price, stocklevel,ProductCategoryId) VALUES ('$description', $price, $stockLevel,$categoryId)";

        $numRowsAffected = $connection->exec($sql);

        if($numRowsAffected > 0){
            $queryWasSuccessful = true;
        } else {
            $queryWasSuccessful = false;
        }

        return $queryWasSuccessful;
    }
    /**
     * update a single product and populate its new state into the database
     * references product by id
     */

    function update_product($connection, $id, $description, $price, $stock)
    {
        $sql = "UPDATE products SET description = '$description', price = '$price', stocklevel = '$stock' 
    WHERE ProductID=$id";

        $numRowsAffected = $connection->exec($sql);

        if($numRowsAffected > 0){
            $queryWasSuccessful = true;
        } else {
            $queryWasSuccessful = false;
        }
        return $queryWasSuccessful;
    }

    /**
     * create a new customer and populate its initial state into the database
     */
    function create_customer($connection, $firstName,$lastName, $customerAddress1, $customerAddress2, $customerAddress3, $county, $mobileNumber, $email, $password)
    {
        $emailFound=$this->checkEmailInDB($email);
        if (!$emailFound)
        {
        $sql = "INSERT into customers(FirstName, LastName, CustomerAddress1, CustomerAddress2, CustomerAddress3, County, MobileNumber, Email, Password) VALUES ('$firstName','$lastName', '$customerAddress1', '$customerAddress2', '$customerAddress3', '$county', '$mobileNumber', '$email', '$password')";

         $numRowsAffected = $connection->exec($sql);

        if($numRowsAffected > 0){
            $queryWasSuccessful = true;
        } else {
            $queryWasSuccessful = false;
        }

        return $queryWasSuccessful;
        }
    }

    /**
     * check if an email for a newly registering customer already exists in the database
     */
    function checkEmailInDB($email)
    {
        $connection = $this->getConnection();
        $sql = "select count(*) from customers WHERE `email` = '$email'";
        $result = $connection->prepare($sql);
        $result->execute();
        $numrows = $result->fetchColumn();
        if ($numrows>0)
        {
            return true;
        }
        else {return false;}
    }





}