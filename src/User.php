<?php
/**
 * Class Category | core/User.php
 *
 * @version     v.1.0 (06/01/2016)
 * @Author John O'Grady
 *
 */
namespace Itb;

use Mattsmithdev\PdoCrud\DatabaseTable;
use Mattsmithdev\PdoCrud\DatabaseManager;
/**
 * User object represents a customer of the website
 */
class User extends DatabaseTable


{
    /**
     * Database User roles- not yet actively in use!
     */
    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

    /**
     * Integer ID which represents user in database, auto incremented
     */
    private $Id;

    /**
     * get id for user
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * set id for user
     * @param mixed $Id
     */
    public function setId($Id)
    {
        $this->Id = $Id;
    }

    /**
     * String representing Username for user
     *
     */
    private $username;

    /**
     * get username for User
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * set username for USer
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Int representing role references role constants noted above- not yet in active use
     */
    private $role;

    /**
     * get role attribute for user
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * set role attribute for user
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * String representing firstname of user
     */
    private $firstName;

    /**
     * get firstname of user
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * set firstname of user
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * String representing last name of user
     * @param String
     */
    private $lastName ;

    /**
     * get last name
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * set lastname
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Strings representing address of user
     * @param String
     */
    private $customerAddress1;

    /**
     * get address
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
     * get address
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
     * get address
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

    /**
     * String representing County in which user resides
     */
    private $county;

    /**
     * get county
     * @return mixed
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * set county
     * @param mixed $county
     */
    public function setCounty($county)
    {
        $this->county = $county;
    }

    /**
     * String representing email for user
     * @param String
     */
    private $email;

    /**
     * get email
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * set email
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * String representing mobile number for user
     * @param String
     */
    private $mobileNumber ;

    /**
     * get mobile
     * @return mixed
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    /**
     * set mobile
     * @param mixed $mobileNumber
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * String representing password for user
     * Stored as hashed in the database
     */
    private $password;

    /**
     * password for user
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

    /**
     * chosen avatar for user
     * @return mixed
     */
    private $avatar;

    /**
     * get avatar
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * set avatar
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }
    /**
     * chosen avatar for user- text string
     */

    public static function getOneByUsername($username) {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * FROM users WHERE username=:username';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $username, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS,'\\Itb\\User');
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
            var_dump($object);
        } else {
            return null;
        }
    }

}