<?php
/**
 * Table Definition for signup
 */
require_once 'DB/DataObject.php';

class DataObject_Signup extends DB_DataObject 
{

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'signup';                          // table name
    var $signup_id;                       // int(11)  not_null primary_key auto_increment
    var $login;                           // string(50)  not_null unique_key
    var $password;                        // string(50)  not_null
    var $email;                           // string(50)  multiple_key
    var $firstName;                       // string(50)  
    var $lastName;                        // string(50)  
    var $signature;                       // blob(65535)  not_null blob
    var $confirm_code;                    // string(40)  not_null unique_key
    var $created;                         // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObject_Signup',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>