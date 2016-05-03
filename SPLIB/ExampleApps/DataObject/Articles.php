<?php
/**
 * Table Definition for articles
 */
require_once 'DB/DataObject.php';

class DataObject_Articles extends DB_DataObject 
{

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'articles';                        // table name
    var $article_id;                      // int(11)  not_null primary_key auto_increment
    var $title;                           // string(255)  not_null multiple_key
    var $intro;                           // blob(65535)  not_null blob
    var $body;                            // blob(65535)  not_null blob
    var $author;                          // string(255)  not_null
    var $published;                       // string(11)  
    var $public;                          // string(1)  not_null enum

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObject_Articles',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>