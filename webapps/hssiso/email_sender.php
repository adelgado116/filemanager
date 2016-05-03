<?php

// session check
session_start();
if (!session_is_registered("SESSION")) {
  // if session check fails, invoke error handler
  header("Location: ./error.php");
  exit();
}


#
#  send an e-mail to QSM with new report attached to it.
#

// Include the phpmailer class
require 'ThirdParty/phpmailer/class.phpmailer.php';
// Instantiate it
$mail = new phpmailer();

// Define who the message is from
$mail->From = 'auto@raypanama.com';
$mail->FromName = 'RAn Panama System';

// Set the subject of the message
$mail->Subject = 'New Deviation Report from '.$_REQUEST['submitter'];

// Add the body of the message
$body = "\nThis is an automatic e-mail message.\nDO NOT reply.\n\nPlease check the attached Report and proceed with corresponding actions.\n\n--\nRaytheon Anschuetz Panama.";

$mail->Body = $body;

// Add a recipient address

#
#  connect to database
#
include('dbConnect_hssiso.inc');

if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}

$sql = "SELECT * FROM employees_tbl WHERE qsm='1'";
$res1 = mysql_query($sql) or die('Query failed [getting qsm 1]: ' . mysql_error());
$qsm = mysql_fetch_array($res1, MYSQL_ASSOC);

# primary destination address
$mail->AddAddress( $qsm['email'], 'QSM: '.$qsm['emp_name'] );
//$mail->AddAddress( 'ade@hss-panama.com', 'ade@hss-panama.com' );

# secondary destination address
$sql = "SELECT * FROM reports_secondary_email";
$res2 = mysql_query($sql) or die('Query failed [getting qsm 2]: ' . mysql_error());
$qsm_2 = mysql_fetch_array($res2, MYSQL_ASSOC);

if ( $qsm_2['enable'] == 1 ) {
	
	$mail->AddAddress( $qsm_2['secondary_email'], 'QSM 2' );
}

# attach Report File (PDF)
$mail->AddAttachment(/*PATH*/ $_REQUEST['filename'], /*NAME*/ $_REQUEST['fname']);


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
<title>Deviation Reports </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- <link rel="stylesheet" href="css/report_viewer.css" type="text/css" /> -->
</head>

<body>


<div id="message_display">

<font color="#000033" face="Verdana, Arial, Helvetica, sans-serif">
Your <font color="#003399"><b>Report</b></font> has been saved. Save a copy or print it out using the embedded controls.
</font>

<br/><br/>

<iframe src="<?php echo $_REQUEST['filename']; ?>" frameborder="0" width="755" height="480" ></iframe>

</body>
</html>
