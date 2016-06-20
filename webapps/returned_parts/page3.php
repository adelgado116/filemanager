<?php

#
#  send an e-mail to Logistics Dpt. with the RPS document attached to it.
#

// Include the phpmailer class
require 'ThirdParty/phpmailer/class.phpmailer.php';
// Instantiate it
$mail = new phpmailer();

// Define who the message is from
$mail->From = 'auto@raypanama.com';
$mail->FromName = 'RAn Panama System';

// Set the subject of the message
$mail->Subject = 'New Return Part Sheet from '.$_REQUEST['tech'];

// Add the body of the message
$body = "\nThis is an automatic e-mail message.\nDO NOT reply.\n\nPlease check the attached RETURNED PART SHEET and proceed with corresponding actions.\n\n--\nRaytheon Anschuetz Panama.";
$mail->Body = $body;

// Add a recipient address
$mail->AddAddress('sales@raypanama.com', 'Sales Department');
$mail->AddAddress('asugasti@raypanama.com', 'Sales Department');

# ONLY FOR TESTS
//$mail->AddAddress('alberto.delgado.vasquez@gmail.com', 'admin');


$mail->AddAttachment(/*PATH*/ $_REQUEST['filename'], /*NAME*/ $_REQUEST['fname'].".pdf");


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
A copy of your <font color="#003399"><b>Return Part Sheet</b></font>
has been sent to sales@raypanama.com<br/>
Please PRINT the page shown bellow ( using the command <img src="images/print_action.png" /> ) and attach it to the Part to be Returned.
</font>

<br/><br/>

<iframe src="<?php echo $_REQUEST['filename']; ?>" frameborder="1" width="600" height="490" ></iframe>

</center>

</body>
</html>
