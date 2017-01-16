<?php
/**
 * Class Category | core/UserRepository.php
 *
 * @version     v.1.0 (06/01/2016)
 * @Author John O'Grady
 *
 */
namespace Itb;

/**
 * User repository for User class to write and read from database
 * No longer actively in use
 * Retained for now [in case it breaks something at the last minute!]
 */

class UserRepository
{
    /**
     * Empty array of users
     */
    private $users = [];

    /**
     * Constructor for users used by Matt to seed database initially
     */
    public function __construct() {
        $matt = new User();
        $matt->setId(1);
        $matt->setUsername('matt');
        $matt->setPassword('smith');
        $matt->setRole(User::ROLE_USER);


        $admin = new User();
        $admin->setId(2);
        $admin->setUsername('admin');
        $admin->setPassword('admin');

        // add users to the array
        $this->users[1] = $matt;
        $this->users[2] = $admin;
    }

    /**
     * retrieve all users in the database
     * returns an array of user objects
     */
    public function getAll() {
        return $this->users;
    }
    public function getOneById($id) {
        if($id == 1 || $id == 2){		// hard coded for just 2 records for now ...
            return $this->users[$id];
        } else {
            return null;
        }
    }

    /**
     * retrieve a single user passing in usernanme
     * returns a single user object
     */
    public function getOneByUsername($username) {
        foreach ($this->users as $user){
            if($user->getUsername() == $username){
                return $user;
            }
        }
        return null; 		// if we get this far, then we didn’t find a matching record
    }

    /**
     * Helper method to check if user provided a valid username and password which can be matched to the database
     */
    public static function canFindMatchingUsernameAndPassword($username, $password)
    {
        $user = User::getOneByUsername($username);

        // if no record has this username, return FALSE
        if(null == $user){
            return false;
        }

        // hashed correct password
        $hashedStoredPassword = $user->getPassword();

        // return whether or not hash of input password matches stored hash
        return password_verify($password, $hashedStoredPassword);
    }


}