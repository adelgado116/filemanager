<?php

//if ( strstr( $_REQUEST['var_from_page_4'], '_', true ) == "TOODE" ) {  // check for valid barcode input


$decision_string = array();
$decision_string = explode( '_', $_REQUEST['var_from_page_4'] );

if ( $decision_string[0] == "TOODE" ) {  // check for valid barcode input

	$swap = substr( strstr( $_REQUEST['var_from_page_4'], '_' ), 1 );  // get user's decision to take or not the tool

	if ( $swap == '0' ) {
	
		header( 'Location: 1.php' );
		
	} else if ( $swap == '1' ) {

		$new_user = $_REQUEST['new_user'];
		$tool = $_REQUEST['tool_id'];
		
		require_once('Database/MySQL.php');
		$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');
		
		$sql = "UPDATE tools
				SET current_user_id='$new_user'
				WHERE tool_id='$tool'";
		$result = $db->query($sql);
		
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
		<head>
		<title>:: 6 :: </title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<meta HTTP-EQUIV="REFRESH" content="200; url=1.php">
		</head>
		
		<body style="color:#003366; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:24px; font-weight: bold" onLoad="document.form6.var_from_page_4.focus();">
		
		<br/><br/>
		
		<center>
		Database has been updated.<br/><br/>Do you have any message about this tool?
		
		<br><br>
		
		<table>
		<tr align="center">
		<td width="300"><img src="images/YES.png" width="200" /><br>YES</td>
		<td width="300"><img src="images/NO.png" width="200" /><br>NO</td>
		</tr>
		</table>
		
		<form name="form6" action="5.php?tool_id=<?php echo $tool; ?>&in_out=<?php echo $_REQUEST['in_out'];?>" method="post" >
		<input name="var_from_page_4" type="text" maxlength="10" size="10"  style="border: 1px solid white; color: white" />
		</form>
		</center>
		
		</body>
		</html>
		<?php		
	}
	
} else {

	header( 'Location: 4.php?user_id='.$_REQUEST['user_id'].'&tool_id='.$_REQUEST['full_tool_id'].'&in_out='.$_REQUEST['in_out'] );  // wrong barcode type selected, keep user on previous page
}

?>