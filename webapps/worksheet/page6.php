<?php

  session_start();
  
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
  
  # change this ORDER status to show it as DONE when user click on CREATE WORKSHEET link
	$order = $_SESSION['ORDER'];

	$sql = "UPDATE service_tbl
			SET STATUS_ID='2'
			WHERE ORDER_NO='$order'";  // set WORKSHEET at PRINTED state

	$result = $db->query($sql);  // STATUS changed


  #
  #  retrieve from database all service data to be printed on worksheet
  #
  $sql = "SELECT * FROM service_tbl WHERE ORDER_NO='$order'";
	$res1 = $db->query($sql);
	$rowService = $res1->fetch();  // array with service_tbl data
	
	$imo = $rowService['IMO_NUMBER'];    // needed in the following lines...
	$country_id = $rowService['country_id'];
	$city_id = $rowService['city_id'];
	$port_id = $rowService['PORT_ID'];
	$agent_id = $rowService['AGENT_ID'];

  // get data from all tables to generate the worksheet
	$sql = "SELECT SHIP_NAME, location_in_server FROM ships_tbl WHERE IMO_NUMBER='$imo'";
	$res11 = $db->query($sql);
	$res11_value = $res11->fetch();
	
	$sql = "SELECT country_name FROM countries_tbl WHERE country_id='$country_id'";
	$res12 = $db->query($sql);
  $res12_value = $res12->fetch();
  
  $sql = "SELECT PORT_NAME FROM ports_tbl WHERE PORT_ID='$port_id' AND country_id='$country_id'";
	$res13 = $db->query($sql);
	$res13_value = $res13->fetch();
	
	$sql = "SELECT * FROM agents_tbl WHERE AGENT_ID='$agent_id' AND country_id='$country_id' AND city_id='$city_id'";
	$res14 = $db->query($sql);
	$res14_value = $res14->fetch();

  $worksheetData = array( "SHIP"=>$res11_value['SHIP_NAME'],
                          "COUNTRY"=>$res12_value['country_name'],
                          "PORT"=>$res13_value['PORT_NAME'],
                          "FEE"=>$res13_value['PORT_FEE'],
                          "AGENT"=>$res14_value['AGENT_NAME'],
						  "agent_address"=>$res14_value['AGENT_ADDRESS'],
						  "agent_phone_1"=>$res14_value['AGENT_OFFICE_PHONE_1'],
						  "agent_phone_2"=>$res14_value['AGENT_OFFICE_PHONE_2'],
						  "agent_fax"=>$res14_value['AGENT_FAX'],
						  "agent_email"=>$res14_value['AGENT_EMAIL'],
						  "agent_mobile"=>$res14_value['AGENT_DUTY_PHONE'] );

    $sql = "SELECT * FROM service_items_tbl WHERE ORDER_NO='$order'";
	$res2 = $db->query($sql);
    $qty_items = $res2->size();

	#
    # generate PDF file(s) -- create_worksheet()
    #
    for ( $i = 1; $i <= $res2->size(); $i++ ) {

    $rowItem = $res2->fetch();
    
    $service_type_id = $rowItem['SERVICE_TYPE_ID'];
    $equip_id = $rowItem['EQUIP_ID'];
    $emp_id = $rowItem['emp_id'];
    
    // get data from all tables to generate the worksheet
    $sql = "SELECT SERVICE_TYPE FROM service_type_tbl WHERE SERVICE_TYPE_ID='$service_type_id'";
    $res21 = $db->query($sql);
    $res21_value = $res21->fetch();
    
	
	
    $sql = "SELECT EQUIP_TYPE_ID, MANUF_ID, EQUIP_MODEL, extended_info FROM equipment_model_tbl WHERE EQUIP_ID='$equip_id'";
    $res22 = $db->query($sql);
    $res22_value = $res22->fetch();
	
	$equip_type_id = $res22_value['EQUIP_TYPE_ID'];
	$manuf_id = $res22_value['MANUF_ID'];
	
	$sql = "SELECT MANUF_NAME FROM equipment_manufacturer_tbl WHERE MANUF_ID='$manuf_id'";
    $res22_1 = $db->query($sql);
    $res22_1_value = $res22_1->fetch();
	
	$sql = "SELECT EQUIP_TYPE FROM equipment_type_tbl WHERE EQUIP_TYPE_ID='$equip_type_id'";
    $res22_2 = $db->query($sql);
    $res22_2_value = $res22_2->fetch();
	
	$equipment_full_description = $res22_1_value['MANUF_NAME'].' - '.$res22_2_value['EQUIP_TYPE'].' - '.$res22_value['EQUIP_MODEL'].'.  '.$res22_value['extended_info'];
	
	
    $sql = "SELECT emp_login FROM employees_tbl WHERE emp_id='$emp_id'";
    $res23 = $db->query($sql);
    $res23_value = $res23->fetch();
    
    $worksheetData2 = array( "SERVICE"=>$res21_value['SERVICE_TYPE'],
                             "EQUIPMENT"=>$equipment_full_description,
                             "APPROVEDBY"=>$res23_value['emp_login'] );
	
	
	
	//$path_suffix = $res11_value['location_in_server']."/".$order."/worksheet/";
	$path_suffix = "../../knowledgebase/$imo/$order/worksheet/";
	
	$path_base = "../../knowledgebase/$imo";
	
	
	#
	#  IMPORTANT: CHECK IF THE FOLDERS STRUCTURE IS CREATED, IF NOT CREATE IT.
	#	-this code section should be better placed out of the for loop.
	#	-remember to update any change done here in page2_events.php	
	// first test: the whole path
	if ( !file_exists( $path_suffix ) ) {
	
		// second test: only up to the imo folder
		if ( !file_exists( /*$res11_value['location_in_server']*/  $path_base ) ) {
			
			mkdir( /*$res11_value['location_in_server']*/ $path_base, 0777 );
			mkdir( /*$res11_value['location_in_server']*/ $path_base."/".$order, 0777 );
			mkdir( /*$res11_value['location_in_server']*/ $path_base."/".$order."/worksheet", 0777 );
			mkdir( /*$res11_value['location_in_server']*/ $path_base."/".$order."/service_report", 0777 );
			mkdir( /*$res11_value['location_in_server']*/ $path_base."/".$order."/additional_docs", 0777 );
			mkdir( /*$res11_value['location_in_server']*/ $path_base."/".$order."/pictures", 0777 );
		}		
	
	}
	#
	#  END OF FOLDERS STRUCTURE CHECK
	#
	
	// call function to generate worksheet
	create_worksheet( $worksheetData, $worksheetData2, $rowService, $rowItem , $i, $qty_items, $path_suffix, $path );
	
	// save the worksheet location into database
	$item = $rowItem['ITEM_NO'];
			
	$sql = "UPDATE service_items_tbl
			SET path_to_doc='$path'
			WHERE ORDER_NO='$order' AND ITEM_NO='$item'";
	$res3 = $db->query($sql);

	}  // end of: for ( $i = 1; $i <= $res2->size(); $i++ ) {
	
	#
	#  GO TO THE PRINT PAGE
	#
    header( 'Location: page6_1.php' );


#
#
#  (PDF) WORSHEET GENERATION FUNCTION
#
#
function create_worksheet( $wsData, $wsData2, $serviceData, $itemData, $pageNo, $totalPages, $path_root, &$path_complete ) {

         //Instanciation of inherited class
         $pdf=new PDF();
         $pdf->AliasNbPages();
         $pdf->AddPage();

         // order number
         $pdf->SetXY(110,10);
         $pdf->SetFont('Arial','',16);  //Arial normal 16
         $pdf->Cell(100,10, 'Order No.:  '.$serviceData['ORDER_NO'], 0,1,'C');

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
		 
		 $pdf->Rect($x_start, $y + ($rectHeight), 112, $rectHeight);
         $pdf->Text($x_start, $y + 3 + ($rectHeight), " TYPE OF SERVICE");
		 
         $pdf->Rect($x_start + 112, $y + ($rectHeight), 39, $rectHeight);
         $pdf->Text($x_start + 112, $y + 3 + ($rectHeight), " WARRANTY");
		 
         $pdf->Rect($x_start + 151, $y + ($rectHeight), 39, $rectHeight);
         $pdf->Text($x_start + 151, $y + 3 + ($rectHeight), " APPROVED BY");
		 
         $pdf->Rect($x_start, $y + ($rectHeight * 2), 190, $rectHeight - 2);
         $pdf->Text($x_start, $y + 3 + ($rectHeight * 2), " EQUIPMENT");
		 
         $pdf->Rect($x_start, $y + ($rectHeight * 3) - 2, 190, ($rectHeight + 11));
         $pdf->Text($x_start, $y + 1 + ($rectHeight * 3), " REMARKS");
		 
         $pdf->Rect($x_start, $y + 59 + 3, 85, $rectHeight - 3);
         $pdf->Text($x_start, $y + 59 + 3 + 3, " COUNTRY");
		 
         $pdf->Rect(95, $y + 59 + 3, 105, $rectHeight - 3);
         $pdf->Text(95, $y + 59 + 3 + 3, " PORT/PLACE");
		 	 
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
			 
			 $pdf->SetFont('Arial','', $textSize + 3);
			 $pdf->Rect($x, $y, 18, $cell_height);
			 $pdf->Text($x, $y + 5, $serviceData['ETA_DATE_DAY'].'/'.$serviceData['ETA_DATE_MONTH'].'/'.$serviceData['ETA_DATE_YEAR']);
			 $pdf->Rect($x + 18, $y, 13, $cell_height);
			 $pdf->Text($x + 20, $y + 5, $serviceData['ETA_HOUR']);
			 $pdf->Rect($x + 18 + 13, $y, 25, $cell_height);
			 $pdf->Text($x + 18 + 14, $y + 5, $serviceData['ref_talked_to']);
			 $pdf->Rect($x + 18 + 13 + 25, $y, 20, $cell_height);
			 $pdf->Text($x + 18 + 13 + 26, $y + 5, $serviceData['ref_called_on']);
			 $pdf->Rect($x + 18 + 13 + 25 + 20, $y, 13, $cell_height);
			 $pdf->Text($x + 18 + 13 + 25 + 21, $y + 5, $serviceData['ref_time']);
			 
			 $y = $y + $cell_height;						 
			 
			 // last 4 rows
			 for ( $i = 0; $i <= 3; $i++ ) {
				 $pdf->Rect($x, $y + ($i * $cell_height), 18, $cell_height);							 
				 $pdf->Rect($x + 18, $y + ($i * $cell_height), 13, $cell_height);
				 $pdf->Rect($x + 18 + 13, $y + ($i * $cell_height), 25, $cell_height);
				 $pdf->Rect($x + 18 + 13 + 25, $y + ($i * $cell_height), 20, $cell_height);
				 $pdf->Rect($x + 18 + 13 + 25 + 20, $y + ($i * $cell_height), 13, $cell_height);
			 }
		
		
		 
		 $pdf->SetFont('Arial','', $textSize);
         
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
		 
		 $pdf->Rect(136.66, $y + 4, (63.33 / 2), $rectHeight - 4);
         $pdf->Text(136.66, $y + 4 + 3, " NT");
		 $pdf->Rect(136.66 + (63.33 / 2), $y + 4, (63.33 / 2), $rectHeight - 4);
         $pdf->Text(136.66 + (63.33 / 2), $y + 4 + 3, " OT");
		 
		 
		 # document version-revision information
		 $y = 280;
		 $pdf->SetFont('Arial','', 6);
		 $pdf->Text(175, $y + 3, "HSS-WS-300409-1-ADE");
		 
		 
		 $pdf->SetFont('Arial','', $textSize);  // return text to layout size


         #########################################################################################
         #
         # WORKSHEET data
         #
         $pdf->SetFont('Arial','', $textSize + 5);
		 
		 $x = 12; 
		 
         $pdf->Text($x, 44, $wsData['SHIP']);
		 $pdf->Text(150, 44, $serviceData['IMO_NUMBER']);
		 $pdf->Text($x, 58, $wsData2['SERVICE']);
		 $pdf->Text(140, 58, $itemData['WARRANTY']);
		 $pdf->Text(180, 58, $wsData2['APPROVEDBY']);
		 $pdf->Text($x, 70, $wsData2['EQUIPMENT']);
		 
		 $pdf->SetXY(12, 76);
		 $pdf->SetFont('Arial', '', $textSize + 4);
         $pdf->MultiCell( 185, 4, $itemData['REMARKS'], 0, '' );
		 $pdf->SetFont('Arial','', $textSize + 5);  // return text to layout size
		 
		 $pdf->Text($x, 104 + 1, $wsData['COUNTRY']);
		 $pdf->Text(100, 104 + 1, $wsData['PORT']);
         
		 $x = 12;
		 $y = 122;
		 
		 $pdf->Text($x, 117, $wsData['AGENT']);
		 
		 $x = 14;
		 
		 $pdf->SetFont('Arial', '', 9);
		 $pdf->Text($x, $y, "Address : ");
		 
		 $pdf->SetXY(28, 118);
		 $pdf->SetFont('Arial', '', 8);
		 $pdf->MultiCell( 85, 3, $wsData['agent_address'], 0, '' );
		 //$pdf->Text($x, $y, "Address : ".$wsData['agent_address']);
		 
		 $pdf->SetFont('Arial', '', 9);
		 
		 $pdf->Text($x, $y + 5, "ph 1  : ".$wsData['agent_phone_1']);
		 $pdf->Text($x, $y + 9, "ph 2  : ".$wsData['agent_phone_2']);
		 $pdf->Text($x, $y + 13, "fax    : ".$wsData['agent_fax']);
		 $pdf->Text($x, $y + 17, "mobile: ".$wsData['agent_mobile']);
		 $pdf->Text($x, $y + 21, "boarding agent: ".$serviceData['AGENT_DUTY']);
		 $pdf->Text($x, $y + 25, "email : ".$wsData['agent_email']);		 
		 
		 $pdf->SetFont('Arial','', $textSize + 5);  // return text to layout size        
        
			 
		 # invoicing details
		 
		 $x = 12;
		 $y = 161;
		 
		 $pdf->Text( $x, $y, $serviceData['SALESNAME'] );
		 $pdf->Text( 105, $y, $serviceData['REQUISNUMBER'] );
		 $pdf->Text( 170, $y, $serviceData['DEBTORACCOUNT'] );
		 
		 # after service information
		 
		 $x = 12;
		 $y = 263;
		 
		 $pdf->Text( $x, $y, $serviceData['RETURN_REPORT_TO'] );
		 $pdf->Text( 63.33, $y + 14, ""/*$serviceData['AGENT_EVAL_TECH']*/ );
		 $pdf->Text( 63.33 * 2, $y + 14, ""/*$serviceData['AGENT_EVAL_OFFICE']*/ );



         #
         # Generate and save PDF file
         #
         // send file to browser:
         //$pdf->Output( $serviceData['ORDER_NO'].'-'.$itemData['ITEM_NO'].'-'.date('dmY').'.pdf', 'I' );
         
         // save file into $path destination:
         $path_complete = $path_root.$serviceData['ORDER_NO'].'-'.$pageNo.'-'.date('dmY').'.pdf';
         
         $pdf->Output( $path_complete, 'F' );
         
         return 0;

}  // end of:  PDF GENERATION FUNCTION


?>

