<?php
/**
 * Table Definition for user2collection
 */
require_once 'DB/DataObject.php';

class DataObject_User2collection extends DB_DataObject 
{

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'user2collection';                 // table name
    var $user_id;                         // int(11)  not_null primary_key
    var $collection_id;                   // int(11)  not_null primary_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObject_User2collection',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>