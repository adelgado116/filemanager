<?php

require_once('Database/MySQL.php');
require_once('aadv/lib.php');
require_once('fpdf/fpdf.php');


#
#  bring all service data from database
#
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');


$sql = "SELECT MAX(sequence_no) FROM service_returned_parts_tbl";
$res1 = $db->query($sql);
$meta = $res1->fetch();

$max_id = $meta['MAX(sequence_no)'];



$date = date('d-m-Y');

$sql = "UPDATE service_returned_parts_tbl
		SET submit_date='$date'
		WHERE sequence_no='$max_id'";
$result = $db->query($sql);




$sql = "SELECT * FROM service_returned_parts_tbl WHERE sequence_no='$max_id'";
$res2 = $db->query($sql);
$data = $res2->fetch();

$meta_2 = $data['emp_id'];
$meta_3 = $data['return_type_id'];
$meta_4 = $data['MANUF_ID'];
$meta_5 = $data['ORDER_NO'];


$sql = "SELECT emp_login FROM employees_tbl WHERE emp_id='$meta_2'";
$res3 = $db->query($sql);
$employees = $res3->fetch();

$sql = "SELECT return_type FROM service_return_type_tbl WHERE return_type_id='$meta_3'";
$res4 = $db->query($sql);
$types = $res4->fetch();

$sql = "SELECT MANUF_NAME FROM equipment_manufacturer_tbl WHERE MANUF_ID='$meta_4'";
$res5 = $db->query($sql);
$manufacturers = $res5->fetch();





if ( $meta_5 == "RANINT" ) {
	
	$path = '../../internal_returned_part_sheets/RP';
	$shipname = "VOID";
	
} else {

	$sql = "SELECT IMO_NUMBER FROM service_tbl WHERE ORDER_NO='$meta_5'";
	$res6 = $db->query($sql);
	$services = $res6->fetch();
	
	$imo = $services['IMO_NUMBER'];
	
	$path = '../../knowledgebase/'.$imo.'/'.$meta_5.'/additional_docs/RP';
	
	$sql = "SELECT SHIP_NAME FROM ships_tbl WHERE IMO_NUMBER='$imo'";
	$res7 = $db->query($sql);
	$ships = $res7->fetch();
	
	$shipname = $ships['SHIP_NAME'];
	
	
}



#################################################################################
class PDF extends FPDF
{
	//Page header
	function Header() {
        $this->Cell(10);
        //Barcode
		//$this->Image('barcode.png',10,8,33);
		//Arial bold 15
		$this->SetFont('Arial','B',18);
		//Move to the right
		$this->Cell(30);
		//Title
		$this->Cell(100,10,'Returned Parts Sheet',0,1,'C');
		//Horizontal line to separate header
		$this->Cell(0, 2, '', 'T', 0, 'C');
		//Line break
		$this->Ln(5);
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

	//Better table
	function ImprovedTable($header,$data) {

		//Column widths
		$w = array(88,24,24,24);

		//Header
		for($i = 0; $i < count($header); $i++) {
			$this->Cell($w[$i],7,$header[$i],1,0,'C');
		}

		$this->Ln();


		//Data
		foreach($data as $row) {
			$this->Cell($w[0],6,$row[0],'LR');
			$this->Cell($w[1],6,$row[1],'LR',0,'C');

			$this->Cell($w[2],6,$row[2],'LR',0,'C');
			$this->Cell($w[3],6,$row[3],'LR',0,'C');

			#$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
			#$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');

			$this->Ln();
		}
		
		//Closure line
		$this->Cell(array_sum($w),0,'','T');
	}
}
#################################################################################
 
   


   
#
# generate PDF file in server's file system
#
//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();


//$doc_version = "HSS-RP-050110-2-ADE";
$doc_version = "RANPAN-RPS-050416-01-ADE";

$lineHeight = 8;
$textSize = 14;

# sequence No.
$pdf->SetXY(150,10);
$pdf->SetFont('Arial','',16);
$pdf->Cell(12,10, 'No. ', 0,0);
//$pdf->Cell(30,8, 'RP'.$max_id, 1, 1, 'C');
$pdf->Cell(30,8, '', 1, 1, 'C');

$pdf->Ln();

$pdf->SetFont('Arial','',$textSize);

$pdf->Cell(35,$lineHeight + 2, 'RANPAN Order No.: ', 'LTB', 0);
//$pdf->Cell(55,$lineHeight + 2, $data['ORDER_NO'], 'TRB', 1, 'C');
$pdf->Cell(55,$lineHeight + 2, '', 'TRB', 1, 'C');

$pdf->Ln(2);

//$pdf->Cell(45,$lineHeight, 'Date: '.date('d-M-Y'), 1, 0);
$pdf->Cell(45,$lineHeight, 'Date: ', 1, 0);

$pdf->Cell(5);

//$pdf->Cell(40,$lineHeight, 'Technician: '.$employees['emp_login'], 1, 1);
$pdf->Cell(40,$lineHeight, 'Technician: ', 1, 1);

$pdf->Ln(1);


$pdf->Cell(45,$lineHeight, 'Vessel: ', 'LTB', 0);
//$pdf->Cell(140,$lineHeight, /*$ships['SHIP_NAME']*/ $shipname, 'LTRB', 1, 'C');
$pdf->Cell(140,$lineHeight, '', 'LTRB', 1, 'C');

$pdf->Ln(1);

// part info
$pdf->Cell(45,$lineHeight, 'Part Description: ', 'LTB', 0);
//$pdf->Cell(140,$lineHeight, $data['part_description'], 'LTRB', 1, 'C');
$pdf->Cell(140,$lineHeight, '', 'LTRB', 1, 'C');

$pdf->Cell(45,$lineHeight, 'Stock No.:', 'LTB', 0);
//$pdf->Cell(140,$lineHeight, $data['stock_no'], 'LTRB', 1, 'C');
$pdf->Cell(140,$lineHeight, '', 'LTRB', 1, 'C');
$pdf->Cell(45,$lineHeight, 'S/N Defective Part: ', 'LTB', 0);
//$pdf->Cell(140,$lineHeight, $data['sn_defective_part'], 'LTRB', 1, 'C');
$pdf->Cell(140,$lineHeight, '', 'LTRB', 1, 'C');
$pdf->Cell(45,$lineHeight, 'S/N New Part: ', 'LTB', 0);
//$pdf->Cell(140,$lineHeight, $data['sn_new_part'], 'LTRB', 1, 'C');
$pdf->Cell(140,$lineHeight, '', 'LTRB', 1, 'C');

$pdf->Ln(7);

$y = 93.5;
$pdf->Text( 11, $y, "Fault Description:");

$pdf->SetFontSize(12);

$pdf->Rect( 10, 95, 185, $lineHeight * 3 );
//$pdf->MultiCell(185, $lineHeight - 3 , $data['fault_description'], '0', 1, 'L');
$pdf->MultiCell(185, $lineHeight - 3 , '', '0', 1, 'L');

$pdf->SetXY(10,120);

$pdf->SetFontSize(14);

$pdf->Cell(35,$lineHeight, 'Return Part to: ', 'LTB', 0);
//$pdf->Cell(105,$lineHeight, $manufacturers['MANUF_NAME'], 'TRB', 1, 'C');
$pdf->Cell(105,$lineHeight, '', 'TRB', 1, 'C');

$pdf->Ln(0);

$pdf->Cell(80,$lineHeight, 'Supplier Return/Warranty Order No.: ', 'LTB', 0);
if ( $data['supplier_order_no'] == '' ) {
	$supplier_ref_no = 'N/A';
} else {
	$supplier_ref_no = $data['supplier_order_no'];
}
//$pdf->Cell(60,$lineHeight, $supplier_ref_no, 'TRB', 1, 'C');
$pdf->Cell(60,$lineHeight, '', 'TRB', 1, 'C');


$pdf->SetXY(110,26);
$pdf->SetTextColor(255,0,0);
$pdf->SetFont('Arial','B',32);
if ( $data['return_type_id'] == 2 ) {

  $pdf->Cell(85, 15, 'REPAIR', 1, 1, 'C');
  
} else if ( $data['return_type_id'] == 1 ) {

  $pdf->Cell(85, 15, 'WARRANTY', 1, 1, 'C');
}

$pdf->SetXY(110,41);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',14);
$pdf->Cell(85,5,'Attach to Returned Part', 1, 1, 'C');

# document version-revision information
$y = 138;
$pdf->SetFont('Arial','', 6);
//$pdf->Text( 127, $y, $doc_version);
$pdf->Text( 120, $y, $doc_version);


#
# Generate and save PDF file
#

// save file into the $path destination:
$filename = $path.$max_id.'-'.$data['part_description'].'-'.date('dmY').'.pdf';

//$pdf->Output( $path.$max_id.'-'.$data['part_description'].'-'.date('dmY').'.pdf', 'F' );
$pdf->Output( $filename, 'F' );

// send file to browser:
//$pdf->Output( date('dmY').'.pdf', 'I' );

header( 'Location: page3.php?filename='.$filename.'&fname=RP'.$max_id.'&tech='.$employees['emp_login'] );



?>
