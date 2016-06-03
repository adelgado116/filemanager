<?php

// session check
session_start();
if (!session_is_registered("SESSION")) {
  // if session check fails, invoke error handler
  header("Location: ./error.php");
  exit();
}


$report_name = $_REQUEST['report_name'];

# display form

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" href="css/iframe.css" />
<title></title>
</head>

<body>

<div id="title_preventive"> <font size="+1" color="#000000"  face="Verdana, Arial, Helvetica, sans-serif"> 
  Set Preventive Action for the Following Report: <a href="<?php echo 'repository/'.$report_name; ?>" target="_blank"><?php echo $report_name; ?></a></font> </div>


<div id="preventiveContainer_analysis"> 

	<?php
	
	if ( $_REQUEST['error'] == 1 ){
	?>
	<div id="error_preventive">
	You must write a brief description of the preventive actions!
	</div>
	<?php
	}
	?>

  <br/><br/>
  
  <div class="tableTitle">&nbsp;&nbsp;&nbsp;Write Preventive Action:</div>
  
  <?php if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) { ?>
  <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">

  <center>
  
  <textarea class="textarea_box" name="preventive2" cols="70" rows="2"></textarea>
  
  <input type="hidden" name="record_id" value="<?php echo $_REQUEST['record_id']; ?>" />
  <input type="hidden" name="report_name" value="<?php echo $_REQUEST['report_name']; ?>" />
  <input type="hidden" name="filter_report_type" value="<?php echo $_REQUEST['filter_report_type']; ?>" />
  <input type="hidden" name="filter_submitter" value="<?php echo $_REQUEST['filter_submitter']; ?>" />
  <input type="hidden" name="filter_reference" value="<?php echo $_REQUEST['filter_reference']; ?>" />
  <input type="hidden" name="filter_date_day" value="<?php echo $_REQUEST['filter_date_day']; ?>" />
  <input type="hidden" name="filter_date_month" value="<?php echo $_REQUEST['filter_date_month']; ?>" />
  <input type="hidden" name="filter_date_year" value="<?php echo $_REQUEST['filter_date_year']; ?>" />
  <input type="hidden" name="current" value="<?php echo $_REQUEST['current']; ?>" />
  <br/><br/>
  <button class="button" type="submit" name="send" value="send" >update report</button>
  
  </center>
  </form>
</div>
<!-- preventiveContainer_analysis -->

</body>
</html>


<?php } else {

	#################################
	# PROCESS THE SUBMITTED DATA
	#################################
	
	$error = 0;
	if ( $_REQUEST['preventive2'] == "" ) {
	
		$error = 1;
		header('Location: set_preventive_actions.php?record_id='.$_REQUEST['record_id'].'&report_name='.$_REQUEST['report_name'].'&filter_report_type='.$_REQUEST['filter_report_type'].'&filter_submitter='.$_REQUEST['filter_submitter'].'&filter_reference='.$_REQUEST['filter_reference'].'&filter_date_day='.$_REQUEST['filter_date_day'].'&filter_date_month='.$_REQUEST['filter_date_month'].'&filter_date_year='.$_REQUEST['filter_date_year'].'&current='.$_REQUEST['current'].'&error='.$error );


	} else {
	
		#
		# update database:  save preventive_from_management and update status (set as 'closed')
		#
		$report_id = $_REQUEST['record_id'];
		$preventive = addslashes( $_REQUEST['preventive2'] );
		
		//echo $preventive;
		//exit();
		
		require_once('aadv/lib.php');
		require_once('fpdf/fpdf.php');
		require_once('functions_hssiso.php');
		
		include('dbConnect_hssiso.inc');
	 
		if (! @mysql_select_db('hss_db', $link_id) ) {
			die( '<p>Unable to locate the database at this time. E1</p>' );
		}
		
		$sql = "UPDATE reports_repository_main
				SET status='closed', preventive_from_management='$preventive'
				WHERE report_id='$report_id'";
				
		$result = mysql_query($sql) or die('Query x failed: ' . mysql_error());
		
		#
		# regenerate PDF file with new data
		#

		#  retrieve all data from database
		
		$report_id = $_REQUEST['record_id'];
		
		$sql = "SELECT * FROM reports_repository_main WHERE report_id='$report_id'";
		$res1 = mysql_query($sql) or die('Query failed [report data 1]: ' . mysql_error());
		$record = mysql_fetch_array($res1, MYSQL_ASSOC);
		
		$sql = "SELECT * FROM reports_repository_secondary WHERE report_id='$report_id'";
		$res_sel_opt = mysql_query($sql) or die('Query failed [report date 2]: ' . mysql_error());
		$selected_options_list = get_table( $res_sel_opt );
		
		
		# type of report + document version + document code
		$cat = $record['rep_id'];
		$sql = "SELECT * FROM reports_types WHERE rep_id='$cat'";
		$res2 = mysql_query($sql) or die('Query failed [1]: ' . mysql_error());
		$cat_name = mysql_fetch_array($res2, MYSQL_ASSOC);
		
		# reference
		
		# date-time information
		
		# submitter
		$emp = $record['emp_id'];
		$sql = "SELECT * FROM employees_tbl WHERE emp_id='$emp'";
		$res3 = mysql_query($sql) or die('Query failed [2]: ' . mysql_error());
		$emp_name = mysql_fetch_array($res3, MYSQL_ASSOC);
		
		# list of options
		$sql = "SELECT * FROM reports_options_list WHERE rep_id='$cat' AND show_option='1'";
		$res4 = mysql_query($sql) or die('Query failed [3]: ' . mysql_error());
		$options_table = get_table( $res4 );
		
		# memo internal
		$emp = $record['memo_internal'];
		$sql = "SELECT * FROM employees_tbl WHERE emp_id='$emp'";
		$res4 = mysql_query($sql) or die('Query failed [3]: ' . mysql_error());
		$emp_name_2 = mysql_fetch_array($res4, MYSQL_ASSOC);
		
		if ( $emp_name_2['emp_login'] == "" ) {
			$memo_int = 'N/A';
		} else {
			$memo_int = $emp_name_2['emp_login'];
		}
		
		
		
		#################################################################################
		class PDF extends FPDF
		{
			//Page header
			function Header() {
				$this->SetFont('Arial','B',18);
				//Title
				$this->Cell(100,10,'Raytheon Anschuetz Panama',0,1,'L');
				//Horizontal line to separate header
				$this->Cell(0, 2, '', 'T', 0, 'C');
				//Line break
				$this->Ln(5);
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
		$pdf->Cell(30,8, $cat_name['doc_code'].$record['sub_cat_id'], 1, 1, 'C');
		
		$pdf->Ln(3);
		
		$pdf->SetFont('Arial','',$textSize);
		
		$pdf->Cell(35,$lineHeight + 0, 'Failure on: ', 0, 0);
		$pdf->Cell(55,$lineHeight + 0, $cat_name['rep_name'], 0, 0, 'L');
		
		$pdf->Cell(40,$lineHeight + 0, '  Memo Internal: ', 'L', 0);
		$pdf->Cell(60,$lineHeight + 0, $memo_int, 'R', 1, 'L');
		
		$pdf->Cell(35,$lineHeight + 0, 'Reference: ', '', 0);
		$pdf->Cell(55,$lineHeight + 0, $record['reference'], '', 0, 'L');
		
		$pdf->Cell(40,$lineHeight + 0, '  Memo External: ', 'LB', 0);
		$pdf->Cell(60,$lineHeight + 0, $record['memo_external'], 'BR', 1, 'L');
		
		$pdf->Cell(35,$lineHeight + 0, 'Submitted on: ', '', 0);
		$pdf->Cell(55,$lineHeight + 0, $record['date_day'].' / '.$record['date_month'].' / '.$record['date_year'].', '.$record['date_time'], '', 1, 'L');
		
		$pdf->Cell(35,$lineHeight + 0, 'Submitted by: ', '', 0);
		$pdf->Cell(55,$lineHeight + 0, $emp_name['emp_name'], '', 1, 'L');
		
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
			
			$pdf->Cell( 2 );
			
			if ( $index[$i] == 'x' ) {
			
				$pdf->Cell( 7,  ($lineHeight - 1), 'x', 1, 0, 'C' );
				
			} else {
			
				$pdf->Cell( 7,  ($lineHeight - 1), '', 1, 0, 'C' );
			}
			
			$pdf->Cell( 1 );
			$pdf->Cell( 55, $lineHeight, $options_table[ $i ]['rep_option'], '', 1, 'L'); 	
		}
		
		$pdf->Cell(17,$lineHeight, 'Other: ', 0, 0, 'L');
		$pdf->Cell(171,$lineHeight, $record['other_text'], 1, 1, 'L');
		
		
		$pdf->SetXY( 10, 164 );
		
		$pdf->Cell(0, 2, '', 'T', 0, 'C');	// horizontal line
		
		
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
		$pdf->MultiCell($textarea_width, $lineHeight - 3 , $record['preventive_from_management'], 0, 1, 'L');
		


		# document version-revision information
		$y = 286;
		$pdf->SetFont('Arial','', 8);
		$pdf->Text( 159, $y, $cat_name['version_revision']);
		
		
		#
		# Generate and save PDF file
		#

		// save file:
		$filename = 'repository/RAN-'.$cat_name['doc_code'].'-'.$record['sub_cat_id'].'_revd.pdf';
		$pdf->Output( $filename, 'F' );





		
		#
		# return to reports analysis page
		#
		header('Location: reports_analysis_results.php');
		//header('Location: reports_analysis_results.php?record_id='.$_REQUEST['record_id'].'&report_name='.$_REQUEST['report_name'].'&filter_report_type='.$_REQUEST['filter_report_type'].'&filter_submitter='.$_REQUEST['filter_submitter'].'&filter_reference='.$_REQUEST['filter_reference'].'&filter_date_day='.$_REQUEST['filter_date_day'].'&filter_date_month='.$_REQUEST['filter_date_month'].'&filter_date_year='.$_REQUEST['filter_date_year'].'&current='.$_REQUEST['current'] );
	}
}

?>

