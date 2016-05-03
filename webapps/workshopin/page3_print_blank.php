<?php

require_once('Database/MySQL.php');
require_once('aadv/lib.php');
require_once('fpdf/fpdf.php');


/*
#
#  bring all service data from database
#
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');


$sql = "SELECT MAX(workshop_in_id) FROM workshop_repair";
$res1 = $db->query($sql);
$meta = $res1->fetch();

$max_id = $meta['MAX(workshop_in_id)'];

$date = date('d-m-Y');
$sql = "UPDATE workshop_repair
		SET date_received='$date'
		WHERE workshop_in_id='$max_id'";
$result = $db->query($sql);


$sql = "SELECT * FROM workshop_repair WHERE workshop_in_id='$max_id'";
$res2 = $db->query($sql);
$data = $res2->fetch();

$meta_2 = $data['emp_id'];

$sql = "SELECT emp_login FROM employees_tbl WHERE emp_id='$meta_2'";
$res3 = $db->query($sql);
$employees = $res3->fetch();

*/

#################################################################################
class PDF extends FPDF
{
	//Page header
	function Header() {
	
		// logo
		$this->Cell(10);  // spacer
		$this->Image('images/ran_logo.png', 10, 8, 40);  // hss logo
		
		$letterheadStart = 28;
		//$width1 = 45;
                $width1 = 55;
		
		// address
		$address = "Raytheon Anschuetz Panama, S. de R.L.\nCiudad del Saber, Clayton\nBuilding 225\nPanama City\nRepublic of Panama";
		$this->SetXY(9, $letterheadStart);
		$this->SetFont('Arial','',8);  //Arial normal 9
		$this->MultiCell($width1,3, $address,0,1);
		
		// contact
		$contactLabels = "Main:\nFax:\n24 Hours:\ne-mail:\nwebsite:";
		$contactData = "+507 303 5500\n+507 303 5515\n+507 6672 7676\nservice@raypanama.com\nwww.raytheon-anschuetz.com";
		$this->SetXY((57+7), $letterheadStart);
		$this->Cell(2,15, '', 'L', 0);
		$this->SetFont('Arial','',8);  //Arial normal 9
		$this->MultiCell($width1 ,3, $contactLabels,0,'L');
		$this->SetXY( ($width1 + 16 + 7), $letterheadStart);
		$this->MultiCell($width1,3, $contactData,0,'L');
		
		// horizontal line
		$this->SetXY( 10, ($this->GetY() + 2) );
		$this->Cell(0, 10, '', 'T', 0, 'C');  //Horizontal line
		$this->Ln(5);  //Line break
		
		// Title
		$this->SetXY(100,11);
		$this->SetFont('Arial','B',24);  //Arial bold 20
		$this->Cell(100,10,'Warehouse Goods Receipt',0,1,'C');  //Title

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
			$this->Cell($w[0], $cellHeight, $row[0], 1,0,'C');
			$this->Cell($w[1], $cellHeight, $row[1], 1,0,'C');
			$this->Cell($w[2], $cellHeight, $row[2], 1,0,'C');
			$this->Cell($w[3], $cellHeight, $row[3], 1,0,'C');

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
$fieldHeight = 5;
$textSize = 7;
$label_top = 2.5;
$input_data = 12;
$section1 = 46;
$section2 = $section1 + 39.5;

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();



// order number
$pdf->SetXY(118,27);
$pdf->SetFont('Arial','',16);  //Arial normal 16

$pdf->Cell(100,10, 'Receipt No.:  _________', 0,1,'C');


// date
$pdf->SetXY(118,35);
$pdf->SetFont('Arial','',12);  //Arial normal 16
$pdf->Cell(100,10, 'Date:  __ / __ / ____', 0,1,'C');


#
# form body (frames)
#

$pdf->SetXY(10, $section1);

$pdf->SetFont('Arial','', $textSize);

$x_start = 10;
$pdf->Rect($x_start, $section1, 93, 7.5);
$pdf->Text($x_start, $section1 + $label_top, " VESSEL");
$pdf->Rect($x_start, $section1 + 7.5, 93, 7.5);
$pdf->Text($x_start, $section1 + 7.5 + $label_top, " IMO");
$pdf->Rect($x_start, $section1 + 7.5 * 2, 93, 7.5);
$pdf->Text($x_start, $section1 + (7.5 * 2) + $label_top, " CUSTOMER");
$pdf->Rect($x_start, $section1 + 7.5 * 3, 93, 7.5);
$pdf->Text($x_start, $section1 + (7.5 * 3) + $label_top, " CUSTOMER PHONE");
$pdf->Rect($x_start, $section1 + 7.5 * 4, 93, 7.5);
$pdf->Text($x_start, $section1 + (7.5 * 4) + $label_top, " CUSTOMER EMAIL");

$pdf->Rect($x_start, $section1 + (7.5 * 5) + 1, 190, 20);
$pdf->Text($x_start, $section1 + (7.5 * 5) + $label_top + 1, " EQUIPMENT CONDITION / CUSTOMER REQUEST");

$x_start = 104;
$pdf->Rect($x_start, $section1, 96, 7.5);
$pdf->Text($x_start, $section1 + $label_top, " EQUIPMENT TYPE");
$pdf->Rect($x_start, $section1 + 7.5, 96, 7.5);
$pdf->Text($x_start, $section1 + 7.5 + $label_top, " MANUFACTURER");
$pdf->Rect($x_start, $section1 + 7.5 * 2, 96, 7.5);
$pdf->Text($x_start, $section1 + (7.5 * 2) + $label_top, " MODEL");
$pdf->Rect($x_start, $section1 + 7.5 * 3, 96, 7.5);
$pdf->Text($x_start, $section1 + (7.5 * 3) + $label_top, " PART NO");
$pdf->Rect($x_start, $section1 + 7.5 * 4, 96, 7.5);
$pdf->Text($x_start, $section1 + (7.5 * 4) + $label_top, " S/N");

$x_start = 10;
$y = 110;

$pdf->SetFont('Arial','',$textSize);
$pdf->Rect(10, $y, 93, 10);
$pdf->Text(10, $y + $label_top, ' RECEIVED BY');


# document version-revision information
$y = 119;
$pdf->SetFont('Arial','', 6);
$pdf->Text( 78, $y + $label_top + 1, "HSS-WR-230409-1-ADE");



// cut here indication
$pdf->SetXY( 10, 126 );
$pdf->Cell(0, 10, '_____   _____   _____   _____   _____   _____   _____   _____   _____   _____   _____   _____  cut here  _____   _____   _____   _____   _____   _____   _____   _____   _____   _____   _____   _____', '', 0, 'C');  //Horizontal line
$pdf->Ln(5);  //Line break



//  internal workshop repair worksheet

$x_start = 18;

// Title
$pdf->SetXY( $x_start, 140 );
$pdf->SetFont('Arial','B',24);  //Arial bold 20
$pdf->Cell(100,10,'Warehouse Goods Receipt',0,1,'C');
$pdf->Ln(0.3);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(118,10,'(attach this form to the equipment)',0,1,'C');

// order number
$pdf->SetXY( $x_start - 8, 160 );
$pdf->SetFont('Arial','',16);  //Arial normal 16

$pdf->Cell(100,10, 'Receipt No.:  _________', 0,1,'L');


// date
$pdf->SetXY( $x_start - 8, 167 );
$pdf->SetFont('Arial','',12);  //Arial normal 16
$pdf->Cell(100,10, 'Date:  __ / __ / ____', 0,1,'L');

// horizontal line
$pdf->SetXY( 10, 176 );
$pdf->Cell(0, 10, '', 'T', 0, 'C');  //Horizontal line


#
# form body (frames)
#

$section1 = 177;

$pdf->SetXY(10, $section1);

$pdf->SetFont('Arial','', $textSize);

$x_start = 10;
$pdf->Rect($x_start, $section1, 93, 7.5);
$pdf->Text($x_start, $section1 + $label_top, " VESSEL");
$pdf->Rect($x_start, $section1 + 7.5, 93, 7.5);
$pdf->Text($x_start, $section1 + 7.5 + $label_top, " IMO");
$pdf->Rect($x_start, $section1 + 7.5 * 2, 93, 7.5);
$pdf->Text($x_start, $section1 + (7.5 * 2) + $label_top, " CUSTOMER");
$pdf->Rect($x_start, $section1 + 7.5 * 3, 93, 7.5);
$pdf->Text($x_start, $section1 + (7.5 * 3) + $label_top, " CUSTOMER PHONE");
$pdf->Rect($x_start, $section1 + 7.5 * 4, 93, 7.5);
$pdf->Text($x_start, $section1 + (7.5 * 4) + $label_top, " CUSTOMER EMAIL");

$pdf->Rect($x_start, $section1 + (7.5 * 5) + 1, 190, 20);
$pdf->Text($x_start, $section1 + (7.5 * 5) + $label_top + 1, " EQUIPMENT CONDITION / CUSTOMER REQUEST");

$x_start = 104;
$pdf->Rect($x_start, $section1, 96, 7.5);
$pdf->Text($x_start, $section1 + $label_top, " EQUIPMENT TYPE");
$pdf->Rect($x_start, $section1 + 7.5, 96, 7.5);
$pdf->Text($x_start, $section1 + 7.5 + $label_top, " MANUFACTURER");
$pdf->Rect($x_start, $section1 + 7.5 * 2, 96, 7.5);
$pdf->Text($x_start, $section1 + (7.5 * 2) + $label_top, " MODEL");
$pdf->Rect($x_start, $section1 + 7.5 * 3, 96, 7.5);
$pdf->Text($x_start, $section1 + (7.5 * 3) + $label_top, " PART NO");
$pdf->Rect($x_start, $section1 + 7.5 * 4, 96, 7.5);
$pdf->Text($x_start, $section1 + (7.5 * 4) + $label_top, " S/N");

$x_start = 10;
$y = 242;

$pdf->SetFont('Arial','',$textSize);
$pdf->Rect(10, $y, 93, 10);
$pdf->Text(10, $y + $label_top, ' RECEIVED BY');


# document version-revision information
$y = 251;
$pdf->SetFont('Arial','', 6);
$pdf->Text( 78, $y + $label_top + 1, "HSS-WR-230409-1-ADE");









#
# form body (data)
#

$pdf->SetFont('Arial','', $input_data);
$left = 32;
$right = 127;
$y = 51;

$pdf->Text($left, $y, '');
$pdf->Text($left, $y + 8, '');
$pdf->Text($left, $y + 16, '');
$pdf->Text($left, $y + 24, '');
$pdf->Text($left, $y + 32, '');

$pdf->Text($right, $y, '');
$pdf->Text($right, $y + 8, '');
$pdf->Text($right, $y + 16, '');
$pdf->Text($right, $y + 24, '');
$pdf->Text($right, $y + 32, '');

$pdf->Text($left, $y + 65, '');

$pdf->SetXY( 13, $y + 38 );
$pdf->MultiCell( 184, 4, '', 0, '' );

#
# reprint data for internal document.
#

$y = 182;

$pdf->Text($left, $y, '');
$pdf->Text($left, $y + 8, '');
$pdf->Text($left, $y + 16, '');
$pdf->Text($left, $y + 24, '');
$pdf->Text($left, $y + 32, '');

$pdf->Text($right, $y, '');
$pdf->Text($right, $y + 8, '');
$pdf->Text($right, $y + 16, '');
$pdf->Text($right, $y + 24, '');
$pdf->Text($right, $y + 32, '');

$pdf->Text($left, $y + 65, '');

$pdf->SetXY( 13, $y + 38 );
$pdf->MultiCell( 184, 4, '', 0, '' );


#
# Generate and save PDF file
#

//$path = '../../workshop_repair_log/WR';

// save file into the $path destination:
//$pdf->Output( $path.'blank.pdf', 'F' );

// send file to browser:
$pdf->Output( date('dmY').'.pdf', 'I' );


?>
