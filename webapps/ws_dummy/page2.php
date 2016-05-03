<?php
  
    require_once('aadv/lib.php');
    require_once('fpdf/fpdf.php');
    require_once('Database/MySQL.php');

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
		$this->SetXY(50,13);
		$this->SetFont('Arial','B',28);  //Arial bold 20
		$this->Cell(100,10,'Worksheet',0,1,'C');  //Title

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
    
    
    
  $db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');


  #
  #  retrieve from database all service data to be printed on worksheet
  #
  $sql = "SELECT * FROM ws_dummy WHERE worksheet_id='1'";
	$res1 = $db->query($sql);
	$rowService = $res1->fetch();  // array with service_tbl data

  $worksheetData = array( "SHIP"=>$rowService['shipname'],  
                          "COUNTRY"=>$rowService['country'],
                          "PORT"=>$rowService['port'],
                          "AGENT"=>$rowService['agent'],
						  "agent_phone_1"=>$rowService['agent_phone_1'],
						  "agent_phone_2"=>$rowService['agent_phone_2'],
						  "agent_fax"=>$rowService['agent_fax'],
						  "agent_email"=>$rowService['agent_email'],
						  "agent_mobile"=>$rowService['agent_mobile'],
						  "agent_boarding"=>$rowService['agent_boarding'] );
						  
	$worksheetData2 = array( "SERVICE"=>$rowService['service_type'],
                             "EQUIPMENT"=>$rowService['equipment'],
                             "APPROVEDBY"=>$rowService['approved_by'],
							 "WARRANTY"=>$rowService['warranty'] );

	#
    # generate PDF file(s) -- create_worksheet()
    #
		
	// call function to generate worksheet
	//create_worksheet( $worksheetData, $worksheetData2, $rowService, $rowItem , $i, $qty_items, $path_suffix, $path );
	create_worksheet( $worksheetData, $worksheetData2, $rowService , 1, 1 );


#
#
#  (PDF) WORSHEET GENERATION FUNCTION
#
#
//function create_worksheet( $wsData, $wsData2, $serviceData, $itemData, $pageNo, $totalPages, $path_root, &$path_complete ) {
function create_worksheet( $wsData, $wsData2, $serviceData, $pageNo, $totalPages ) {

         //Instanciation of inherited class
         $pdf=new PDF();
         $pdf->AliasNbPages();
         $pdf->AddPage();

         // order number
         $pdf->SetXY(110,10);
         $pdf->SetFont('Arial','',16);  //Arial normal 16
         $pdf->Cell(100,10, 'Order No.:  '.$serviceData['order_no'], 0,1,'C');

         $pdf->SetXY(110,16);
         $pdf->SetFont('Arial','',12);  //Arial normal 16
         $pdf->Cell(100,10, '(Page '.$pageNo.' of '.$totalPages.')', 0,1,'C');

         // date
         $pdf->SetXY(110, 23);
         $pdf->SetFont('Arial','',12);  //Arial normal 16
         $pdf->Cell(100,10, 'Date:  '.date('j / M / Y'), 0,1,'C');

         // layout parameters
         $lineOffSet = 6;
         $lineHeight = 4;
         $fieldHeight = 5;
         $textSize = 7;
         $inputData = 11;
         $section1 = 48;
         $rectHeight = 13;

         #########################################################################################
         #
         # WORKSHEET frames
         #
		 
		 $x_start = 10;
		 
         $pdf->SetFont('Arial','', $textSize);
         $pdf->Rect($x_start, 34, 112, $rectHeight);
         $pdf->Text($x_start, 37, " SHIP'S NAME");
		 
         $pdf->Rect($x_start + 112, 34, 78, $rectHeight);
         $pdf->Text($x_start + 112, 37, " IMO NUMBER");
		 
		 $y = 35;
		 
		 $pdf->Rect($x_start, $y + ($rectHeight ), 112, $rectHeight);
         $pdf->Text($x_start, $y + 3 + ($rectHeight ), " TYPE OF SERVICE");
		 
		 $pdf->Rect($x_start + 112, $y + ($rectHeight), 39, $rectHeight);
         $pdf->Text($x_start + 112, $y + 3 + ($rectHeight), " WARRANTY");
		 
		 $pdf->Rect($x_start + 151, $y + ($rectHeight), 39, $rectHeight);
         $pdf->Text($x_start + 151, $y + 3 + ($rectHeight), " APPROVED BY");
		 
         $pdf->Rect($x_start, $y + ($rectHeight * 2), 190, $rectHeight);
         $pdf->Text($x_start, $y + 3 + ($rectHeight * 2), " EQUIPMENT");
         
         $pdf->Rect($x_start, $y + ($rectHeight * 3), 190, ($rectHeight + 6));
         $pdf->Text($x_start, $y + 3 + ($rectHeight * 3), " REMARKS");
		 
		 $pdf->Rect($x_start, $y + 59, 85, $rectHeight);
         $pdf->Text($x_start, $y + 59 + 3, " COUNTRY");
		 
         $pdf->Rect(95, $y + 59, 105, $rectHeight);
         $pdf->Text(95, $y + 59 + 3, " PORT/PLACE");
		 
         $pdf->Rect($x_start, $y + 73, 100, 41);
         $pdf->Text($x_start, $y + 73 + 3, " AGENT INFORMATION");


			 // ETA sub-table
			 
			 $x = 111;
			 
			 $pdf->Rect($x, $y + 73, 31, 6);
			 $pdf->Text($x, $y + 73 + 4, "                  ETA");
			 $pdf->Rect($x + 31, $y + 73, 58, 6);
			 $pdf->Text($x + 31, $y + 73 + 4, "                           REFERENCE");
			 
			 $y = 114;
			 $pdf->Rect($x, $y, 18, 5);
			 $pdf->Text($x, $y + 3.5, "         Date");
			 $pdf->Rect($x + 18, $y, 13, 5);
			 $pdf->Text($x + 18, $y + 3.5, "     Time");
			 $pdf->Rect($x + 18 + 13, $y, 25, 5);
			 $pdf->Text($x + 18 + 13, $y + 3.5, "           Talked to");
			 $pdf->Rect($x + 18 + 13 + 25, $y, 20, 5);
			 $pdf->Text($x + 18 + 13 + 25, $y + 3.5, "       Called on");
			 $pdf->Rect($x + 18 + 13 +25 + 20, $y, 13, 5);
			 $pdf->Text($x + 18 + 13 +25 + 20, $y + 3.5, "     Time");
			 
			 $x = 111;
			 $y = 119;
			 $cell_height = 6;
			 
			 // first row
			 $pdf->Rect($x, $y, 18, $cell_height);
			 $pdf->Text($x + 1, $y + 5, $serviceData['eta_date']);
			 $pdf->Rect($x + 18, $y, 13, $cell_height);
			 $pdf->Text($x + 19, $y + 5, $serviceData['eta_time']);
			 $pdf->Rect($x + 18 + 13, $y, 25, $cell_height);
			 $pdf->Text($x + 18 + 14, $y + 5, $serviceData['ref_talked_to']);
			 $pdf->Rect($x + 18 + 13 + 25, $y, 20, $cell_height);
			 $pdf->Text($x + 18 + 13 + 26, $y + 5, $serviceData['ref_called_on']);
			 $pdf->Rect($x + 18 + 13 + 25 + 20, $y, 13, $cell_height);
			 $pdf->Text($x + 18 + 13 + 25 + 21, $y + 5, $serviceData['ref_time']);
			 
			 $y = $y + $cell_height;						 
			 
			 // last 3 rows
			 for ( $i = 0; $i <= 3; $i++ ) {
				 $pdf->Rect($x, $y + ($i * $cell_height), 18, $cell_height);							 
				 $pdf->Rect($x + 18, $y + ($i * $cell_height), 13, $cell_height);
				 $pdf->Rect($x + 18 + 13, $y + ($i * $cell_height), 25, $cell_height);
				 $pdf->Rect($x + 18 + 13 + 25, $y + ($i * $cell_height), 20, $cell_height);
				 $pdf->Rect($x + 18 + 13 + 25 + 20, $y + ($i * $cell_height), 13, $cell_height);
			 }	 
		 
		 
         # invoicing details
		 $y = 151;
         $pdf->Rect($x_start, $y, 90, $rectHeight);
         $pdf->Text($x_start, $y + 3, " INVOICE TO");
         $pdf->Rect(100, $y, 60, $rectHeight);
         $pdf->Text(100, $y + 3, " PO NO.");
         $pdf->Rect(160, $y, 40, $rectHeight);
         $pdf->Text(160, $y + 3, " DEBTOR ACCOUNT NO.");
		 
		 
		 ###################################
		 #
		 #	After service information
		 
		 $pdf->SetFont('Arial', '', $textSize + 5);
		 $pdf->Text(12, 171, " AFTER SERVICE INFORMATION");
		 $pdf->SetFont('Arial','', $textSize);  // return text to layout size
		 
		 # "job done by" table
		 $y = 174;
         $pdf->Rect($x_start, $y, 30, 10);
         $pdf->Text($x_start, $y + 6, "          TECHNICIAN");
         $pdf->Rect(40, $y, 80, 10);
         $pdf->Rect(120, $y, 80, 10);
		 
         $pdf->Rect($x_start, $y + 10, 30, 20);
         $pdf->Text($x_start, $y + 21, "        WORKED TIME");
		 
		 $pdf->SetFont('Arial', '', $textSize - 1);		 
		 		 
		 $pdf->Rect(40, $y + 10, 40, 10);  // hours 1
		 $pdf->Text(40, $y + 13, " HOURS");
		 $pdf->Text(40, $y + 16, " NORMAL");
		 $pdf->Rect(80, $y + 10, 40, 10);  // overtime 1
		 $pdf->Text(80, $y + 13, " HOURS");
		 $pdf->Text(80, $y + 16, " OVERTIME");
		 $pdf->Rect(120, $y + 10, 40, 10);  // hours 2
		 $pdf->Text(120, $y + 13, " HOURS");
		 $pdf->Text(120, $y + 16, " NORMAL");
		 $pdf->Rect(160, $y + 10, 40, 10);  // overtime 2
		 $pdf->Text(160, $y + 13, " HOURS");
		 $pdf->Text(160, $y + 16, " OVERTIME");
		 $pdf->Rect(40, $y + 20, 40, 10);  // weekdays 1
		 $pdf->Text(40, $y + 23, " DAILY");
		 $pdf->Text(40, $y + 26, " RATE");
		 $pdf->Rect(80, $y + 20, 40, 10);  // weekend 1
		 $pdf->Text(80, $y + 23, " DAILY");
		 $pdf->Text(80, $y + 26, " RATE");
		 $pdf->Text(80, $y + 29, " WEEKEND");
         $pdf->Rect(120, $y + 20, 40, 10);  // weekdays 2
		 $pdf->Text(120, $y + 23, " DAILY");
		 $pdf->Text(120, $y + 26, " RATE");
         $pdf->Rect(160, $y + 20, 40, 10);  // weekend 2
		 $pdf->Text(160, $y + 23, " DAILY");
		 $pdf->Text(160, $y + 26, " RATE");
		 $pdf->Text(160, $y + 29, " WEEKEND");
		 
		 $pdf->SetFont('Arial','', $textSize);  // return text to layout size


		 # complementary information
		 $y = 205;
		 $pdf->Rect($x_start, $y, 190, 21);
		 $pdf->Text($x_start, $y + 3, " REMARKS AFTER SERVICE");
		 
		 $y = 214;
		 $pdf->Rect($x_start, $y + $rectHeight, 45, $rectHeight);
         $pdf->Text($x_start, $y + $rectHeight + 3, " FOLLOW UP");
		 $pdf->Rect(55, $y + $rectHeight, 145, $rectHeight);
		 $pdf->Text(55, $y + $rectHeight + 3, " INFORM TO");
		 $pdf->Rect($x_start, $y + ($rectHeight * 2), 95, $rectHeight);
         $pdf->Text($x_start, $y + ($rectHeight * 2) + 3, " PARTS TO BE RETURNED TO");
		 $pdf->Rect(105, $y + ($rectHeight * 2), 95, $rectHeight);
         $pdf->Text(105, $y + ($rectHeight * 2) + 3, " PARTS TO BE ORDERED FROM");
		 $pdf->Rect($x_start, $y + ($rectHeight * 3), 190, $rectHeight);
         $pdf->Text($x_start, $y + ($rectHeight * 3) + 3, " RETURN REPORT TO");
		 
		 # evaluations
		 $y = 267;
         $pdf->Rect($x_start, $y, 63.33, $rectHeight);
         $pdf->Text($x_start, $y + 3, " AGENT EVALUATION");
		 $pdf->Text($x_start, $y + 6, " FROM TECHNICIAN");
         $pdf->Rect(73.33, $y, 63.33, $rectHeight);
         $pdf->Text(73.33, $y + 3, " AGENT EVALUATION");
		 $pdf->Text(73.33, $y + 6, " FROM COORDINATOR");
         $pdf->Rect(136.66, $y, 63.33, $rectHeight);
         $pdf->Text(136.66, $y + 3, " WASTED TIME (hours)");
		 
		 # document version-revision information
		 $y = 280;
		 $pdf->SetFont('Arial','', 6);
		 //$pdf->Text(175, $y + 3, "HSS-WS300409-Rev.C");
		$pdf->Text(175, $y + 3, "HSS-WS-300409-1-ADE");
		 
		 
		 $pdf->SetFont('Arial','', $textSize);  // return text to layout size



         #########################################################################################
         #
         # WORKSHEET data
         #
         $pdf->SetFont('Arial','', $textSize + 5);
		 
		 $x = 12;
		 
         $pdf->Text($x, 44, $wsData['SHIP']);
         $pdf->Text(150, 44, $serviceData['imo_number']);
		 $pdf->Text($x, 58, $wsData2['SERVICE']);
		 $pdf->Text(140, 58, $wsData2['WARRANTY']);
		 $pdf->Text(180, 58, $wsData2['APPROVEDBY']);
         $pdf->Text($x, 72, $wsData2['EQUIPMENT']);
		 
		 $pdf->SetXY(12, 79);
		 $pdf->SetFont('Arial', '', $textSize + 4);
         $pdf->MultiCell( 185, 4, $serviceData['remarks'], 0, '' );
		 $pdf->SetFont('Arial','', $textSize + 5);  // return text to layout size
		 
		 $pdf->Text($x, 104, $wsData['COUNTRY']);
		 $pdf->Text(100, 104, $wsData['PORT']);
		 
		 
		 $x = 12;
		 $y = 122;
		 
		 $pdf->Text($x, 117, $wsData['AGENT']);
		 
		 $pdf->SetFont('Arial', '', 9);
		 
		 $x = 14;
		 
		 $pdf->Text($x, $y, "ph 1  : ".$wsData['agent_phone_1']);
		 $pdf->Text($x, $y + 4, "ph 2  : ".$wsData['agent_phone_2']);
		 $pdf->Text($x, $y + 8, "fax    : ".$wsData['agent_fax']);
		 $pdf->Text($x, $y + 12, "email : ".$wsData['agent_email']);
		 $pdf->Text($x, $y + 16, "mobile: ".$serviceData['agent_mobile']);
		 $pdf->Text($x, $y + 20, "boarding agent: ".$serviceData['agent_boarding']);		 
		 		 
		 $pdf->SetFont('Arial','', $textSize + 5);  // return text to layout size
		 
		 
		 # invoicing details
		 
		 $x = 12;
		 $y = 161;
		 
		 $pdf->Text( $x, $y, $serviceData['invoice_to'] );
		 $pdf->Text( 105, $y, $serviceData['po_no'] );
		 $pdf->Text( 170, $y, $serviceData['debtor_account'] );


         #
         # Generate PDF file
         #
         // send file to browser:
         //$pdf->Output( date('dmY_Hi').'.pdf', 'D' );
		 $pdf->Output( date('dmY_Hi').'.pdf', 'I' );
         
         // save file into $path destination:
         //$path_complete = $path_root.$serviceData['ORDER_NO'].'-'.$pageNo.'-'.date('dmY').'.pdf';
         //$pdf->Output( $path_complete, 'F' );
         
         return 0;

}  // end of:  PDF GENERATION FUNCTION


?>


