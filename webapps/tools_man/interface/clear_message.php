<?php

if ( $_REQUEST['tool_to_delete_id'] == "EXIT" ) {

	header( 'Location: 1.php' );
	exit(1);
}


require_once('Database/MySQL.php');
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

# get id for tool message to be deleted
$tool_to_delete = strstr( $_REQUEST['tool_to_delete_id'], '_' );
$tool = array();
$tool = explode( '_', $tool_to_delete );
$tool_id = $tool[1];

# deleting message flag for this tool
$sql = "UPDATE tools
		SET message_id ='0'
		WHERE tool_id='$tool_id'";
$res = $db->query($sql);

# updating the system to a new state [ no messages ]
	#
	# first check is there are other messages
	$sql = "SELECT message_id FROM tools";
	$res_mess = $db->query($sql);
	
	$flag = 0;  // assume there are no more messages
	while ( $row = $res_mess->fetch() ) {
	
		if ( $row['message_id'] != '0' ) {
			$flag = 1;  // at least one message found
		}
	}
	
	if ( $flag == 0 ) {  // no messages, then change application's state
	
		$sql = "UPDATE tools_app_current_state
				SET tools_app_state_id='1'";
		$result_1 = $db->query($sql);
	}


# get data for user interface
$sql = "SELECT tool_description FROM tools WHERE tool_id='$tool_id'";
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

<br/><br/><br/>

<center>

Message for:<br/><br/>
<font color="#FF0000"><?php echo $row['tool_description']; ?> </font><br/><br/>
 has been deleted.

</center>

</body>
</html>

