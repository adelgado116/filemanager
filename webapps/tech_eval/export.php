<?php

$tech = $_REQUEST['tech_id'];

require_once('Database/MySQL.php');
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

$sql = "SELECT * FROM employees_tbl WHERE emp_id='$tech'";
$res1 = $db->query($sql);

if ( $res1->size() == 1 ) {
	$tech_data = $res1->fetch();
	$tech_name = $tech_data['emp_name'];
	$tech_login = $tech_data['emp_login'];
}


$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' ORDER BY service_date_year desc, service_date_month desc, service_date_day desc";
$res2 = $db->query($sql);
$total_records = $res2->size();

if ( $total_records == 0 ) {

	echo "</br>The choosen technician has no records for Customer Evaluations</br></br>Please close the door when you leave...";
	exit();
}


#
#  start writing data to txt file
#
$filename = "../../customer_eval_reports/iso_report_".$tech_login.".txt";
$fh = fopen( $filename, 'w' ) or die( "can't open file" );

fwrite( $fh, ":: INTERNAL REPORT : Service Evaluations from Customers ::\n" );
fwrite( $fh, ":: Technician's Name:  $tech_name\n" );
fwrite( $fh, ":: Report Date:  ".date( "d/m/Y - H:i" )."\n" );
fwrite( $fh, ":: Total Records:  $total_records\n" );
fwrite( $fh, "-----------------------------------------------------------------------------------\n" );
fwrite( $fh, "ORDER NO | SERVICE DATE | PERFORMANCE | COORDINATION | ACCOMPLISHMENT | QUALITY\n" );
fwrite( $fh, "-----------------------------------------------------------------------------------\n" );

for ( $i == 0; $i <= ( $res2->size() - 1 ); $i++ ) {
	
	$row = $res2->fetch();
	//echo $row['ORDER_NO']." - ".$row['service_date_day']." - ".$row['service_date_month']." - ".$row['service_date_year'];
	fwrite( $fh, $row['ORDER_NO']."   | ".$row['service_date_day']."-".$row['service_date_month']."-".$row['service_date_year']."   | " );
	
	$id1 = $row['performance'];
	$sql = "SELECT tech_eval_value FROM tech_eval_values WHERE tech_eval_value_id='$id1'";
	$res = $db->query($sql);
	$eval_data_1 = $res->fetch();
	
	$id2 = $row['coordination'];
	$sql = "SELECT tech_eval_value FROM tech_eval_values WHERE tech_eval_value_id='$id2'";
	$res = $db->query($sql);
	$eval_data_2 = $res->fetch();
	
	$id3 = $row['accomplishment'];
	$sql = "SELECT tech_eval_value FROM tech_eval_values WHERE tech_eval_value_id='$id3'";
	$res = $db->query($sql);
	$eval_data_3 = $res->fetch();
	
	$id4 = $row['quality'];
	$sql = "SELECT tech_eval_value FROM tech_eval_values WHERE tech_eval_value_id='$id4'";
	$res = $db->query($sql);
	$eval_data_4 = $res->fetch();
	
	//echo $eval_data_1['tech_eval_value'];
	fwrite( $fh, $eval_data_1['tech_eval_value']."   | " );
	fwrite( $fh, $eval_data_2['tech_eval_value']."    | " );
	fwrite( $fh, $eval_data_3['tech_eval_value']."      | " );
	fwrite( $fh, $eval_data_4['tech_eval_value'] );
	
	fwrite( $fh, "\n");
}


#
#  finish statistics and close txt file
#

# get stats for PERFORMANCE
$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND performance='1'";
$res3 = $db->query($sql);
$total_perf_excellent = $res3->size();

$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND performance='2'";
$res4 = $db->query($sql);
$total_perf_good = $res4->size();

$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND performance='3'";
$res5 = $db->query($sql);
$total_perf_average = $res5->size();

$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND performance='4'";
$res6 = $db->query($sql);
$total_perf_poor = $res6->size();

# get stats for COORDINATION
$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND coordination='1'";
$res7 = $db->query($sql);
$total_coord_excellent = $res7->size();

$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND coordination='2'";
$res8 = $db->query($sql);
$total_coord_good = $res8->size();

$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND coordination='3'";
$res9 = $db->query($sql);
$total_coord_average = $res9->size();

$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND coordination='4'";
$res10 = $db->query($sql);
$total_coord_poor = $res10->size();

# get stats for ACCOMPLISHMENT
$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND accomplishment='1'";
$res11 = $db->query($sql);
$total_accomp_excellent = $res11->size();

$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND accomplishment='2'";
$res12 = $db->query($sql);
$total_accomp_good = $res12->size();

$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND accomplishment='3'";
$res13 = $db->query($sql);
$total_accomp_average = $res13->size();

$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND accomplishment='4'";
$res14 = $db->query($sql);
$total_accomp_poor = $res14->size();

# get stats for QUALITY
$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND quality='1'";
$res15 = $db->query($sql);
$total_quality_excellent = $res15->size();

$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND quality='2'";
$res16 = $db->query($sql);
$total_quality_good = $res16->size();

$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND quality='3'";
$res17 = $db->query($sql);
$total_quality_average = $res17->size();

$sql = "SELECT * FROM tech_eval WHERE tech_id='$tech' AND quality='4'";
$res18 = $db->query($sql);
$total_quality_poor = $res18->size();



fwrite( $fh, "-----------------------------------------------------------------------------------\n" );
fwrite( $fh, ":: REPORT STATISTICS ::\n" );
fwrite( $fh, ":: Technician's Performance:              " );
fwrite( $fh, "E = ".round( ($total_perf_excellent / $total_records ) * 100, 0 )."% / G = ".round( ($total_perf_good / $total_records) * 100, 0 )."% / A = ".round( ($total_perf_average / $total_records) * 100, 0 )."% / P = ".round( ($total_perf_poor / $total_records) * 100, 0 )."%\n" );
fwrite( $fh, ":: Overall Service Coordination:          " );
fwrite( $fh, "E = ".round( ($total_coord_excellent / $total_records) * 100, 0 )."% / G = ".round( ($total_coord_good / $total_records) * 100, 0 )."% / A = ".round( ($total_coord_average / $total_records) * 100, 0 )."% / P = ".round( ($total_coord_poor / $total_records) * 100, 0 )."%\n" );
fwrite( $fh, ":: Accomplishment of Requested Services:  " );
fwrite( $fh, "E = ".round( ($total_accomp_excellent / $total_records) * 100, 0 )."% / G = ".round( ($total_accomp_good / $total_records) * 100, 0 )."% / A = ".round( ($total_accomp_average / $total_records) * 100, 0 )."% / P = ".round( ($total_accomp_poor / $total_records) * 100, 0 )."%\n" );
fwrite( $fh, ":: Quality of Service:                    " );
fwrite( $fh, "E = ".round( ($total_quality_excellent / $total_records) * 100, 0 )."% / G = ".round( ($total_quality_good / $total_records) * 100, 0 )."% / A = ".round( ($total_quality_average / $total_records) * 100, 0 )."% / P = ".round( ($total_quality_poor / $total_records) * 100, 0 )."%\n" );
fclose( $fh );


?>

</br>
<table>

<tr><td align="center" colspan="2"><strong><a href="<?php echo $filename; ?>">download report</a></strong></td></tr>
<tr><td>right click >> save link as...</td><td>= to save file in your computer</td></tr>
<tr><td>left click</td><td>= to open the report here</td></tr>

</table>
