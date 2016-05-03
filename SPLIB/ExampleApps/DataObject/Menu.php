<?php
/**
 * Table Definition for menu
 */
require_once 'DB/DataObject.php';

class DataObject_Menu extends DB_DataObject 
{

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'menu';                            // table name
    var $menu_id;                         // int(11)  not_null primary_key auto_increment
    var $parent_id;                       // int(11)  not_null
    var $name;                            // string(255)  not_null
    var $description;                     // blob(65535)  not_null blob
    var $location;                        // string(255)  not_null unique_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObject_Menu',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>