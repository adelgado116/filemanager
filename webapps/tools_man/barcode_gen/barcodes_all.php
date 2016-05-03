<?php

/*******************************************************
	- get all tool_id's from database
	- generate all barcodes
	- print barcodes to a pdf file
*******************************************************/

require_once('Database/MySQL.php');
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

require_once('code128.class.php');

	#
	# Get data from employees table
	#
	$sql = "SELECT tool_id FROM tools";
	
	$result = $db->query($sql);
	
	while ( $row = $result->fetch() ) {
	
		$tool_id = $row['tool_id'];
		
		
		#
		#  Generate Barcode
		#
		$barcode = new phpCode128('HSS_TID'.$tool_id, 70, 'Dustismo_Roman.ttf', 12);
		// hide barcode text
		$barcode->setEanStyle(TRUE);
		$barcode->setShowText(TRUE);
		// remove barcode border
		$barcode->setBorderWidth(0);
		$barcode->setBorderSpacing(0);
		// setPixelWidth set to 2
		$barcode->setPixelWidth(2);
		$barcode->setAutoAdjustFontSize(FALSE);
		$barcode->setTextSpacing(5);
		// save barcode image
		$barcode->saveBarcode("tools_barcodes/HSS_TID".$tool_id.".png");
		
		
		echo "<img src=\"tools_barcodes/HSS_TID".$tool_id.".png\" /><br>";

	}




?>


<!-- <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>barcodes print :: </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body style="font-family: Verdana; font-size: 14pt;">


</body>
</html> -->
