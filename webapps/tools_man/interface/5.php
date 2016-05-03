<?php


if ( $_REQUEST['var_from_page_4'] == "EXIT" ) {

	header( 'Location: 1.php' );
	exit();
}


$decision_string = array();
$decision_string = explode( '_', $_REQUEST['var_from_page_4'] );


if ( $decision_string[0] == "TOODE" ) {  // check for valid barcode input

	$comment = substr( strstr( $_REQUEST['var_from_page_4'], '_' ), 1 );  // get user's decision to make or no a comment

	if ( $comment == '0' ) {
	
		header( 'Location: 1.php' );
		
	} else if ( $comment == '1' ) {
	
		require_once('Database/MySQL.php');
		$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');
				
		# getting tool description
		$tool = $_REQUEST['tool_id'];
		$sql = "SELECT tool_description FROM tools WHERE tool_id='$tool'";
		$res = $db->query($sql);
		$row = $res->fetch();
		
	
		?>
		
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
		<head>
		<title>:: 5 :: </title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<meta HTTP-EQUIV="REFRESH" content="300; url=1.php">
		</head>
		
		<body style="color:#003366; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:24px; font-weight: bold" onLoad="document.form5.message.focus();">

		<div align="right">
		<img src="images/EX.png" width="200" />	
		</div>

		<br/>
		<center>
		
		Select a Message for: <font color="#FF0000"><?php echo $row['tool_description']; ?></font><br/><br/>
		
		<?php
		
		$sql = "SELECT * FROM tools_app_messages";
		$res = $db->query($sql);
		
		?>
		
		<table>
		<?php 
		
		while ( $row = $res->fetch() ) {
			
			$msg_id = $row['message_id'];
			$msg = $row['message'];
			$file = 'msg_'.$msg_id.'.png';
			
			?>
			<tr style="color:#003366; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:20px; font-weight: bold">
			<td valign="middle"><?php echo "[$msg_id] $msg"?></td><td width="300" align="center"><?php echo "<img src=\"images/$file\" /><br>[$msg_id]<br>"; ?></td>
			</tr>
			<?php
		}
		?>
		</table>
		
		<form name="form5" action="5_1.php?tool_id=<?php echo $_REQUEST['tool_id']; ?>" method="post" >
		<input name="message" type="text" size="10" style="border: 1px solid white; color: white" />
		</form>

		<br/><br/>
		
		</center>
		
		</body>
		</html>
		
		<?php
	}
	
} else {

	if ( strchr( $_SERVER['HTTP_REFERER'], "http://localhost/webapps/tools_app/interface/4.php" ) ) {
		header( 'Location: 4.php?user_id='.$_REQUEST['user_id'].'&tool_id='.$_REQUEST['full_tool_id'].'&in_out='.$_REQUEST['in_out'] );  // wrong barcode type selected, keep user on previous page
	}
	
	// if problems arise with redirection make connection to 6.php and pass corresponding variables
}

?>
