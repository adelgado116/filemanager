<?php

require_once('code128.class.php');

require_once('Database/MySQL.php');
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

$sql = "SELECT * FROM tools WHERE message_id > '0'";
$res = $db->query($sql);


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>:: 2 :: </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta HTTP-EQUIV="REFRESH" content="200; url=1.php">
</head>

<body style="color:#003366; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:24px; font-weight: bold" onLoad="document.form_message.tool_to_delete_id.focus();">

<div align="right">
<img src="images/EX.png" width="200" />	
</div>


<center>
<br/>
<table border="1">
<tr><td colspan="5" style="background-color:#003366; color:white; font-size:24px; font-weight: bold">List of Tools with Messages</td></tr>
<tr>
	<th>Tool Description</th>
	<th>Message</th>
	<th>Last User</th>
	<th>Delete Message</th>
</tr>

<?php

while ( $row = $res->fetch() ) {

	$msg_id = $row['message_id'];
	$sql = "SELECT * FROM tools_app_messages WHERE message_id='$msg_id'";
	$res_a = $db->query($sql);
	$row_a = $res_a->fetch();
	
	$last_user_id = $row['last_user_id'];
	$sql = "SELECT emp_login FROM employees_tbl WHERE emp_id='$last_user_id'";
	$res_b = $db->query($sql);
	$row_b = $res_b->fetch();
	
	echo '<tr>';
	echo '<td>';
	echo $row['tool_description'];
	echo '</td>';
	echo '<td>';
	echo '<strong><font color="red" >'.$row_a['message'].'</font></strong>';
	echo '</td>';
	echo '<td align="center">';
	echo $row_b['emp_login'];
	echo '</td>';
	echo '<td width="230" align="center">';
	
		#
		# generate a barcode to identify the tool-message pair in a unique fashion
		#	
		$barcode = new phpCode128('DLT_'.$row['tool_id'], 70, 'Dustismo_Roman.ttf', 12);
		// hide barcode text
		$barcode->setEanStyle(FALSE);
		$barcode->setShowText(FALSE);
		// remove barcode border
		$barcode->setBorderWidth(0);
		$barcode->setBorderSpacing(0);
		// setPixelWidth set to 2
		$barcode->setPixelWidth(2);
		$barcode->setAutoAdjustFontSize(FALSE);
		$barcode->setTextSpacing(5);
		// save barcode image
		$barcode->saveBarcode("images/temp/DLT_".$row['tool_id'].".png");
	
	echo '<br><img src="images/temp/DLT_'.$row['tool_id'].'.png" /><br><br>';
	
	echo '</td>';
	echo '</tr>';
}

?>

</table>

<form name="form_message" action="clear_message.php" method="post" >
<input name="tool_to_delete_id" type="text" maxlength="10" size="10"  style="border: 1px solid white; color: white" />
</form>

</center>

</body>
</html>
