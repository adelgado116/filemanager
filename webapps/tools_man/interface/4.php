<?php

if ( $_REQUEST['in_out'] == "EXIT" ) {

	header( 'Location: 1.php' );
	exit();
}

$dirstring = array();
$dirstring = explode( '_', $_REQUEST['in_out'] );

if ( $dirstring[0] == "TOODI" ) {  // check for valid barcode input

	$direction = substr( strstr( $_REQUEST['in_out'], '_' ), 1 );  // get the direction the tool is going: in=1 or out=0

	require_once('Database/MySQL.php');
	$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');
	
	$tool = $_REQUEST['tool_id'];
	
	?>
	
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<head>
	<title>:: 4 :: </title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta HTTP-EQUIV="REFRESH" content="200; url=1.php">
	</head>
	
	<body style="color:#003366; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:24px; font-weight: bold" onLoad="document.form4.var_from_page_4.focus();">
	
	<br/><br/>
	
	<center>
	
	<?php
	if ( $direction == '0' ) {
	
		$sql = "SELECT * FROM tools WHERE tool_id=$tool";
		$res1 = $db->query($sql);
		$row = $res1->fetch(); 
		
		switch ( $row['tool_status_id'] ) {
		case 2:
			
			$current_user = $row['current_user_id'];
			
			$sql = "SELECT emp_name FROM employees_tbl WHERE emp_id='$current_user'";
			$res2 = $db->query($sql);
			$row_a = $res2->fetch();
		
			echo "<font color=\"red\">This tool is being used by: </font>".$row_a['emp_name'].".<br/><br/>Do you want to swap places and take this tool?";
			
			?>
			
			<br/><br/>
			
			<table>
			<tr align="center">
			<td width="300"><img src="images/YES.png" width="200" /><br>YES</td>
			<td width="300"><img src="images/NO.png" width="200" /><br>NO</td>
			</tr>
			</table>
			
			
			<form name="form4" action="6.php?tool_id=<?php echo $tool; ?>&in_out=<?php echo $_REQUEST['in_out'];?>&new_user=<?php echo $_REQUEST['user_id']; ?>" method="post" >
			<input name="var_from_page_4" type="text" maxlength="10" size="10"  style="border: 1px solid white; color: white" />
			</form>
			
			<?php
				
			break;
		case 3:
			echo "The tool you have selected is<br/><br/>damaged and has to be repaired or discarded.";
			break;
		case 4:
			echo "The tool you have selected is<br/><br/> under repairment.";
			break;
		default: // case 1:
		
			$new_user = $_REQUEST['user_id'];
			
			$sql = "UPDATE tools
					SET tool_status_id='2', current_user_id='$new_user'
					WHERE tool_id='$tool'";
			$result = $db->query($sql);
			
			?>
			Database has been updated.<br/><br/>Do you have any message about this tool?
			
			<br><br>
			
			<table>
			<tr align="center">
			<td width="300"><img src="images/YES.png" width="200" /><br>YES</td>
			<td width="300"><img src="images/NO.png" width="200" /><br>NO</td>
			</tr>
			</table>
			
			<form name="form4" action="5.php?tool_id=<?php echo $tool; ?>&in_out=<?php echo $_REQUEST['in_out'];?>" method="post" >
			<input name="var_from_page_4" type="text" maxlength="10" size="10"  style="border: 1px solid white; color: white" />
			</form>
			<?php
			break;
		}
	
	} else if ( $direction == '1' ) {
	
		// change tool status to available // set the last user field // set the current user field to undef
		$sql = "SELECT * FROM tools WHERE tool_id=$tool";
		$res1 = $db->query($sql);
		$row = $res1->fetch(); 
		
		$current_user = $row['current_user_id'];
		
		$sql = "UPDATE tools
				SET tool_status_id='1', last_user_id='$current_user', current_user_id='13'
				WHERE tool_id='$tool'";
		$result = $db->query($sql);		
		
		?>
		Database has been updated.<br/><br/>Do you have any message about this tool?
		
		<br><br>
		
		<table>
		<tr align="center">
		<td width="300"><img src="images/YES.png" width="200" /><br>YES</td>
		<td width="300"><img src="images/NO.png" width="200" /><br>NO</td>
		</tr>
		</table>
		
		
		<form name="form4" action="5.php?tool_id=<?php echo $tool; ?>&in_out=<?php echo $_REQUEST['in_out'];?>" method="post" >
		<input name="var_from_page_4" type="text" maxlength="10" size="10"  style="border: 1px solid white; color: white" />
		</form>
		<?php
	}
	?>
	
	</center>
	
	</body>
	</html>
	
	<?php

} else {

	header( 'Location: 3.php?user_id='.$_REQUEST['user_id'].'&tool_id='.$_REQUEST['full_tool_id'] );  // wrong barcode type selected, keep user on previous page
}

?>
