<?php
/**
* @package SPLIB
* @version $Id: User.php,v 1.1 2003/12/12 08:06:07 kevin Exp $
*/
/**
* Constants defining table and column names
*/
# Modify this constants to match the session variable names
// Name to use for login variable
@define ( 'USER_LOGIN_VAR','login');

# Modify these constants to match your user login table
// Name of users table
@define ( 'USER_TABLE','user');
// Name of ID column in usre
@define ( 'USER_TABLE_ID','user_id');
// Name of login column in table
@define ( 'USER_TABLE_LOGIN','login');
// Name of email column in table
@define ( 'USER_TABLE_EMAIL','email');
// Name of firstname column in table
@define ( 'USER_TABLE_FIRST','firstName');
// Name of lastname column in table
@define ( 'USER_TABLE_LAST','lastName');
// Name of signature column in table
@define ( 'USER_TABLE_SIGN','signature');

// Name of Permission table
@define ( 'PERM_TABLE','permission');
// Permission table id column
@define ( 'PERM_TABLE_ID','permission_id');
// Permission table name column
@define ( 'PERM_TABLE_NAME','name');

// Name of Permission table
@define ( 'PERM_TABLE','permission');
// Permission table id column
@define ( 'PERM_TABLE_ID','permission_id');
// Permission table name column
@define ( 'PERM_TABLE_NAME','name');

// Name of User to Collection lookup table
@define ( 'USER2COLL_TABLE','user2collection');
// User to Collection table user_id column
@define ( 'USER2COLL_TABLE_USER_ID','user_id');
// User to Collection table collection_id column
@define ( 'USER2COLL_TABLE_COLL_ID','collection_id');

// Name of Collection to Permission lookup table
@define ( 'COLL2PERM_TABLE','collection2permission');
// Collection to Permission table collection id
@define ( 'COLL2PERM_TABLE_COLL_ID','collection_id');
// Collection to Permission table permission id
@define ( 'COLL2PERM_TABLE_PERM_ID','permission_id');
/**
* User Class<br />
* Used to store information about users, such as permissions
* based on the session variable "login"<br />
* <b>Note:</b> you will need to modify the populate() and 
* checkPermission() methods if you database table structure
* is different to that used here.
* @access public
* @package SPLIB
*/
class User {
    /**
    * Database connection
    * @access private
    * @var  object
    */
    var $db;
    /**
    * The id which identifies this user
    * @access private
    * @var int
    */
    var $userId;
    /**
    * The users email
    * @access private
    * @var string
    */
    var $email;
    /**
    * First Name
    * @access private
    * @var string
    */
    var $firstName;
    /**
    * Last Name
    * @access private
    * @var string
    */
    var $lastName;
    /**
    * Signature
    * @access private
    * @var string
    */
    var $signature;
    /**
    * Permissions
    * @access private
    * @var array
    */
    var $permissions;
    /**
    * User constructor
    * @param object instance of database connection
    * @access public
    */
    function User (&$db) {
        $this->db=& $db;
        $this->populate();
    }
    /**
    * Determines the user's id from the login session variable
    * @return void
    * @access private
    */
    function populate() {
        $session=new Session();
        $sql="SELECT
                  ".USER_TABLE_ID.", ".USER_TABLE_EMAIL.", 
                  ".USER_TABLE_FIRST.", ".USER_TABLE_LAST.",
                  ".USER_TABLE_SIGN."
              FROM
                  ".USER_TABLE."
              WHERE
                  ".USER_TABLE_LOGIN."='".$session->get(USER_LOGIN_VAR)."'";
        $result=$this->db->query($sql);
        $row=$result->fetch();
        $this->userId=$row[USER_TABLE_ID];
        $this->email=$row[USER_TABLE_EMAIL];
        $this->firstName=$row[USER_TABLE_FIRST];
        $this->lastName=$row[USER_TABLE_LAST];
        $this->signature=$row[USER_TABLE_SIGN];
    }
    /**
    * Returns the users id
    * @return int
    * @access public
    */
    function id() {
        return $this->userId;
    }
    /**
    * Returns the users email
    * @return int
    * @access public
    */
    function email() {
        return $this->email;
    }
    /**
    * Returns the users first name
    * @return string
    * @access public
    */
    function firstName() {
        return $this->firstName;
    }
    /**
    * Returns the users last name
    * @return string
    * @access public
    */
    function lastName() {
        return $this->lastName;
    }
    /**
    * Returns the users signature
    * @return string
    * @access public
    */
    function signature() {
        return $this->signature;
    }
    /**
    * Checks to see if the user has the named permission
    * @param string name of a permission
    * @return boolean TRUE is user has permission
    * @access public
    */
    function checkPermission($permission) {
        // If I don't have any permissions, fetch them
        if ( !isset($this->permissions) ) {
            $this->permissions = array();
            $sql="SELECT
                      p.".PERM_TABLE_NAME." as permission
                  FROM
                      ".USER2COLL_TABLE." uc, ".COLL2PERM_TABLE.
                      " cp, ".PERM_TABLE." p
                  WHERE
                      uc.".USER2COLL_TABLE_USER_ID."='".$this->userId."'
                  AND
                      uc.".USER2COLL_TABLE_COLL_ID.
                         " = cp.".COLL2PERM_TABLE_COLL_ID."
                  AND
                      cp.".COLL2PERM_TABLE_PERM_ID." = p.".PERM_TABLE_ID;
            $result=$this->db->query($sql);
            while ( $row=$result->fetch() ) {
                $this->permissions[]=$row['permission'];
            }
        }
        if ( in_array($permission,$this->permissions) )
            return true;
        else
            return false;
    }
}
?>