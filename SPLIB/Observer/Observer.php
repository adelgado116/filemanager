<?php
/**
* @package SPLIB
* @version $Id: Observer.php,v 1.1 2003/12/12 08:06:05 kevin Exp $
*/
/**
* Base Observer class
* @abstract
* @package SPLIB
*/
class Observer {
    /**
    * Abstract function implemented by children to repond to
    * to changes in Observable subject
    * @abstract
    * @return void
    * @access public
    */
    function update(&$source,$arg) {}
}
?>