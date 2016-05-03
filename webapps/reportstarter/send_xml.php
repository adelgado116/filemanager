<?php

#
#  send XML file to techs, marine and workshop
#

// Include the phpmailer class
require 'ThirdParty/phpmailer/class.phpmailer.php';
// Instantiate it
$mail = new phpmailer();

// Define who the message is from
$mail->From = 'auto@raypanama.com';
$mail->FromName = 'RAn Panama System';

// Set the subject of the message
$mail->Subject = 'XML Report file: '.$_REQUEST['serviceOrder'].' - '.$_REQUEST['vesselName'];

// Add the body of the message
$body = "\nThis is an automated e-mail message.\n-- DO NOT REPLY --\n\n* Download the attached XML file \n* Save it to your C:/hss_reports folder \n* Open it with the Report Tool\n\n--\nRaytheon Anschuetz Panama.";
$mail->Body = $body;

// Add a recipient address
$mail->AddAddress('workshop@raypanama.com', 'Workshop');
$mail->AddAddress('service@raypanama.com', 'Service Coordination');

if ( $_REQUEST['select_tech1'] != "empty" ) {
	$mail->AddAddress( $_REQUEST['select_tech1'], 'Tech1' );
}
if ( $_REQUEST['select_tech2'] != "empty" ) {
	$mail->AddAddress( $_REQUEST['select_tech2'], 'Tech2' );
}
if ( $_REQUEST['select_tech3'] != "empty" ) {
	$mail->AddAddress( $_REQUEST['select_tech3'], 'Tech3' );
}
if ( $_REQUEST['select_tech4'] != "empty" ) {
	$mail->AddAddress( $_REQUEST['select_tech4'], 'Tech4' );
}

$fullpath = $_REQUEST['path'].$_REQUEST['serviceOrder'].'.xml';

$mail->AddAttachment( /*FULLPATH*/ $fullpath, /*NAME*/ $_REQUEST['serviceOrder'].'.xml' );


// Send the message
if (!$mail->Send()) {
	echo '<font color=red>Mail sending failed.  Contact system administrator.</font';
} else {
	//echo 'Mail has been passed on to SMTP server';
}

// Clear all addresses and attachments for next loop
$mail->ClearAddresses();
$mail->ClearAttachments();

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Returned Part Sheet </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

<center>

<font color="#000033" face="Verdana, Arial, Helvetica, sans-serif">
<br/><br/>

<h2>File <?php echo $_REQUEST['serviceOrder'].'.xml'; ?> has been sent to:</h2>

<br/><br/>
marine@raypanama.com<br/>
workshop@raypanama.com<br/>

<?php
	if ( $_REQUEST['select_tech1'] != "empty" ) {
		echo $_REQUEST['select_tech1'].'<br/>';
	}
	if ( $_REQUEST['select_tech2'] != "empty" ) {
		echo $_REQUEST['select_tech2'].'<br/>';
	}
	if ( $_REQUEST['select_tech3'] != "empty" ) {
		echo $_REQUEST['select_tech3'].'<br/>';
	}
	if ( $_REQUEST['select_tech4'] != "empty" ) {
		echo $_REQUEST['select_tech4'].'<br/>';
	}

	//echo '<br/>'.$fullpath;
?>
</font>

</center>

</body>
</html>
