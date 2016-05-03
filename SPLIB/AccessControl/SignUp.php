<?php
/**
* @package SPLIB
* @version $Id: SignUp.php,v 1.2 2005/09/05 05:46:34 kevin Exp $
*/
/**
* Define constants for table
*/
# Modify these constants to match your user login and signup tables
// Name of users table
@define ( 'USER_TABLE','user');
// Name of signup table
@define ( 'SIGNUP_TABLE','signup');
// Name of login column in table
@define ( 'USER_TABLE_LOGIN','login');
// Name of password column in table
@define ( 'USER_TABLE_PASSW','password');
// Name of email column in table
@define ( 'USER_TABLE_EMAIL','email');
// Name of firstname column in table
@define ( 'USER_TABLE_FIRST','firstName');
// Name of lastname column in table
@define ( 'USER_TABLE_LAST','lastName');
// Name of signature column in table
@define ( 'USER_TABLE_SIGN','signature');
// Name of ID column in signup
@define ( 'SIGNUP_TABLE_ID','signup_id');
// Name of confirm_code column in signup
@define ( 'SIGNUP_TABLE_CONFIRM','confirm_code');
// Name of created column in signup
@define ( 'SIGNUP_TABLE_CREATED','created');
/**
* SignUp Class<br />
* Provides functionality for for user sign up<br />
* <b>Note:</b> you will need to modify the createSignup() method if you
* are using a different database table structure<br />
* <b>Note:</b> this class requires
* @link http://phpmailer.sourceforge.net/ PHPMailer
* @access public
* @package SPLIB
*/
class SignUp {
    /**
    * Database connection
    * @access private
    * @var object
    */
    var $db;

    /**
    * The name / address the signup email should be sent from
    * @access private
    * @var array
    */
    var $from;

    /**
    * The name / address the signup email should be sent to
    * @access private
    * @var array
    */
    var $to;

    /**
    * The subject of the confirmation email
    * @access private
    * @var string
    */
    var $subject;

    /**
    * Text of message to send with confirmation email
    *
    * @var string
    */
    var $message;

    /**
    * Whether to send HTML email or not
    * @access private
    * @var boolean
    */
    var $html;

    /**
    * Url to use for confirmation
    * @access private
    * @var string
    */
    var $listener;

    /**
    * Confirmation code to append to $this->listener
    * @access private
    * @var string
    */
    var $confirmCode;

    /**
    * SignUp constructor
    * @param object instance of database connection
    * @param string URL for confirming the the signup
    * @param string name for confirmation email ("Your name")
    * @param string address for confirmation email ("you@yoursite.com")
    * @param string subject of the confirmation message
    * @param string the confirmation message containing <confirm_url/>
    & @access public
    */
    function SignUp (&$db,$listener,$frmName,$frmAddress,$subj,$msg,$html) {
        $this->db=&$db;
        $this->listener=$listener;
        $this->from[$frmName]=$frmAddress;
        $this->subject=$subj;
        $this->message=$msg;
        $this->html=$html;
    }

    /**
    * Creates a random string to be used in images
    * @return string
    * @access public
    */
    function createRandString () {
        srand((double)microtime()*1000000); 
        $letters=range ('A','Z');
        $numbers=range(0,9);
        $chars=array_merge($letters,$numbers);
        $randString='';
        for ( $i=0;$i<8;$i++ ) {
            shuffle($chars);
            $randString.=$chars[0];
        }
        return $randString;
    }

    /**
    * Creates the confirmation code
    * @return void
    * @access private
    */
    function createCode ($login) {
        srand((double)microtime()*1000000); 
        $this->confirmCode=md5($login.time().rand(1,1000000));
    }

    /**
    * Inserts a record into the signup table
    * @param array contains user details. See constants defined for array keys
    * @return boolean true on success
    * @access public
    */
    function createSignup ($userDetails) {
        $login=mysql_escape_string($userDetails[USER_TABLE_LOGIN]);
        $password=mysql_escape_string($userDetails[USER_TABLE_PASSW]);
        $email=mysql_escape_string($userDetails[USER_TABLE_EMAIL]);
        $firstName=mysql_escape_string($userDetails[USER_TABLE_FIRST]);
        $lastName=mysql_escape_string($userDetails[USER_TABLE_LAST]);
        $signature=mysql_escape_string($userDetails[USER_TABLE_SIGN]);

        // First check login and email are unique in user table
        $sql = "SELECT * FROM
                   ".USER_TABLE."
                WHERE
                   ".USER_TABLE_LOGIN."='".$login."'
                OR
                   ".USER_TABLE_EMAIL."='".$email."'";
        $result = $this->db->query($sql);

        if ( $result->size() > 0 ) {
            trigger_error('Unique username and email address required');
            return false;
        }

        $this->createCode($login);
        $toName=$firstName.' '.$lastName;
        $this->to[$toName]=$email;

        $sql="INSERT INTO ".SIGNUP_TABLE." SET
                ".USER_TABLE_LOGIN."='".$login."',
                ".USER_TABLE_PASSW."='".$password."',
                ".USER_TABLE_EMAIL."='".$email."',
                ".USER_TABLE_FIRST."='".$firstName."',
                ".USER_TABLE_LAST."='".$lastName."',
                ".USER_TABLE_SIGN."='".$signature."',
                ".SIGNUP_TABLE_CONFIRM."='".$this->confirmCode."',
                ".SIGNUP_TABLE_CREATED."='".time()."'";

        $result=$this->db->query($sql);

        if ( $result->isError() )
            return false;
        else
            return true;
    }

    /**
    * Sends the confirmation email
    * @return boolean true on success
    * @access public
    */
    function sendConfirmation () {
        $mail = new phpmailer();
        $from=each($this->from);
        $mail->FromName = $from[0];
        $mail->From = $from[1];
        $to=each($this->to);
        $mail->AddAddress($to[1],$to[0]);
        $mail->Subject= $this->subject;
        if ( $this->html ) {
            $replace='<a href="'.$this->listener.'?code='.
                     $this->confirmCode.'">'.$this->listener.'?code='.
                     $this->confirmCode.'</a>';
        } else {
            $replace=$this->listener.'?code='.$this->confirmCode;
        }
        $this->message=str_replace('<confirm_url/>',
                                   $replace,
                                   $this->message);
        $mail->IsHTML($this->html);

        $mail->Body = $this->message;
        if ( $mail->send() )
            return TRUE;
        else
            return FALSE;
    }

    /**
    * Confirms a signup against the confirmation code. If it
    * matches, copies the row to the user table and deletes
    * the row from signup
    * @return boolean true on success
    * @access public
    */
    function confirm ($confirmCode) {
        $confirmCode = mysql_escape_string($confirmCode);
        $sql="SELECT *
              FROM
                  ".SIGNUP_TABLE."
              WHERE
                  ".SIGNUP_TABLE_CONFIRM."='".$confirmCode."'";
        $result=$this->db->query($sql);
        if ( $result->size() == 1 ) {
            $row=$result->fetch();

            // Copy the data from Signup to User table
            $sql="INSERT INTO ".USER_TABLE." SET
                    ".USER_TABLE_LOGIN."='".mysql_escape_string($row[USER_TABLE_LOGIN])."',
                    ".USER_TABLE_PASSW."='".mysql_escape_string($row[USER_TABLE_PASSW])."',
                    ".USER_TABLE_EMAIL."='".mysql_escape_string($row[USER_TABLE_EMAIL])."',
                    ".USER_TABLE_FIRST."='".mysql_escape_string($row[USER_TABLE_FIRST])."',
                    ".USER_TABLE_LAST."='".mysql_escape_string($row[USER_TABLE_LAST])."',
                    ".USER_TABLE_SIGN."='".mysql_escape_string($row[USER_TABLE_SIGN])."'";
            
            $result=$this->db->query($sql);
            if ( $result->isError() ) {
               return FALSE;
            } else {
                // Delete row from signup table
                $sql="DELETE FROM ".SIGNUP_TABLE." WHERE ".SIGNUP_TABLE_ID."='".
                        $row[SIGNUP_TABLE_ID]."'";
                $this->db->query($sql);
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }
}
?>