<?php

include('functions_hssiso.php');

#
#  validate data coming from passgen_a.php
#
$user = $_POST['user'];
$email = $_POST['email'];
$reemail = $_POST['reemail'];

$flag = 0;  // everything ok @ the beginning...

// see if the new username already exists !
include('dbConnect_hssiso.inc');

if ( ! @mysql_select_db('hss_db', $link_id) ) {
die( '<p>Unable to locate the database at this time. E2</p>' );
}

$result = mysql_query( "SELECT * FROM employees_tbl WHERE emp_login='$user'", $link_id );

if ( mysql_num_rows( $result ) == 0 ) {  // the username already exists

	$flag = -1;  // to avoid the program sending data to MySQL
?>

<html>
<head>
<title>error</title>
<link rel="stylesheet" href="css/home.css" type="text/css" />
<meta HTTP-EQUIV="REFRESH" content="4; passgen_a.php">
</head>

<body>
<br><br><br><br>

<center><img src="images/bad.png"></center>

<br>
<div class="font12">
<center>User not valid,<br> please enter the values again.</center>
</div>
</body>
</html>

<?php

exit();

} else {

	if ( strcmp($email, $reemail) != 0 ) {
		//$flag = 1;  // to avoid the program sending data to MySQL
?>

<html>
<head>
<title>error</title>
<link rel="stylesheet" href="css/home.css" type="text/css" />
<meta HTTP-EQUIV="REFRESH" content="4; passgen_a.php">
</head>

<body>
<br><br><br><br>

<center><img src="images/bad.png"></center>

<br>
<div class="font12">
<center>emails mismatch,<br> please enter the values again.</center>
</div>
</body>
</html>

<?php

	exit();

 	}  // if ( strcmp($pass, $repass) != 0 )
}  // end of the "else"

// data validation
  if ( is_email($email) == -1 ) {
    $flag = 1;
  }
  
  switch ($flag) {
    case 0:

	// generate new password
	$seed = rand(100000, 999999);
	$md5pass = md5( $seed );
	$sql = "UPDATE employees_tbl SET emp_password='$md5pass' WHERE emp_login='$user'";
	mysql_query( $sql, $link_id );
	
	mysql_close($link_id);

	#
	#  send an automatic e-mail to user
	#
	
	// Include the phpmailer class
	require 'ThirdParty/phpmailer/class.phpmailer.php';
	// Instantiate it
	$mail = new phpmailer();
	
	// Define who the message is from
	$mail->From = 'auto@raypanama.com';
	$mail->FromName = 'RAn Panama';
	
	// Set the subject of the message
	$mail->Subject = 'NEW PASSWORD to access RAn Panama System.';
	
	// Add the body of the message
	$body = "\nThis is an automatic generated e-mail message.\nDO NOT reply.\n\nPlease see new login information below:\n\n[username] = $user\n[password] = $seed\n\nThe Password can be changed in your profile's page.\n\n--\nRaytheon Anschuetz Panama.";
	
	$mail->Body = $body;
	
	// Add a recipient address
	$mail->AddAddress( $email, 'RAn Panama System User');
	//$mail->AddAttachment(/*PATH*/ $_REQUEST['filename'], /*NAME*/ $_REQUEST['fname'].".pdf");
	
	
	// Send the message
	if (!$mail->Send()) {
		$msg = '<font color=red>Failed sending e-mail.<br/><br/>Contact system administrator.</font';
		
		?>
		
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
		<head>
		<title>Password Generation </title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/login.css" type="text/css" />
		<meta HTTP-EQUIV="REFRESH" content="7; dashboard.php">
		</head>
		
		<body>
		
		<div id="form_1">
		<div class="font8">
		<center>
		
		<br/><br/><br/>
		<font color="#FF0000"><strong>
		Failed sending e-mail.
		<br/><br/>
		Contact system administrator.
		</strong></font>
		
		</center>
		
		</div>
		</div>
		
		</body>
		</html>
		
		<?php
		
		
	} else {
		?>
		
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
		<head>
		<title>Password Generation </title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="css/login.css" type="text/css" />
		<meta HTTP-EQUIV="REFRESH" content="7; dashboard.php">
		</head>
		
		<body>
		
		<div id="form_1">
		<div class="font8">
		<center>
		
		<br/><br/><br/>
		A new password has been sent to:
		<br/><br/>
		<font color="#FF0000"><strong><?php echo $email;  ?></strong></font>
		<br/><br/>
		It could be necessary to look into your<br/> Spam Folder to see the message.
		<br/><br/>
		Please set our system's address as "not spam".
		
		</center>
		
		</div>
		</div>
		
		</body>
		</html>
		
		<?php
	}
	
	// Clear all addresses and attachments for next loop
	$mail->ClearAddresses();
	//$mail->ClearAttachments();

	break;
	case 1:
	
?>
<html>
<head>
<title>error</title>
<link rel="stylesheet" href="css/home.css" type="text/css" />
<meta HTTP-EQUIV="REFRESH" content="4; passgen_a.php">
</head>

<body>
<br><br><br><br>

<center><img src="images/bad.png"></center>

<br>
<div class="font12">
<center>Invalid email address was entered.</center>
</div>
</body>
</html>

<?php
	break;
    default:
    break;
  }  // switch end.

?>

