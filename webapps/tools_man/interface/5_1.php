<?php

if ( $_REQUEST['message'] == "EXIT" ) {

	header( 'Location: 1.php' );
	exit(1);
}


$message = strstr( $_REQUEST['message'], '_' );		
$msg = array();
$msg = explode( '_', $message );

$msg_id = $msg[1];

$tool = $_REQUEST['tool_id'];

require_once('Database/MySQL.php');
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');


# set the message identifier on this tool record
$sql = "UPDATE tools
		SET message_id='$msg_id'
		WHERE tool_id='$tool'";
$result = $db->query($sql);

# set the new state [ message(s) present ]
$sql = "UPDATE tools_app_current_state
		SET tools_app_state_id='2'";
$result_1 = $db->query($sql);

# get data for user interface
$sql = "SELECT tool_description FROM tools WHERE tool_id='$tool'";
$res = $db->query($sql);
$row = $res->fetch();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>:: 5-1 :: </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta HTTP-EQUIV="REFRESH" content="5; url=1.php">
</head>

<body style="color:#003366; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:24px; font-weight: bold" onLoad="document.form4.do_comment.focus();">

<br/><br/>

<center>

Your message for:<br/><br/>
<font color="#FF0000"><?php echo $row['tool_description']; ?></font><br/><br/>
has been saved.

</center>

</body>
</html>
