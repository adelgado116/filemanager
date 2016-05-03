<?php

if ( $_REQUEST['tool_id'] == "EXIT" ) {

	header( 'Location: 1.php' );
	exit();
}

//if ( strstr( $_REQUEST['tool_id'], 'D', true ) == "HSS_TI" ) {  // check for valid barcode input

$idstring = array();
$idstring = explode( '_', $_REQUEST['tool_id'] );


if ( $idstring[0] == "HSS" ) {  // check for valid barcode input
	
	$tool = strstr( $_REQUEST['tool_id'], 'D' );  // extract this tool's id
	
	$tool_id = array();
	$tool_id = explode( 'D', $tool );

	$tool = $tool_id[1];

	require_once('Database/MySQL.php');
	$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');
	
	$sql = "SELECT * FROM tools WHERE tool_id='$tool'";
	$res1 = $db->query($sql);
	$row = $res1->fetch();
	
	$reg_user = $row['regular_user_id'];
	$sql = "SELECT emp_login FROM employees_tbl WHERE emp_id='$reg_user'";
	$res_a = $db->query($sql);
	$row_a = $res_a->fetch();
	
	$las_user = $row['last_user_id'];
	$sql = "SELECT emp_login FROM employees_tbl WHERE emp_id='$las_user'";
	$res_d = $db->query($sql);
	$row_d = $res_d->fetch();
	
	$cur_user = $row['current_user_id'];
	$sql = "SELECT emp_login FROM employees_tbl WHERE emp_id='$cur_user'";
	$res_b = $db->query($sql);
	$row_b = $res_b->fetch();
	
	$tool_status = $row['tool_status_id'];
	$sql = "SELECT tool_status FROM tools_status WHERE tool_status_id='$tool_status'";
	$res_c = $db->query($sql);
	$row_c = $res_c->fetch();
	
	$message_id = $row['message_id'];
	$sql = "SELECT message FROM tools_app_messages WHERE message_id='$message_id'";
	$res_e = $db->query($sql);
	$row_e = $res_e->fetch();	
	
	?>
	
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<head>
	<title>:: 3 :: </title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta HTTP-EQUIV="REFRESH" content="150; url=1.php">
	</head>
	
	<body style="color:#003366; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:24px; font-weight: bold" onLoad="document.form3.in_out.focus();">
	
	
	<div align="right">
	<img src="images/EX.png" width="200" />
	</div>
	
	
	<center>
	
	<br/>
	You have selected the following tool:
	<br/><br/>
	
	<table border="1">
		<tr>
			<th>Description</th>
			<td>
			<?php echo $row['tool_description']; ?>
			</td>
		</tr>
		<tr>
			<th>Regular User</th>
			<td align="center">
			<?php echo $row_a['emp_login']; ?>
			</td>
		</tr>
		<tr>
			<th>Last User</th>
			<td align="center">
			<?php echo $row_d['emp_login']; ?>
			</td>
		</tr>
		<tr>
			<th>Actual User</th>
			<td align="center">
			<?php echo $row_b['emp_login']; ?>
			</td>
		</tr>
		<tr>
			<th>Location</th>
			<td align="center">
			<?php echo $row['location']; ?>
			</td>
		</tr>
		<tr>
			<th>Status</th>
			<td align="center" bgcolor="#FF9999">
			<?php echo $row_c['tool_status']; ?>
			</td>
		</tr>
		<tr>
			<th>Message</th>
			<td align="center">
			<?php echo '<strong><font color="red" size=-1>'.$row_e['message'].'</font></strong>'; ?>
			</td>
		</tr>
	</table>
	
	<br/><br/>
	direction of this Tool ?
	<br/><br/>
	
	<table>
	<tr align="center">
	<td width="300"><img src="images/IN.png" width="200" /><br>IN</td>
	<td width="300"><img src="images/OUT.png" width="200" /><br>OUT</td>
	</tr>
	</table>
	
	<form name="form3" action="4.php?tool_id=<?php echo $tool; ?>&full_tool_id=<?php echo $_REQUEST['tool_id']; ?>&user_id=<?php echo $_REQUEST['user_id']; ?>" method="post" >
	<input name="in_out" type="text" maxlength="10" size="10"   style="border: 1px solid white; color: white" />
	</form>
	
	</center>
	
	</body>
	</html>
	
	<?php
	
} else {

	header( 'Location: 2.php?user_id='.$_REQUEST['user_id'] );  // wrong barcode type selected, keep user on previous page
}

?>
