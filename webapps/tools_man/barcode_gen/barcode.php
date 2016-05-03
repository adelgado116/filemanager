<?php

require_once('code128.class.php');

#
# generate a barcode for tool_id
#	
$barcode = new phpCode128('HSS_TID'.$_REQUEST['tool_id'], 70, 'Dustismo_Roman.ttf', 12);
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
$barcode->saveBarcode("tools_barcodes/HSS_TID".$_REQUEST['tool_id'].".png");

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>barcode print :: </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body style="font-family: Verdana; font-size: 14pt;">

<table>
	<tr>
		<td>
			<?php
				echo '<br><img src="tools_barcodes/HSS_TID'.$_REQUEST['tool_id'].'.png" /><br><br>';
			?>
		</td>
		<td width="350" align="center">
			<!-- <a href="#" onClick="window.print()">send this barcode<br/>to a printer</a> -->
			<?php
				echo '<a href="print_barcode.php?tool_id='.$_REQUEST['tool_id'].'">Click here to<br/>Print this barcode</a>';
			?>
		</td>
	</tr>
</table>


</body>
</html>
