<?php

// session check
session_start();
if (!session_is_registered("SESSION")) {
  // if session check fails, invoke error handler
  header("Location: ./error.php");
  exit();
}


#
#  connect to database
#
include('dbConnect_hssiso.inc');

if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}

#
#  write new record into report_repository_main table
#
$rep_id = $_REQUEST['report_type'];
$day = date('d');
$month = date('m');
$year = date('Y');
$time = date('H:i');

# get submitter id
$user = $_SESSION['user'];
$sql = "SELECT emp_id FROM employees_tbl WHERE emp_login='$user'";
$res = mysql_query($sql, $link_id);
$row = mysql_fetch_array($res, MYSQL_ASSOC);

$submitter = $row['emp_id'];

if ( $_REQUEST['remarks'] == "" ) {
	$remarks = 'N/A';
} else {
	$remarks = addslashes( $_REQUEST['remarks'] );
}
if ( $_REQUEST['corrective'] == "" ) {
	$corrective = 'N/A';
} else {
	$corrective = addslashes( $_REQUEST['corrective'] );
}
if ( $_REQUEST['preventive'] == "" ) {
	$preventive = 'N/A';
} else {
	$preventive = addslashes( $_REQUEST['preventive'] );
}
if ( $_REQUEST['service_order'] == "" ) {
	$reference = 'N/A';
} else {
	$reference = addslashes( $_REQUEST['service_order'] );
}
if ( $_REQUEST['memo_internal'] == "" ) {
	$memo_int = 'N/A';
} else {
	$memo_int = $_REQUEST['memo_internal'];
}
if ( $_REQUEST['memo_external'] == "" ) {
	$memo_ext = 'N/A';
} else {
	$memo_ext = addslashes( $_REQUEST['memo_external'] );
}
if ( $_REQUEST['other_text'] == "" ) {
	$other_text = 'N/A';
} else {
	$other_text = addslashes( $_REQUEST['other_text'] );
}


# get new subcategory id
$sql = "SELECT * FROM reports_repository_main WHERE rep_id='$rep_id'";
$res1 = mysql_query($sql) or die('Query failed [getting rep_id lines]: ' . mysql_error());

$max_id = mysql_num_rows($res1);
$sub_cat_id = $max_id + 1;

$sql = "INSERT INTO reports_repository_main
		(rep_id, sub_cat_id, date_day, date_month, date_year, date_time, emp_id, remarks, corrective, preventive_proposed, preventive_from_management, reference, memo_internal, memo_external, other_text)
		VALUES
		('$rep_id', '$sub_cat_id', '$day', '$month', '$year', '$time', '$submitter', '$remarks', '$corrective', '$preventive', 'N/A', '$reference', '$memo_int', '$memo_ext', '$other_text')";
$result = mysql_query($sql) or die('Query failed [inserting new report record]: ' . mysql_error());


#
#  write all selected options into report_repository_secondary table
#

# get newly created report_id
$sql = "SELECT MAX(report_id) FROM reports_repository_main";
$res2 = mysql_query($sql) or die('Query failed [getting MAX report_id]: ' . mysql_error());
$row2 = mysql_fetch_array($res2, MYSQL_ASSOC);
$new_report_id = $row2['MAX(report_id)'];

for ( $i = 0; $i <= ($_REQUEST['ck_box_qty'] - 1); $i++ ) {
	
	if ( isset( $_REQUEST['ck_box'.$i] ) ) {
		
		$option = $_REQUEST['ck_box'.$i];
		
		$sql = "INSERT INTO reports_repository_secondary
				(report_id, rep_opt_id)
				VALUES
				('$new_report_id', '$option')";
		$res = mysql_query($sql, $link_id);
	}
}


header('Location: pdf_generator.php?new_rep_id='.$new_report_id);

?>

