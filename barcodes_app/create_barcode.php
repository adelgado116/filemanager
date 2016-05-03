<?php

require_once('code128.class.php');

#
#  Generate Barcode
#
$barcode = new phpCode128('MSG_4', 70, 'Dustismo_Roman.ttf', 12);
// hide barcode text
$barcode->setEanStyle(FALSE);
$barcode->setShowText(FALSE);
// remove barcode border
$barcode->setBorderWidth(0);
$barcode->setBorderSpacing(0);
// setPixelWidth set to 2
$barcode->setPixelWidth(2);
$barcode->setAutoAdjustFontSize(FALSE);
$barcode->setTextSpacing(5);
// save barcode image
$barcode->saveBarcode("msg_4.png");


echo "<img src=\"msg_4.png\" />";


?>
