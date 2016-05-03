<?php
/**
 * Table Definition for collection2permission
 */
require_once 'DB/DataObject.php';

class DataObject_Collection2permission extends DB_DataObject 
{

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'collection2permission';           // table name
    var $collection_id;                   // int(11)  not_null primary_key
    var $permission_id;                   // int(11)  not_null primary_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObject_Collection2permission',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>