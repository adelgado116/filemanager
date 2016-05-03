<?php
/**
* @package SPLIB
* @version $Id: StructIterator.php,v 1.1 2003/12/12 08:06:06 kevin Exp $
*/
/**
* StructIterator<br />
* SimpleIterator for iterating through structs (arrays of arrays
* or arrays of objects)
* @package SPLIB
* @access public
*/
class StructIterator /* implements SimpleIterator */ {
    /**
    * Struct to iterate over
    * @access private
    * @var array
    */
    var $struct;

    /**
    * StructIterator Constructor
    * @param array struct to iterate over
    * @access public
    */
    function StructIterator ($struct) {
        $this->struct = $struct;
    }

    /**
    * Iterator method which returns content from the file
    * @return mixed either struct element or false when finished
    * @access public
    */
    function fetch() {
        $element = each ( $this->struct );
        if ( $element ) {
            return $element['value'];
        } else {
            reset ( $this->struct );
            return false;
        }
    }
}
?>