<?php
/**
* @package SPLIB
* @version $Id: ValidateEmail.php,v 1.1 2003/12/12 08:06:02 kevin Exp $
*/
/**
* Include the base validator class
*/
require_once 'Validators/Validator.php';
/**
* Validates an email address
* <code>
* $validator = new ValidEmail('jbloggs@yahoo.com');
* if ( ! $validator->isValid() ) {
*   while ( $error = $validator->fetch() ) {
*       echo ( $error.'<br />' );
*   }
* }
* </code>
* @access public
* @package SPLIB
*/
class ValidateEmail extends Validator {
    /**
    * Validates an email address
    * Note that the regular expression used here will not allow certain validate
    * email addresses, such as someone@195.11.25.34:25
    * @param string email address to validate
    * @access protected
    * @return void
    */
    function validate($email) {
        $pattern='/^[a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i';
        if(!preg_match($pattern,$email)){
            $this->setError('Invalid email address');
        }
        if (strlen($email)>100){
            $this->setError('Address is too long');
        }
    }
}
?>