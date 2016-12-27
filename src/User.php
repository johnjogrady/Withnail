<?php
/**
 * Created by PhpStorm.
 * User: john.ogrady
 * Date: 20/12/2016
 * Time: 20:28
 */

namespace Itb;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;

class User extends DatabaseTable


{

    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

    private $Id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setId($Id)
    {
        $this->Id = $Id;
    }


    private $username;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }


    private $role;

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }


    private $firstName;

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    private $lastName ;

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    private $customerAddress1;

    /**
     * @return mixed
     */
    public function getCustomerAddress1()
    {
        return $this->customerAddress1;
    }

    /**
     * @param mixed $customerAddress1
     */
    public function setCustomerAddress1($customerAddress1)
    {
        $this->customerAddress1 = $customerAddress1;
    }
    private $customerAddress2;

    /**
     * @return mixed
     */
    public function getCustomerAddress2()
    {
        return $this->customerAddress2;
    }

    /**
     * @param mixed $customerAddress2
     */
    public function setCustomerAddress2($customerAddress2)
    {
        $this->customerAddress2 = $customerAddress2;
    }
    private $customerAddress3;

    /**
     * @return mixed
     */
    public function getCustomerAddress3()
    {
        return $this->customerAddress3;
    }

    /**
     * @param mixed $customerAddress3
     */
    public function setCustomerAddress3($customerAddress3)
    {
        $this->customerAddress3 = $customerAddress3;
    }
    private $county;

    /**
     * @return mixed
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @param mixed $county
     */
    public function setCounty($county)
    {
        $this->county = $county;
    }
    private $email;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    private $mobileNumber ;

    /**
     * @return mixed
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    /**
     * @param mixed $mobileNumber
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }
    private $password;

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * hash the password before storing ...
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->password = $hashedPassword;
    }


    private $numOrders;

    /**
     * @return mixed
     */
    public function getNumOrders()
    {
        return $this->numOrders;
    }

    /**
     * @param mixed $numOrders
     */
    public function setNumOrders($numOrders)
    {
        $this->numOrders = $numOrders;
    }
    private $spendToDate;

    /**
     * @return mixed
     */
    public function getSpendToDate()
    {
        return $this->spendToDate;
    }

    /**
     * @param mixed $spendToDate
     */
    public function setSpendToDate($spendToDate)
    {
        $this->spendToDate = $spendToDate;
    }

    /**
     * hash the password before storing ...
     * @param mixed $password
     */

    public static function getOneByUsername($username) {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM users WHERE username=:username';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }

}