<?php

require_once('Database/MySQL.php');
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

$user = $_REQUEST['user_id'];

$sql = "SELECT emp_name FROM employees_tbl WHERE emp_id='$user'";
$res_x = $db->query($sql);
$row_x = $res_x->fetch();

$sql = "SELECT * FROM tools WHERE current_user_id='$user'";
$res1 = $db->query($sql);

$no_records = 0;
if ( $res1->size() < 1 ) {

	$no_records = 1;
}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>:: 2 :: </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta HTTP-EQUIV="REFRESH" content="200; url=1.php">
</head>

<body style="color:#003366; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:24px; font-weight: bold" onLoad="document.form2.tool_id.focus();">

<div align="right">
<img src="images/EX.png" width="200" />	
</div>


<center>
<br/>
<table border="1">
	<tr><td colspan="5" style="background-color:#003366; color:white; font-size:24px; font-weight: bold">List of Tools for: &nbsp;&nbsp;<font color="#FF0000" size="+3"><?php echo $row_x['emp_name']; ?></font></td></tr>
	<tr>
		<th>Description</th>
		<th>Regular User</th>
		<th>Last User</th>
		<th>Location</th>
		<th>Status</th>
	</tr>
	
	<?php
	
	if ( $no_records == 0 ) {
	
		$i = 0;
		while ( $row[$i] = $res1->fetch() ) {
			
			$reg_user = $row[$i]['regular_user_id'];
			$sql = "SELECT emp_login FROM employees_tbl WHERE emp_id='$reg_user'";
			$res_a = $db->query($sql);
			$row_a = $res_a->fetch();
			
			$cur_user = $row[$i]['last_user_id'];
			$sql = "SELECT emp_login FROM employees_tbl WHERE emp_id='$cur_user'";
			$res_b = $db->query($sql);
			$row_b = $res_b->fetch();
			
			$tool_status = $row[$i]['tool_status_id'];
			$sql = "SELECT tool_status FROM tools_status WHERE tool_status_id='$tool_status'";
			$res_c = $db->query($sql);
			$row_c = $res_c->fetch();
			
			echo '<tr>';
			echo '<td>';
			echo $row[$i]['tool_description'];
			echo '</td>';
			echo '<td align="center">';
			echo $row_a['emp_login'];
			echo '</td>';
			echo '<td align="center">';
			echo $row_b['emp_login'];
			echo '</td>';
			echo '<td>';
			echo $row[$i]['location'];
			echo '</td>';
			echo '<td align="center">';
			echo $row_c['tool_status'];
			echo '</td>';
			echo '</tr>';
			
			$i++;
		}
	
	} else {
	
		echo '<tr>';
		echo '<td colspan="5"><strong><font color=red>no records found.</font></strong></td>';
		echo '</tr>';
	}
	
	?>
</table>

<br/><br/>
scan the barcode <br>from the tool you want to work with
<form name="form2" action="3.php?user_id=<?php echo $user; ?>" method="post" >
<input name="tool_id" type="text" maxlength="10" size="10"  style="border: 1px solid white; color: white" />
</form>

</center>

</body>
</html>
