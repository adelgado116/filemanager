<?php
/**
* @package SPLIB
* @version $Id: SimpleIterator.php,v 1.1 2003/12/12 08:06:06 kevin Exp $
*/
/**
* SimpleIterator<br />
* Interface for Iterators to implement
* @package SPLIB
* @access public
*/
class SimpleIterator {
    /**
    * Iterator method which returns collection elements
    * or false when done.<br />Should reset the collection automatically
    * when finished
    * @return mixed either collection element or false when finished
    * @access public
    */
    function fetch() {}
}
?>