<?php

// session check
session_start();
if (!session_is_registered("SESSION")) {
  // if session check fails, invoke error handler
  header("Location: ./error.php");
  exit();
}

require('functions_hssiso.php');

include('dbConnect_hssiso.inc');
	 
if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}

#
#	get filters
#
$report_type = $_REQUEST['filter_report_type'];
$submitter = $_REQUEST['filter_submitter'];
$reference = $_REQUEST['filter_reference'];
$day = $_REQUEST['filter_date_day'];
$month = $_REQUEST['filter_date_month'];
$year = $_REQUEST['filter_date_year'];

#
#get data
#

# get total amount of reports store in reports_repository_main
$sql = "SELECT * FROM reports_repository_main";
$result_total = mysql_query($sql) or die('Query 0 failed: ' . mysql_error());
$total = mysql_num_rows($result_total);

# no filters
if ( ($report_type == 0) && ($submitter == 0) && ($reference == 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT * FROM reports_repository_main ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
}

# all filters set
if ( ($report_type != 0) && ($submitter != 0) && ($reference != 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND emp_id = '$submitter'
					AND reference = '$reference'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 2 failed: ' . mysql_error());
}

# report type filter set
if ( ($report_type != 0) && ($submitter == 0) && ($reference == 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 3 failed: ' . mysql_error());
}

# submitter filter set
if ( ($report_type == 0) && ($submitter != 0) && ($reference == 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE emp_id = '$submitter'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 4 failed: ' . mysql_error());
}

# reference filter set
if ( ($report_type == 0) && ($submitter == 0) && ($reference != 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE reference = '$reference'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 5 failed: ' . mysql_error());
}

# submission date filter set
if ( ($report_type == 0) && ($submitter == 0) && ($reference == 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 6 failed: ' . mysql_error());
}

# report type + submission date
if ( ($report_type != 0) && ($submitter == 0) && ($reference == 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 7 failed: ' . mysql_error());
}

# report type + submitter
if ( ($report_type != 0) && ($submitter != 0) && ($reference == 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND emp_id = '$submitter'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 8 failed: ' . mysql_error());
}

# report type + reference
if ( ($report_type != 0) && ($submitter == 0) && ($reference != 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND reference = '$reference'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 9 failed: ' . mysql_error());
}
# report type + submission date + submitter
if ( ($report_type != 0) && ($submitter != 0) && ($reference == 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND emp_id = '$submitter'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 10 failed: ' . mysql_error());
}

# report type + submitter + reference
if ( ($report_type != 0) && ($submitter != 0) && ($reference != 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND emp_id = '$submitter'
					AND reference = '$reference'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 11 failed: ' . mysql_error());
}

# report type + reference + submission date
if ( ($report_type != 0) && ($submitter == 0) && ($reference != 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND reference = '$reference'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 12 failed: ' . mysql_error());
}

# submitter + reference
if ( ($report_type == 0) && ($submitter != 0) && ($reference != 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE emp_id = '$submitter'
					AND reference = '$reference'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 13 failed: ' . mysql_error());
}

# submission date + reference
if ( ($report_type == 0) && ($submitter == 0) && ($reference != 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE reference = '$reference'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 14 failed: ' . mysql_error());
}

# submission date + submitter
if ( ($report_type == 0) && ($submitter != 0) && ($reference == 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE emp_id = '$submitter'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 15 failed: ' . mysql_error());
}

# submission date + submitter + reference
if ( ($report_type == 0) && ($submitter != 0) && ($reference != 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE emp_id = '$submitter'
					AND reference = '$reference'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id DESC";
	$result = mysql_query($sql) or die('Query 16 failed: ' . mysql_error());
}


$reports = array();
$reports = get_table($result);

$rowsQty = mysql_num_rows($result);

if ( $rowsQty == 0 ) {

	header( 'Location: no_results_message.html' );
	//exit();
}


if ( $report_type == 0 ) {
	$filter_report_type = "Not Set";
} else {
	$sql = "SELECT rep_name FROM reports_types WHERE rep_id = '$report_type'";
	$result = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
	$rep_row = mysql_fetch_array($result, MYSQL_ASSOC);
	$filter_report_type = $rep_row['rep_name'];
}

if ( $submitter == 0 ) {
	$filter_submitter = "Not Set";
} else {
	$sql = "SELECT emp_login FROM employees_tbl WHERE emp_id = '$submitter'";
	$result2 = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
	$rep_row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
	$filter_submitter = $rep_row2['emp_login'];
}

if ( ($day == 0) || ($month == 0) || ($year == 0) ) {
	$filter_date = "Not Set";
} else {
	$filter_date = $day.' / '.$month.' / '.$year;
}

if ( $reference == 0 ) {
	$filter_reference = "Not Set";
} else {
	$filter_reference = $reference;
}



#
#  start writing data to txt file
#
//$filename = "iso_reports/iso_report_".date( "dmY_Hi_" ).$_SESSION['user'].".txt";
$filename = "iso_reports/iso_report_".date( "dmY_Hi_" ).$_SESSION['user'].".xls";
$fh = fopen( $filename, 'w' ) or die( "can't open file" );

fwrite( $fh, "HSS INTERNAL REPORT:\tFailure Reports Summary\n" );
fwrite( $fh, "Requested By:\t".$_SESSION['user']."\n" );
fwrite( $fh, "Date:\t".date( "d/m/Y - H:i" )."\n" );
fwrite( $fh, "\n" );
fwrite( $fh, "APPLIED FILTERS\n" );
fwrite( $fh, "Report Type\tSubmitter\tCreation Date\tReference\n" );
fwrite( $fh, $filter_report_type."\t".$filter_submitter."\t".$filter_date."\t".$filter_reference."\n" );

fwrite( $fh, "\n" );

fwrite( $fh, "STATISTICS\n" );
fwrite( $fh, "Total Reports\tTotal Matches\tResults % of Total\n" );
fwrite( $fh, $total."\t".$rowsQty."\t".number_format( ($rowsQty/$total)*100, 2 )."\n\n" );

fwrite( $fh, "REPORT ID\tCREATION DATE\tSUBMITTER\tREFERENCE\tMEMO INTERNAL\tMEMO EXTERNAL\tSTATUS\n" );
fwrite( $fh, "\n" );

for ( $rowNumb = 0; $rowNumb <= ( $rowsQty - 1 ); $rowNumb++ ) {

	// print report id + date
	$rep_id = $reports[$rowNumb]['rep_id'];
	$sql = "SELECT * FROM reports_types WHERE rep_id = '$rep_id'";
	$res1 = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
	$row = mysql_fetch_array($res1, MYSQL_ASSOC);
	
	fwrite( $fh, 'HSS-'.$row['doc_code'].'-'.$reports[$rowNumb]['sub_cat_id']."\t".$reports[$rowNumb]['date_day']."/".$reports[$rowNumb]['date_month']."/".$reports[$rowNumb]['date_year']."\t" );
	
	// print submitter name
	$emp_id = $reports[$rowNumb]['emp_id'];
	$sql = "SELECT * FROM employees_tbl WHERE emp_id = '$emp_id'";
	$res2 = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
	$row2 = mysql_fetch_array($res2, MYSQL_ASSOC);

	fwrite( $fh, $row2['emp_login']."\t" );
	
	// print reference
	fwrite( $fh, $reports[$rowNumb]['reference']."\t" );
	
	// print memo internal
	$memo_int = $reports[$rowNumb]['memo_internal'];
	$sql = "SELECT * FROM employees_tbl WHERE emp_id = '$memo_int'";
	$res3 = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
	$row3 = mysql_fetch_array($res3, MYSQL_ASSOC);
	
	fwrite( $fh, $row3['emp_login']."\t" );
	
	// print memo external
	fwrite( $fh, $reports[$rowNumb]['memo_external']."\t" );

	// print status
	fwrite( $fh, $reports[$rowNumb]['status'] );
	
	fwrite( $fh, "\n" );
}

#
#  close file
#
fclose( $fh );


?>

<html>
<head>
<title>HSS - Exported List </title>
<link rel="stylesheet" href="css/iframe.css" />
</head>
<body>

</br>

<div class="font12">

<table>

<tr><td><strong><a href="<?php echo $filename; ?>">DOWNLOAD REPORT</a></strong></td></tr>
<tr><td class="font8">a copy of the summary will be saved by the system</td></tr>

</table>

</div>

</body>
</html>
