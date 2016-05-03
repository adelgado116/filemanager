<?php
/**
* @package SPLIB
* @version $Id: Validator.php,v 1.1 2003/12/12 08:06:02 kevin Exp $
*/
/**
* Validator base class for form validation
* @abstract
* @package SPLIB
*/
class Validator {
    /**
    * Stores validation error messages
    * @access private
    * @var array
    */
    var $errors;

    /**
    * Constucts a new Validator object
    * @param string text to validate
    */
    function Validator ($validateThis) {
        $this->errors=array();
        $this->validate($validateThis);
    }

    /**
    * Validation method for subclasses to provide
    * @param string text to validate
    * @access protected
    * @abstract
    * @return void
    */
    function validate($validateThis) {}

    /**
    * Adds an error message to the array
    * @return void
    * @access protected
    */
    function setError ($msg) {
        $this->errors[]=$msg;
    }

    /**
    * Returns true if string valid, false if not
    * @return boolean
    * @access public
    */
    function isValid () {
        if ( count ($this->errors) > 0 ) {
            return false;
        } else {
            return true;
        }
    }

    /**
    * Iterator for fetching error messages
    * @return mixed
    * @access public
    */
    function fetch () {
        $error = each ( $this->errors );
        if ( $error ) {
            return $error['value'];
        } else {
            reset($this->errors);
            return false;
        }
    }
}
?>