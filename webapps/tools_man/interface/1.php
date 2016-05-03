<?php


require_once('Database/MySQL.php');
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

$sql = "SELECT * FROM tools_app_current_state";
$res = $db->query($sql);
$state = $res->fetch();


switch ( $state['tools_app_state_id'] ) {
	case '2':  // @ state: home with messages
		?>
		<div align="right">
		<img src="images/MESSAGE.png" width="250" />	
		</div>
		<?php
		break;
	default:  // @ home (and all other possibilities)
		break;
}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>:: 1 :: </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body style="color:#003366; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:24px; font-weight: bold" onLoad="document.form1.user_id.focus();">

<center>

<table>
<tr align="center">
<td width="300"><img src="images/wqu_pic.gif"/><br><img src="images/WQU.png" /></td><td width="300"><img src="images/rqu_pic.gif"/><br><img src="images/RQU.png" /></td>
<td width="300"><img src="images/pma_pic.gif"/><br><img src="images/PMA.png" /></td><td width="300"><img src="images/mle_pic.gif"/><br><img src="images/MLE.png" /></td>
</tr>
<tr align="center">
<td><img src="images/kto_pic.gif"/><br><img src="images/KTO.png" /></td><td><img src="images/jqu_pic.gif"/><br><img src="images/JQU.png" /></td>
<td><img src="images/ihe_pic.gif"/><br><img src="images/IHE.png" /></td><td><img src="images/cpa_pic.gif"/><br><img src="images/CAP.png" /></td>
</tr>
<tr align="center">
<td><img src="images/ade_pic.gif"/><br><img src="images/ADE.png" /></td><td><img src="images/jha_pic.gif"/><br><img src="images/JHA.png" /></td>
<td><img src="images/asu_pic.gif"/><br><img src="images/ASU.png" /></td><td></td>
</tr>
</table>

<form name="form1" action="1_1.php" method="post" >
<input name="user_id" type="text" maxlength="10" size="7"  style="border: 1px solid white; color: white" />
<!-- <input name="submit" type="submit" value="send" /> -->
</form>

</center>

</body>
</html>
