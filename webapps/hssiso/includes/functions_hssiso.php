<?php
///// AADV.  July, 2007 ///////////////////
// checkbox validator /////////////////////
function chboxValid( $chboxId,          // checkbox identificator
                     $chboxRightVal     // right value to make a comparison
				   )
{
  if ( isset($chboxId) ) {
    // A value was submitted and it's the right one
	if ( $chboxId == $chboxRightVal) {
      $status = 1;
    } else {
	  // A value was submitted and it's the wrong one
	  $status = 0;
	  print 'Invalid checkbox value submitted.';
	}
  } else {
    // No value was submitted
	$status = 0;
  }
  
  return $status;
}

/********************************************************************
 * is_alphanum()
 * Author(s): AADV.
 * 
 * Revision History:
 *   Creation Date: 03/17/07, 14:31.
 *     notes: .
 *   Last Revision: .
 *     notes: .
 * 
 * Description: this function validates data .
 * Arguments: string.
 * Returns: (0) if ok, (-1) if not ok.
 * 
 * (c)2007, AADV.
 *******************************************************************/
function is_alphanum(
                      $data_str  // string to validate
                    )
{
  if (strlen($data_str) < 6)
	return -1;
  
  if ( !ereg("[a-zA-Z0-9]", $data_str) )
	return -1;
	
  return 0;
}

#  is_alphanum_enh  -- ENHANCED VERSION INCLUDING STRING SIZE
#
function is_alphanum_enh(
                      $data_str,  // string to validate
					  $strlen
                    )
{
  if (strlen($data_str) > $strlen)
	return -1;
  
  if ( !ereg("[a-zA-Z0-9]", $data_str) )
	return -1;
	
  return 0;
}

function check_str_size(
                      $data_str  // string to validate
                    )
{
  if (strlen($data_str) < 6)
	return -1;

  return 0;
}


/********************************************************************
 * is_email()
 * Author(s): AADV.
 * 
 * Revision History:
 *   Creation Date: 27082010, 22:45.
 *     notes: .
 *   Last Revision: .
 *     notes: .
 * 
 * Description: this function validates data .
 * Arguments: string.
 * Returns: (0) if ok, (-1) if not ok.
 * 
 * (c)2010, AADV., parts from www.totallyphp.co.uk
 *******************************************************************/
function is_email(
                      $data_str  // string to validate
                    )
{
	if (strlen($data_str) < 11)  // xxx + '@' + xxx + .com == 11 chars
		return -1;
	
	if( eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $data_str) ) {
		return 0;
	} else {
		return -1;
	}
}



/********************************************************************
 * is_hour(), HOUR FORMAT VALIDATION FUNCTION
 * Author(s): AADV.
 * 
 * Revision History:
 *   Creation Date: 10/21/06, 09:30.
 *     notes: works fine.
 *   Last Revision: 11/29/06, 23:45.
 *     notes: modified to make work just with HH:MM
 * 
 * Description: this function validates data submitted that must be
 *              in HH:MM:SS format for the database to be updated.
 * Arguments: string with HH:MM:SS format.
 * Returns: (0) if ok, (-1) if not ok.
 * 
 * (c)2006, AADV.
 *******************************************************************/
function is_hour(
                 $hour_str   // string to validate
				)
{
  if (strlen($hour_str) != 5)
	return -1;
	
  if (!ereg("([0-1]{1})([0-9]{1}):([0-5]{1})([0-9]{1})", $hour_str))
	return -1;
	
  return 0;
}

/////////////////////////
// AADV, 120806, 15:18.
/////////////////////////
function order( $startHour, $startMin, $endHour, $endMin )
{  
  if ( $startHour == $endHour ) {
    
	if ( $startMin > $endMin ) {
	  
	  return -1;
	  
	}    
  }
  
  if ( $startHour > $endHour ) {
  
    return -1;
  
  } else {
  
    return 0;
  
  }
}



/********************************************************************
 * SOCKET COMMUNICATION IN PHP (CLIENT)
 * Author(s): AADV.
 * 
 * Revision History:
 *   Creation Date: 10/06/06, 18:09.
 *     notes: didn't work.
 *   Last Revision: 10/11/06, 17:10.
 *     notes: the socket module needs to be enabled in the PHP
 *            configuration file, it works.
 * 
 * Description: Socket client program that sends a string to the 
 *              server at the IP address provided.
 * Arguments: $address - address of the destination socket server.
 *            $msg     - string that will be sent to the server.
 * Returns: none.
 * 
 * (c)2006, AADV.
 *******************************************************************/
function sktcomm(
                   $address,  // destination address
				   $port,	// server port
                   $msg      // payload
				)
{

// Creating socket...
$socket = socket_create(AF_INET, SOCK_STREAM, 0);

// Attempting to connect to '$address' on port '$service_port'...
$result = @socket_connect($socket, $address, $port);
if ($result == false) {

   return -1;  // there is no connection with any SBC.  Flag the problem.
   
} else {
   // Sending message...
   if ( @socket_write($socket, $msg, strlen($msg)) < 0 ) {
      echo "error sending the configuration values... <br>";
   }
}

// Closing socket...
@socket_close($socket);

return 0;
}

/********************************************************************
 * SOCKET COMMUNICATION IN PHP FOR DUPLEX MODE (CLIENT)
 * Author(s): AADV.
 * 
 * Revision History:
 *   Creation Date: 03/10/07, 17:28.
 *     notes: .
 *******************************************************************/
function sktcommDuplex(
                   $address,  // destination address
				   $port,     // server port
                   $msg,      // payload
				   &$resp      // response from remote peer
				)
{
/* Create a TCP/IP socket. */
// Creating socket...
$socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket < 0) {
   echo "socket_create() failed: reason: " . socket_strerror($socket) . "\n";
} else {
  // echo "OK.\n"
  ;
}
// Attempting to connect to '$address' on port '$service_port'...
$result = @socket_connect($socket, $address, $port);
if ($result == false) {

   return -1;  // there is no connection with any SBC.  Flag the problem.
   
} else {
  // Sending message...
  @socket_write($socket, $msg, strlen($msg));
  
  // Receiving response...
  /*while ( ($response = socket_read($socket, 256, PHP_BINARY_READ)) != false ) {  // PHP_NORMAL_READ, PHP_BINARY_READ
    $resp[$i] = $response;
  }*/
  
  $resp = socket_read($socket, 256, PHP_BINARY_READ);      // PHP over Windows
  //$resp = socket_read($socket, 256, PHP_NORMAL_READ);      // PHP over Linux
}

// Closing socket...
@socket_close($socket);

return 0;
}


/********************************************************************
 * AUTHENTICATE USERNAME/PASSWORD AGAINST A DATABASE
 * Author(s): AADV.
 * 
 * Revision History:
 *   Creation Date: 05/27/07, 22:54.
 *   notes:
 *          returns: 0 if username and password is incorrect,
 *                   1 if username and password are correct.
 *                   2 if -u and -p are ok AND user is ADMIN
 *******************************************************************/
function authenticate($user, $pass)
{
  include('dbConnect_hssiso.inc');
  
  if ( ! @mysql_select_db('hss_db', $link_id) ) {
    die( '<p>Unable to locate the database at this time. - authenticate -</p>' );
  }
  
  // check login and password, execute query
  $query = "SELECT * from employees_tbl WHERE emp_login = '$user' AND emp_password = '$pass'";
  $result = mysql_query($query, $link_id) or die ("Error in query: $query. " . mysql_error());
  
  // if row exists -> user/pass combination is correct
  if (mysql_num_rows($result) == 1) {
    //return 1;
	
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	
	if ( $row['group_id'] == '1' ) {
		return 1;
	} else {
	
		if ( $row['group_id'] == '2' ) {		
			return 1;
			
		} else {
			if ( $row['group_id'] == '3' ) {		
			return 2;
			}
		}
	}	
  } else {  // user/pass combination is wrong
    return 0;
  }
}


/********************************************************************
 * GET A COMPLETE TABLE FROM A [SELECT * FROM table] QUERY
 * 
 * notes:
 * This function returns an array of arrays. Every array contained
 * inside de main array is an associative array representing a table
 * row from a MySQL database.
 * 
 *******************************************************************/
function get_table( $result )
{
    $index = 0;
	$a = array();
	
    while ( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
		$a[$index] = $row;
		$index++;
	}
	return $a;
}