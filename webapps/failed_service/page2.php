<?php

require_once('Database/MySQL.php');
require_once('aadv/lib.php');
require_once('fpdf/fpdf.php');


$order = $_REQUEST['ORDER_NO'];
$date = date('d-m-Y');


#
#  bring all service data from database
#
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

$sql = "UPDATE service_failed_tbl
		SET submit_date='$date'
		WHERE ORDER_NO='$order'";
$result = $db->query($sql);


$sql = "SELECT * FROM service_failed_tbl WHERE ORDER_NO='$order'";
$res2 = $db->query($sql);
$data = $res2->fetch();

$meta_2 = $data['emp_id'];
$meta_3 = $data['fault_after_service'];
$meta_4 = $data['failed_service_reason_id'];
$meta_5 = $data['other_reason'];
$meta_6 = $data['action_to_finish'];
$meta_7 = $data['received_by'];


$sql = "SELECT emp_login FROM employees_tbl WHERE emp_id='$meta_2'";
$res3 = $db->query($sql);
$employees = $res3->fetch();

$sql = "SELECT failed_service_reason FROM service_failed_reasons_tbl WHERE failed_service_reason_id='$meta_4'";
$res4 = $db->query($sql);
$failed_reason = $res4->fetch();

$sql = "SELECT emp_login FROM employees_tbl WHERE emp_id='$meta_7'";
$res7 = $db->query($sql);
$received_by = $res7->fetch();


$sql = "SELECT IMO_NUMBER FROM service_tbl WHERE ORDER_NO='$order'";
$res8 = $db->query($sql);
$services = $res8->fetch();

$imo = $services['IMO_NUMBER'];

$path = '../../data/Admin/Service Coordinator Files/Service Raports/'.$imo.'/'.$order.'/additional_docs/';


$sql = "SELECT SHIP_NAME FROM ships_tbl WHERE IMO_NUMBER='$imo'";
$res9 = $db->query($sql);
$ships = $res9->fetch();

$shipname = $ships['SHIP_NAME'];



#################################################################################
class PDF extends FPDF
{
	//Page header
	function Header() {
	
		// logo
		$this->Cell(10);  // spacer
		$this->Image('images/hss_logo.png', 10, 8, 40);  // hss logo
		
		$letterheadStart = 28;
		$width1 = 45;
		
		// horizontal line
		$this->SetXY( 10, ($this->GetY() + 35) );
		$this->Cell(0, 10, '', 'T', 0, 'C');  //Horizontal line
		$this->Ln(5);  //Line break
		
		// Title
		$this->SetXY(100,11);
		$this->SetFont('Arial','B',24);  //Arial bold 20
		$this->Cell(100,10,'Failed Service Report',0,1,'C');  //Title

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
		$w = array(50,21,21,21,21);

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
			$this->Cell($w[0], $cellHeight, $row[0], 1,0,'C');
			$this->Cell($w[1], $cellHeight, $row[1], 1,0,'C');
			$this->Cell($w[2], $cellHeight, $row[2], 1,0,'C');
			$this->Cell($w[3], $cellHeight, $row[3], 1,0,'C');
			$this->Cell($w[4], $cellHeight, $row[4], 1,0,'C');

			$this->Ln();
		}
	}
		
	// 6 columns Table
	function ImprovedTable2($header,$data, $left_margin) {

		//Column heights
		$cellHeight = 4.25;
		//Column widths
		$w = array(15,49,30,28,28,34);

		//Header
		$this->SetFont('Arial','B',8);
		for($i = 0; $i < count($header); $i++) {
			$this->Cell($w[$i], ($cellHeight ),$header[$i],1,0,'C');
		}

		$this->Ln();


		//Data
		$this->SetFont('Arial','',8);
		foreach($data as $row) {
			
			//$this->Cell(1);
			$this->Cell($left_margin);
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

#
# generate PDF file in server's file system
#

// layout parameters
$lineOffSet = 6;
$lineHeight = 4;
$fieldHeight = 10;
$textSize = 7;
$label_top = 2.5;
$input_data = 12;
$section1 = 46;
$section2 = $section1 + 33;

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// order number
$pdf->SetXY(100,27);
$pdf->SetFont('Arial','',16);  //Arial normal 16
if ( $order == '' ) {

	$pdf->Cell(100,10, 'Order No.:  N/A', 0,1,'C');
	
} else {
	
	$pdf->Cell(100,10, 'Order No.:  '.$order, 0,1,'C');
}



// date
$pdf->SetXY(100,35);
$pdf->SetFont('Arial','',12);  //Arial normal 16
$pdf->Cell(100,10, 'Date:  '.date('j / M / Y'), 0,1,'C');


#
# report body (frames)
#

# section 1
$pdf->SetXY(10, $section1);

$pdf->SetFont('Arial','', $textSize);

$x_start = 10;
$pdf->Rect($x_start, $section1, 93, $fieldHeight);
$pdf->Text($x_start, $section1 + $label_top, " VESSEL");
$pdf->Rect($x_start, $section1 + ($fieldHeight + 1), 93, $fieldHeight);
$pdf->Text($x_start, $section1 + ($fieldHeight + 1) + $label_top, " TECHNICIAN");
$pdf->Rect($x_start, $section1 + (($fieldHeight + 1) * 2), 190, $fieldHeight);
$pdf->Text($x_start, $section1 + (($fieldHeight + 1) * 2) + $label_top, " EQUIPMENT");

# section 2
$pdf->Rect($x_start, $section2, 190, $fieldHeight * 5);
$pdf->Text($x_start, $section2 + $label_top, " FAULT DESCRIPTION AFTER SERVICE");

$pdf->Rect($x_start, $section2 + ( ($fieldHeight * 5) + 1 ), 190, $fieldHeight);
$pdf->Text($x_start, $section2 + ( ($fieldHeight * 5) + 1 ) + $label_top, " REASON WHY SERVICE FAILED");

$pdf->Rect($x_start, $section2 + 51 + ($fieldHeight + 1), 190, $fieldHeight * 4);
$pdf->Text($x_start, $section2 + 51 + ($fieldHeight + 1) + $label_top, " OTHER REASONS (FOR SERVICE FAILURE)");

$pdf->Rect($x_start, $section2 + 92 + ($fieldHeight + 1), 190, $fieldHeight * 4);
$pdf->Text($x_start, $section2 + 92 + ($fieldHeight + 1) + $label_top, " ACTION TO FINISH THE SERVICE");

$pdf->Rect($x_start, $section2 + 147 + ($fieldHeight + 1), 93, $fieldHeight);
$pdf->Text($x_start, $section2 + 147 + ($fieldHeight + 1) + $label_top, " RECEIVED BY");


# document version-revision information
$y = 247;
$pdf->SetFont('Arial','', 6);
$pdf->Text(80, $y + $label_top, "HSS-FS010709-Rev.A");



#
# report body (data)
#

$pdf->SetFont('Arial','', $input_data);
$left = 28;

$pdf->Text($left, 54, $shipname);
$pdf->Text($left, 65, $employees['emp_login']);

$pdf->Text($left, 76, $_REQUEST['MANUF_NAME'].' - '.$_REQUEST['EQUIP_TYPE'].' - '.$_REQUEST['EQUIP_MODEL']);

$pdf->SetXY( 13, 83 );
$pdf->MultiCell( 184, 4, $meta_3, 0, '' );

$pdf->Text($left, 138, $failed_reason['failed_service_reason']);

$pdf->SetXY( 13, 145 );
$pdf->MultiCell( 184, 4, $meta_5, 0, '' );

$pdf->SetXY( 13, 186 );
$pdf->MultiCell( 184, 4, $meta_6, 0, '' );

$pdf->Text($left, 245, $received_by['emp_login']);


#
# Generate and save PDF file
#

// save file into the $path destination:
$pdf->Output( $path.$order.'_failed_service_report.pdf', 'F' );

// send file to browser:
$pdf->Output( date('dmY').'.pdf', 'I' );


?>
