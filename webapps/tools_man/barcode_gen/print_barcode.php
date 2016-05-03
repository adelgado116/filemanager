<?php

require_once('functions.php');


$tid = $_REQUEST['tool_id'];

if ( sktcomm( "192.168.244.216", 5171, "HSS_TID".$tid."," ) != 0 ) {

	echo "<center>";
	echo "<br><br><font color=red><b>PROBLEM CONNECTING TO COMMANDER...  call ADE</b></font>";
	echo "<br><br><a href=\"javascript:window.close();\" >close</a>";
	exit(1);
	echo "</center>";
}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>barcode print :: </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body style="font-family: Verdana; font-size: 14pt;">

<center>
	<br><br>
	Go to the printer and pick your label up!
	<br><br>
	<a href="javascript:window.close();" >close</a>

</center>

</body>
</html>
