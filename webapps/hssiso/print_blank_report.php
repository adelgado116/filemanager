<?php

// session check
session_start();
if (!session_is_registered("SESSION")) {
  // if session check fails, invoke error handler
  header("Location: ./error.php");
  exit();
}


require_once('aadv/lib.php');
require_once('fpdf/fpdf.php');
require_once('functions_hssiso.php');

#
#  connect to database
#
include('dbConnect_hssiso.inc');

if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}


#  retrieve report type data from database

$rep_id = $_REQUEST['rep_id'];

$sql = "SELECT * FROM reports_types WHERE rep_id='$rep_id'";
$res2 = mysql_query($sql) or die('Query failed [1]: ' . mysql_error());
$cat_name = mysql_fetch_array($res2, MYSQL_ASSOC);

# list of options
$sql = "SELECT * FROM reports_options_list WHERE rep_id='$rep_id' AND show_option='1'";
$res4 = mysql_query($sql) or die('Query failed [3]: ' . mysql_error());
$options_table = get_table( $res4 );




#################################################################################
class PDF extends FPDF
{
	//Page header
	function Header() {
        //$this->Cell(10);
        //Barcode
		//$this->Image('barcode.png',10,8,33);
		//Arial bold 15
		$this->SetFont('Arial','B',18);
		//Move to the right
		//$this->Cell(30);
		//Title
		$this->Cell(100,10,'Raytheon Anschuetz Panama',0,1,'L');
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
		$this->SetFont('Arial','',8);
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

$lineHeight = 8;
$textSize = 14;

# sequence No.
$pdf->SetXY(110,10);
$pdf->SetFont('Arial','',16);
$pdf->Cell(12,10, 'Deviation Report No. ', 0,0);
$pdf->SetXY(170,10);
$pdf->Cell(30,8, $cat_name['doc_code'].'1', 1, 1, 'C');

$pdf->Ln(3);

$pdf->SetFont('Arial','',$textSize);

$pdf->Cell(35,$lineHeight + 0, 'Failure on: ', 0, 0);
$pdf->Cell(55,$lineHeight + 0, $cat_name['rep_name'], 0, 0, 'L');

$pdf->Cell(40,$lineHeight + 0, '  Memo Internal: ', 'L', 0);
$pdf->Cell(60,$lineHeight + 0, 'N/A', 'R', 1, 'L');

//$pdf->Ln(1);

$pdf->Cell(35,$lineHeight + 0, 'Reference: ', '', 0);
$pdf->Cell(55,$lineHeight + 0, 'N/A', '', 0, 'L');

$pdf->Cell(40,$lineHeight + 0, '  Memo External: ', 'LB', 0);
$pdf->Cell(60,$lineHeight + 0, 'N/A', 'BR', 1, 'L');

//$pdf->Ln(1);

$pdf->Cell(35,$lineHeight + 0, 'Submitted on: ', '', 0);
$pdf->Cell(55,$lineHeight + 0, 'dd / mm / yyyy, hh:ii', '', 1, 'L');

//$pdf->Ln(2);

$pdf->Cell(35,$lineHeight + 0, 'Submitted by: ', '', 0);
$pdf->Cell(55,$lineHeight + 0, 'N/A', '', 1, 'L');

$pdf->Ln(1);

$pdf->Cell(0, 2, '', 'T', 0, 'C');	// horizontal line

$pdf->Ln(1);





# second section

$pdf->SetFont('Arial','',16);
$pdf->Cell(12,10, 'Failure Reasons: ', 0,1);
$pdf->SetFont('Arial','',$textSize);


#
#  identify matching positions for checked options
#
for ( $i = 0; $i <= ( sizeof( $selected_options_list ) - 1 ); $i++ ) {

	for ( $j = 0; $j <= ( sizeof( $options_table ) - 1 ); $j++ ) {
	
		if ( $options_table[ $j ]['rep_opt_id'] == $selected_options_list[ $i ]['rep_opt_id'] ) {
			$index[ $j ] = 'x';
		} 
	}
}


for ( $i = 0; $i <= ( sizeof( $options_table ) - 1 ); $i++ ) {

	// debug
	//$pdf->Cell( 7,  ($lineHeight - 1), $index[$i], 1, 0, 'C' );
	
	$pdf->Cell( 2 );
	
	if ( $index[$i] == 'x' ) {
	
		$pdf->Cell( 7,  ($lineHeight - 1), 'x', 1, 0, 'C' );
		
	} else {
	
		$pdf->Cell( 7,  ($lineHeight - 1), '', 1, 0, 'C' );
	}
	
	$pdf->Cell( 1 );
	$pdf->Cell( 55, $lineHeight, /*$options_table[ $i ]['rep_opt_id'].' '.*/$options_table[ $i ]['rep_option'], '', 1, 'L'); 	
}

$pdf->Cell(17,$lineHeight, 'Other: ', 0, 0, 'L');
$pdf->Cell(171,$lineHeight, $record['other_text'], 1, 1, 'L');


$pdf->SetXY( 10, 164 );

$pdf->Cell(0, 2, '', 'T', 0, 'C');	// horizontal line

//$pdf->Ln(2);


# third section

$textarea_width = 188;
$y_ref = 165;

$pdf->SetXY( 10, $y_ref );

$pdf->Cell(40,$lineHeight, 'Remarks: ', 0, 1, 'L');

$pdf->SetFontSize(12);
$pdf->Rect( 10, ($y_ref + 7), $textarea_width, ($lineHeight - 1) * 3 );
$pdf->MultiCell($textarea_width, $lineHeight - 3 , $record['remarks'], 0, 1, 'L');

$pdf->SetXY( 10, ($y_ref + 28) );

$pdf->SetFontSize(14);
$pdf->Cell(40,$lineHeight, 'Corrective Actions: ', 0, 1, 'L');

$pdf->SetFontSize(12);
$pdf->Rect( 10, ($y_ref + 35), $textarea_width, ($lineHeight - 1) * 3 );
$pdf->MultiCell($textarea_width, $lineHeight - 3 , $record['corrective'], 0, 1, 'L');

$pdf->SetXY(10, ($y_ref + 57) );

$pdf->SetFontSize(14);
$pdf->Cell(40,$lineHeight, 'Proposed Preventive Actions: ', 0, 1, 'L');

$pdf->SetFontSize(12);
$pdf->Rect( 10, ($y_ref + 65), $textarea_width, ($lineHeight - 1) * 3 );
$pdf->MultiCell($textarea_width, $lineHeight - 3 , $record['preventive_proposed'], 0, 1, 'L');

$pdf->SetXY(10, ($y_ref + 86) );

$pdf->SetFontSize(14);
$pdf->Cell(40,$lineHeight, 'Preventive Actions set by Management: ', 0, 1, 'L');

$pdf->SetFontSize(12);
$pdf->Rect( 10, ($y_ref + 94), $textarea_width, ($lineHeight - 1) * 3 );
$pdf->MultiCell($textarea_width, $lineHeight - 3 , ''/*'This report has not been processed by Management.'*/, 0, 1, 'L');


# document version-revision information
$y = 286;
$pdf->SetFont('Arial','', 8);
$pdf->Text( 159, $y, $cat_name['version_revision']);


#
# Generate and save PDF file
#

// save file:
//$filename = 'repository/HSS-'.$cat_name['doc_code'].'-'.$record['sub_cat_id'].'.pdf';
//$pdf->Output( $filename, 'F' );

// send file to browser:
$pdf->Output( date('dmY').'.pdf', 'I' );





?>
