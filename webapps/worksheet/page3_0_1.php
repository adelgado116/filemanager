<?php

$equip_model = $_REQUEST['EQUIP_MODEL'];
$order = $_REQUEST['ORDER_NO'];
$equip_id = $_REQUEST['EQUIP_ID'];


$msg_to_display = '';

// 1 = ssas, 3 = mer-vdr, 29 = std4, 39 = debeg4300, 42 = std20, 48 = std22, 62 = std14, 90 = debeg4310, 147 = gyrostar2
switch ( $equip_id ) {

case 1:	// ssas
	$msg_to_display = "Remember to attach the following file when replying email to customer:<br/><br/> &nbsp;&nbsp;<font color=\"red\">ssas_config_information.xls</font>";
	break;
case 3:	// MER-VDR
	$msg_to_display = "Remember to ask Interschalt for VDR ACCESS CODE and Documents";
	break;
case 29:	// STD4
	$msg_to_display = "Remember to ask customer for Gyrosphere S/N and get history of it from Raytheon-Anshuetz";
	break;
case 39:	// debeg4300
	$msg_to_display = "For APT: Please ask Sam Electronics whether VDR Backup Batteries are RBC6 or RBC7";
	break;
case 42:	// STD20
	$msg_to_display = "Remember to ask customer for Gyrosphere S/N and get history of it from Raytheon-Anshuetz";
	break;
case 48:	// STD22
	$msg_to_display = "Remember to ask customer for Gyrosphere S/N and get history of it from Raytheon-Anshuetz";
	break;
case 62:	// STD14
	$msg_to_display = "Remember to ask customer for Gyrosphere S/N and get history of it from Raytheon-Anshuetz";
	break;
case 90:	// debeg4310
	$msg_to_display = "For APT: Please ask Sam Electronics whether VDR Backup Batteries are RBC6 or RBC7";
	break;
case 147:	// gyrostar2
	$msg_to_display = "Remember to ask customer for Gyrosphere S/N and get history of it from Raytheon-Anshuetz";
	break;
}



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>send automatic mail</title>
<meta content="CodeCharge Studio 4.01.00.06" name="GENERATOR">
<link href="Styles/hss1/Style_doctype.css" type="text/css" rel="stylesheet">
</head>
<body>

<br/><br/><br/><br/><br/>

<center>
<table cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td valign="top">
		<table class="Header" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td class="HeaderLeft"><img alt="" src="Styles/hss1/Images/Spacer.gif" border="0"></td>
				<td class="th"><strong>Information about this equipment is required!</strong></td>
				<td class="HeaderRight"><img alt="" src="Styles/hss1/Images/Spacer.gif" border="0"></td>
			</tr>
		</table>

		<table class="Grid" cellspacing="0" cellpadding="0">
			<tr class="Caption">
				<th scope="col" colspan="2"><?php echo $msg_to_display; ?></th>
			</tr>


	<tr class="Row">
		<td colspan="2">
			<div align="right"><a href="page3.php"><STRONG>CANCEL</STRONG></a>
			|&nbsp;<?php echo "<a href=\"page4.php?EQUIP_MODEL=$equip_model&ORDER_NO=$order&EQUIP_ID=$equip_id\"><strong>CONTINUE</strong></div></a>" ?>
		</td>
	</tr>
	<tr class="Footer">
		<td colspan="2"></td>
	</tr>
	</table>
</td>
</tr>
</table>

</center>

</body>
</html>

