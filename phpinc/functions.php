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


/////////////////////////
// AADV, 011707, 00:07.
/////////////////////////
function chHourForm(
                    &$hour    // string to be formatted
                   )
{
  switch( $hour ) {
    case "01":
	  $hour = "13";
	  break;
	case "02":
	  $hour = "14";
	  break;
	case "03":
	  $hour = "15";
	  break;
	case "04":
	  $hour = "16";
	  break;
	case "05":
	  $hour = "17";
	  break;
	case "06":
	  $hour = "18";
	  break;
	case "07":
	  $hour = "19";
	  break;
	case "08":
	  $hour = "20";
	  break;
	case "09":
	  $hour = "21";
      break;
	case "10":
	  $hour = "22";
	  break;
	case "11":
	  $hour = "23";
	  break;
  }

}  # end of:  chHourForm()

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
 *******************************************************************/
function authenticate($user, $pass)
{
  include('dbConnect.inc');
  
  if ( ! @mysql_select_db('login', $link_id) ) {
    die( '<p>Unable to locate the database at this time. - authenticate -</p>' );
  }
  
  // check login and password, execute query
  $query = "SELECT id from users WHERE user = '$user' AND password = '$pass'";
  $result = mysql_query($query, $link_id) or die ("Error in query: $query. " . mysql_error());
  
  // if row exists -> user/pass combination is correct
  if (mysql_num_rows($result) == 1) {
    return 1;
  } else {  // user/pass combination is wrong
    return 0;
  }
}




/////AADV/////////////////////////////
/////062707, 1417.////////////////////
// this functions generates a table
// to display the contents of an 
// inventory's file
function get_inv_value( $value, $row )
{
  $i = 0;
  while ( $row[$i] != "\t" ) {
    $barcode[$i] = $row[$i];
    $i++;
  }
  $i++;
  $j = 0;
  while ( $row[$i] != '	' ) {  // in this row: ' ' = 'tab' (.. alternative)
    $batch[$j] = $row[$i];
    $i++;
    $j++;
  }
  $i++;
  $j = 0;
  while ( $row[$i] != "\t" ) {
    $quantity[$j] = $row[$i];
    $i++;
    $j++;
  }
  $i++;
  $j = 0;
  while ( $row[$i] != "\n" ) {
    $price[$j] = $row[$i];
    $i++;
    $j++;
  }

  switch ($value) {
  case 'barcode':
    for ($k = 0; $k <= (sizeof($barcode)-1); $k++) {
      echo $barcode[$k];
    }
    break;
  case 'batch':
    for ($k = 0; $k <= (sizeof($batch)-1); $k++) {
      echo $batch[$k];
    }
    break;
  case 'quantity':
    for ($k = 0; $k <= (sizeof($quantity)-1); $k++) {
      echo $quantity[$k];
    }
    break;
  case 'desc':
    for ($k = 0; $k <= (sizeof($price)-1); $k++) {
      echo $price[$k];
    }
    break;

  }  // end of: switch ($value) {

  return 1;
}  // get_inv_value()


/////AADV/////////////////////////////
/////062707, 1419.////////////////////
// this functions gets the current
// date and time and prints it
// over the place it was called
// into the HTML code
function get_current_date()
{  
  //date_default_timezone_set('America/East');
  
  $month = date('F');
  $day = date('d');
  $dayFull = date('l');
  $year = date('Y');
  $hour = date('h');
  $minute = date('i');
  $mer = date('A');
  /////////////////////////////////
  /////////////////////////////////
  
  $hour = $hour - 1;  # find out why is php reading the time with an hour ahead.
  
  if ( $hour == 0 ) {
    $hour = 12;
  }
  
  $currentTime = $dayFull.", ".$day." ".$month." ".$year." - ".$hour.":".$minute." ".$mer;
//  $ctime = localtime();
//  $currentTime = "$ctime[2]:$ctime[1]";

  return $currentTime;

}  // get_current_date()


////// AADV - 071107, 15:22 //////////////////////
///// ASCII DECODER TO GET THE CIRCUIT STATE /////
 function process_response( $resp )
 {
   switch ( $resp ) {
     case '0': {  // 0x0000 --> [ldX4=0, ldX3=0, ldX2=0, ldX1=0]
	   return "0000";  // returning the state of every control line
	   break;
	 }
	 case '1': {  // 0x0001 --> [ldX4=0, ldX3=0, ldX2=0, ldX1=1]
	   return "0001";  // returning the state of every control line
	   break;
	 }
	 case '2': { return "0010";	   break; }
	 case '3': { return "0011";    break; }
	 case '4': { return "0100";    break; }
	 case '5': { return "0101";	   break; }
	 case '6': { return "0110";    break; }
	 case '7': { return "0111";    break; }
	 case '8': { return "1000";	   break; }
	 case '9': { return "1001";    break; }
	 case ':': { return "1010";    break; }
	 case ';': { return "1011";	   break; }
	 case '<': { return "1100";    break; }
	 case '=': { return "1101";    break; }
	 case '>': { return "1110";    break; }
	 case '?': { return "1111";    break; }
   }  // end of:   switch ( $resp ) {  
 }
 

/********************************************************************
 * GET A COMPLETE TABLE FROM A [SELECT * FROM table] QUERY
 * ADE - 2015.08.04, 08:55
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
	
    while ( $row = mysqli_fetch_array($result, MYSQL_ASSOC) ) {
		$a[$index] = $row;
		$index++;
	}
	return $a;
}

?>
