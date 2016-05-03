<?php
/**
* @package SPLIB
* @version $Id: ValidateUser.php,v 1.1 2003/12/12 08:06:02 kevin Exp $
*/
/**
* Include the base validator class
*/
require_once 'Validators/Validator.php';
/**
* Validates a User Name
* <code>
* $validator = new ValidUser('jbloggs');
* if ( ! $validator->isValid() ) {
*   while ( $error = $validator->fetch() ) {
*       echo ( $error.'<br />' );
*   }
* }
* </code>
* @access public
* @package SPLIB
*/
class ValidateUser extends Validator {
    /**
    * Validates a username
    * @param string username to validate
    * @access protected
    * @return void
    */
    function validate($user) {
        if (!preg_match('/^[a-zA-Z0-9_]+$/',$user )) {
            $this->setError('Username contains invalid characters');
        }
        if (strlen($user) < 6 ) {
            $this->setError('Username is too short');
        }
        if (strlen($user) > 20 ) {
            $this->setError('Username is too long');
        }
    }
}
?>