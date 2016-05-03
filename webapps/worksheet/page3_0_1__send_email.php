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
				<td class="th"><strong>Automated Message To The Customer</strong></td>
				<td class="HeaderRight"><img alt="" src="Styles/hss1/Images/Spacer.gif" border="0"></td>
			</tr>
		</table>

		<table class="Grid" cellspacing="0" cellpadding="0">
			<tr class="Caption">
				<th scope="col" colspan="2">The following file will be attached to this e-mail:<br/>>>>&nbsp;&nbsp;<font color="red"><?php echo 'ssas_config_information.xls' ?></font></th>
			</tr>

			

<?php

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {

?>

	<tr class="Row">
	
		<td>	
			<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
				Customer's e-mail address: <input name="mail_address" type="text" id="mail_address" size="30" maxlength="50">
				<input class="Button" name="send_mail" type="submit" value="send mail">
			</form>
		</td>
		<td>
			<a href="page3.php"><div align="right"><STRONG>CANCEL</STRONG></div></a>
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

<?php


} else {

	if ( $_REQUEST['mail_address'] != '' ) {
	
		// Include the phpmailer class
		require 'ThirdParty/phpmailer/class.phpmailer.php';
		// Instantiate it
		$mail = new phpmailer();
		
		// Define who the message is from
		$mail->From = 'marine@hss-panama.com';
		$mail->FromName = 'High Sea Support - Service Coordination';
		
		// Set the subject of the message
		$mail->Subject = 'SSAS configuration information required for Service.';
		
		// Add the body of the message
		$body = 'Dear Sir(s), In order to do a better and faster job on M/V Barcelona\'s SSAS terminal please fill out the attached form and sent the document back to marine@hss-panama.com';
		
		$mail->Body = $body;
		
		// Add a recipient address
		$mail->AddAddress( $_REQUEST['mail_address'], 'customer' );
			
		$mail->AddAttachment("ssas_config_information.xls", "ssas_config_information.xls");
		
		
		// Send the message
		if (!$mail->Send()) {
			
			header("Location: page3_0_2.php?status=failed");
			
		} else {
			
			//echo 'Mail has been passed on to SMTP server';
			
			$equip_model = $_REQUEST['EQUIP_MODEL'];
			$order = $_REQUEST['ORDER_NO'];
			$equip_id = $_REQUEST['EQUIP_ID'];
			
			header("Location: page4.php?EQUIP_MODEL=$equip_model&ORDER_NO=$order&EQUIP_ID=$equip_id");
			
		}
		
		// Clear all addresses and attachments for next loop
		$mail->ClearAddresses();
		$mail->ClearAttachments();
	
	} else {
	
		header("Location: page3_0_2.php?status=empty");
	}

}

?>

</body>
</html>

