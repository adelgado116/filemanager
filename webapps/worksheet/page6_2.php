<?php

session_start();

require_once('Database/MySQL.php');
require_once('fpdf/fpdf.php');


$order = $_SESSION['ORDER'];


/*
don't know why  $_SESSION['SHIPNAME']  is lost after sending
data for new equipment on page4.php
will have to force SHIPNAME by reading database on this page
using $order variable.
*/

require_once('Database/MySQL.php');

$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

$sql = "SELECT IMO_NUMBER FROM service_tbl WHERE ORDER_NO='$order'";
$res1 = $db->query($sql);
$row1 = $res1->fetch();
$imo = $row1['IMO_NUMBER'];

$sql = "SELECT SHIP_NAME FROM ships_tbl WHERE IMO_NUMBER='$imo'";
$res2 = $db->query($sql);
$row2 = $res2->fetch();
$shipname = $row2['SHIP_NAME'];


#################################################################################
class PDF extends FPDF
{
	//Page header
	function Header() {

        // page margins (used to position objects into page)
/*        $this->Rect(10, 10, 190, 270);

        // page center line
        $this->Rect(10, 10, 95, 270);

        // page horizontal markers
        $this->Rect(0, 0, 210, 50);
        $this->Rect(0, 0, 210, 100);
        $this->Rect(0, 0, 210, 150);
        $this->Rect(0, 0, 210, 200);
        $this->Rect(0, 0, 210, 250);
*/

        // logo
		$this->Cell(10);  // spacer
		$this->Image('images/hss_logo.png', 10, 10, 40);  // hss logo

		$letterheadStart = 28;
		$width1 = 45;

		// horizontal line
		$this->SetXY( 10, 31 );
		$this->Cell(0, 10, '', 'T', 0, 'C');  //Horizontal line
		$this->Ln(5);  //Line break

		// Title
		$this->SetXY(50,12);
		$this->SetFont('Arial','B',23);  //Arial bold 28
		$this->Cell(100,9,'Customer Satisfaction',0,1,'C');  //Title
		$this->Cell(180,9,'Form',0,1,'C');

	}

	//Page footer
	function Footer() {
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Page number
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}

	// 4 columns Table
	function ImprovedTable($header,$data) {

		//Column heights
		$cellHeight = 5;
		//Column widths
		$w = array(50,21,21,21);

		//Header
		$this->SetFont('Arial','B',8);
		for($i = 0; $i < count($header); $i++) {
			$this->Cell($w[$i], ($cellHeight - 1),$header[$i],1,0,'C');
		}

		$this->Ln();


		//Data
		$this->SetFont('Arial','',8);
		foreach($data as $row) {

			$this->Cell(1);
			$this->Cell($w[0], $cellHeight, $row[0], 1);
			$this->Cell($w[1], $cellHeight, $row[1], 1,0,'C');
			$this->Cell($w[2], $cellHeight, $row[2], 1,0,'C');
			$this->Cell($w[3], $cellHeight, $row[3], 1,0,'C');

			$this->Ln();
		}
	}

	// 6 columns Table
	function ImprovedTable2($header,$data) {

		//Column heights
		$cellHeight = 4.25;
		//Column widths
		$w = array(15,49,30,28,28,35);

		//Header
		$this->SetFont('Arial','B',8);
		for($i = 0; $i < count($header); $i++) {
			$this->Cell($w[$i], ($cellHeight ),$header[$i],1,0,'C');
		}

		$this->Ln();


		//Data
		$this->SetFont('Arial','',8);
		foreach($data as $row) {

			$this->Cell(1);
			$this->Cell($w[0], $cellHeight, $row[0], 1,0,'C');
			$this->Cell($w[1], $cellHeight, $row[1], 1,0,'C');
			$this->Cell($w[2], $cellHeight, $row[2], 1,0,'C');
			$this->Cell($w[3], $cellHeight, $row[3], 1,0,'C');
			$this->Cell($w[4], $cellHeight, $row[4], 1,0,'C');
			$this->Cell($w[5], $cellHeight, $row[5], 1,0,'C');

			$this->Ln();
		}

		//Closure line
		#$this->Cell(array_sum($w),0,'','T');
	}
}
#################################################################################


// layout parameters
$lineOffSet = 6;
$lineHeight = 4;
$fieldHeight = 5;
$textSize = 7;
$label_top = 2.5;
$input_data = 12;
$section1 = 35;
$section2 = $section1 + 39.5;


//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// order number
$pdf->SetXY(125,10);
$pdf->SetFont('Arial','',16);  //Arial normal 16
if ( $order == '' ) {

	$pdf->Cell(100,10, 'Order No.:  N/A', 0,1,'C');
	
} else {
	
	$pdf->Cell(100,10, 'Order No.:  '.$order, 0,1,'C');
	//$pdf->Cell(100,10, 'Order No.:  _______', 0,1,'C');
}


// page number
$pageNo = 1;
$totalPages = 1;

$pdf->SetXY(125,17);
$pdf->SetFont('Arial','',12);  //Arial normal 16
$pdf->Cell(100,10, '(Page '.$pageNo.' of '.$totalPages.')', 0,1,'C');		// ! enhanced - make page counting


// date
$pdf->SetXY(125,23);
$pdf->SetFont('Arial','',12);  //Arial normal 16
$pdf->Cell(100,10, 'Date:  __ / __ / ____', 0,1,'C');


#
# document body (frames)
#

# section 1
$pdf->SetXY(10, $section1);

$pdf->SetFont('Arial','', $textSize);

$x_start = 10;
$pdf->Rect($x_start, $section1, 190, 10);
$pdf->Text($x_start, $section1 + $label_top, " CUSTOMER / VESSEL NAME");
$pdf->Rect($x_start, $section1 + 10, 20, 10);
$pdf->Text($x_start, $section1 + 10 + $label_top + 3, " TECHNICIAN(S)");
$pdf->Rect($x_start + 20, $section1 + 10, 56.6, 10);
$pdf->Rect($x_start + 20 + 56.6, $section1 + 10, 56.6, 10);
$pdf->Rect($x_start + 20 + (56.6 * 2), $section1 + 10, 56.8, 10);

$pdf->SetFont('Arial','', $textSize + 5);
$pdf->Text($x_start, $section1 + 28, " SERVICE EVALUATION");

$pdf->SetFont('Arial','', $textSize + 3);

$pdf->SetXY($x_start + 90, $section1 + 27);
$pdf->Cell(25,9, 'EXCELLENT', 1,0,'C');
$pdf->Cell(25,9, 'GOOD', 1,0,'C');
$pdf->Cell(25,9, 'AVERAGE', 1,0,'C');
$pdf->Cell(25,5, 'POOR', 'LTR',0,'C');

$pdf->SetFont('Arial','', $textSize - 1);
$pdf->SetXY($x_start + 90 + 75, $section1 + 31);
$pdf->Cell(25,5, 'please make comments', 'LBR',0,'C');


# table cells
for ( $i = 0; $i <= 3; $i++ ) {

	$pdf->Rect($x_start, $section1 + 36 + ($i * 7), 90, 7);
	$pdf->Rect($x_start + 90, $section1 + 36 + ($i * 7), 25, 7);
	$pdf->Rect($x_start + 115, $section1 + 36 + ($i * 7), 25, 7);
	$pdf->Rect($x_start + 140, $section1 + 36 + ($i * 7), 25, 7);
	$pdf->Rect($x_start + 165, $section1 + 36 + ($i * 7), 25, 7);
}

$pdf->SetFont('Arial','', $textSize + 5);
$pdf->Text($x_start, $section1 + 41, " Technician's Performance");
$pdf->Text($x_start, $section1 + 48, " Overall Service Coordination");
$pdf->Text($x_start, $section1 + 55, " Accomplishment of Requested Services");
$pdf->Text($x_start, $section1 + 62, " Quality of Service");

$pdf->SetFont('Arial','', $textSize + 5);
$pdf->Text($x_start, $section1 + 72, " COMMENTS");

$pdf->SetXY( $x_start, $section1 + 79 );
$pdf->Cell(129, 10, '', 'T', 0, 'C');  // Horizontal line
$pdf->SetXY( $x_start, $section1 + 85 );
$pdf->Cell(129, 10, '', 'T', 0, 'C');
$pdf->SetXY( $x_start, $section1 + 91 );
$pdf->Cell(129, 10, '', 'T', 0, 'C');
$pdf->SetXY( $x_start, $section1 + 97 );
$pdf->Cell(129, 10, '', 'T', 0, 'C');


# last section - stamp & signature fields     - FIXED POSITION -
$pdf->SetFont('Arial', '', $textSize);
$pdf->Rect($x_start + 133, $section1 + 70, 57, 27);
$pdf->Text($x_start + 133, $section1 + 70 + $label_top, ' SIGNATURE OF SHIP\'S OFFICER IN CHARGE');
$pdf->Text($x_start + 133, $section1 + 70 + $label_top + 3, ' AND STAMP');


# document version-revision information
$y = 130;
$pdf->SetFont('Arial','', 6);
//$pdf->Text(176, $y + $label_top + 2.5, "HSS-CS-210809-1-ADE");
$pdf->Text(176-4, $y + $label_top + 2.5, "RANPAN-CS-050416-01-ADE");




#
# document body (data)
#

# section 1
$pdf->SetXY(10, $section1);

$pdf->SetFont('Arial','', $textSize + 5);

$x_start = 10;

$pdf->Text($x_start + 37, $section1 + 6, /* $_SESSION['SHIPNAME'] */ $shipname);



// send file to browser:
$pdf->Output( date('dmY').'.pdf', 'I' );


?>
