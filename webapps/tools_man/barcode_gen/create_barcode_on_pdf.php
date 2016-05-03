<?php

require_once('fpdf/fpdf.php');


$tid = $_REQUEST['tool_id'];


$pdf=new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('tools_barcodes/HSS_TID'.$tid.'.png', 1, 1, 40);  // hss logo

// save file:
//$pdf->Output( 'tools_barcodes/HSS_TID'.$tid.'.pdf', 'F' );

// send file to browser:
$pdf->Output( 'tools_barcodes/HSS_TID'.$tid.'.pdf', 'I' );


?>
