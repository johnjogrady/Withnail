<?php

namespace Itb;


class MovieRepository
{
    public function getConnection()
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

    public function getAll()
    {
        $connection = $this->getConnection();

        // SQL query
        $sql = 'SELECT * FROM movies';

        // execute query and collect results
        $statement= $connection->query($sql);
        $movies = $statement->fetchAll();


        return $movies;
    }

    function get_one_product($connection, $id)
    {

        $sql = "SELECT * FROM products WHERE id=$id";
        $statement = $connection->query($sql);

        if ($row = $statement->fetch()) {
            return $row;
        } else {
            return null;
        }
    }


}