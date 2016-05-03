<?php
/**
* @package SPLIB
* @version $Id: ValidatePassword.php,v 1.1 2003/12/12 08:06:02 kevin Exp $
*/
/**
* Include the base validator class
*/
require_once 'Validators/Validator.php';
/**
* Validates a Password
* <code>
* $passwords = array('secret','secret');
* $validator = new ValidPassword($passwords);
* if ( ! $validator->isValid() ) {
*   while ( $error = $validator->fetch() ) {
*       echo ( $error.'<br />' );
*   }
* }
* </code>
* @access public
* @package SPLIB
*/
class ValidatePassword extends Validator {
    /**
    * Validates a password
    * @param array of structure ($password,$confirm)
    * @access protected
    * @return void
    */
    function validate($passwords) {
        $pass = $passwords[0];
        $conf = $passwords[1];
        if ($pass != $conf) {
            $this->setError('Passwords do not match');
        }
        if (!preg_match('/^[a-zA-Z0-9_]+$/',$pass )) {
            $this->setError('Password contains invalid characters');
        }
        if (strlen($pass) < 6 ) {
            $this->setError('Password is too short');
        }
        if (strlen($pass) > 20 ) {
            $this->setError('Password is too long');
        }
    }
}
?>