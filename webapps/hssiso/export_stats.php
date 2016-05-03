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
#get data
#
$sql = "SELECT reports_repository_secondary.report_id, reports_types.rep_name, reports_repository_main.sub_cat_id, reports_options_list.rep_option, 
reports_repository_main.memo_internal, reports_repository_main.memo_external, employees_tbl.emp_login, reports_repository_main.date_day, 
reports_repository_main.date_month, reports_repository_main.date_year, reports_repository_main.reference, reports_repository_main.status
FROM reports_options_list, reports_repository_secondary, reports_repository_main, employees_tbl, reports_types
WHERE reports_repository_secondary.rep_opt_id = reports_options_list.rep_opt_id
AND reports_repository_main.report_id = reports_repository_secondary.report_id
AND employees_tbl.emp_id = reports_repository_main.emp_id
AND reports_types.rep_id = reports_repository_main.rep_id
ORDER BY date_year, date_month, date_day ASC";

//$sql = "SELECT * FROM reports_repository_main ORDER BY report_id DESC";
$result = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());

$reports = array();
$reports = get_table($result);

$rowsQty = mysql_num_rows($result);

if ( $rowsQty == 0 ) {

	header( 'Location: no_results_message.html' );
	//exit();
}



#
#  write data to XLS file
#
$filename = "iso_reports/iso_stats_".date( "dmY_Hi_" ).$_SESSION['user'].".xls";
$fh = fopen( $filename, 'w' ) or die( "can't open file" );

fwrite( $fh, "REPORT ID\tTYPE OF REPORT\tSEQ. NO\tFAILURE REASON\tINT MEMO\tEXT MEMO\tSUBMITTER\tDAY\tMONTH\tYEAR\tREFERENCE\tSTATUS\n" );

for ( $rowNumb = 0; $rowNumb <= ( $rowsQty - 1 ); $rowNumb++ ) {
	
	//echo $rowNumb."<br/>";
	
	fwrite( $fh, $reports[$rowNumb]['report_id']."\t".
				 $reports[$rowNumb]['rep_name']."\t".
				 $reports[$rowNumb]['sub_cat_id']."\t".
				 $reports[$rowNumb]['rep_option']."\t".
				 $reports[$rowNumb]['memo_internal']."\t".
				 $reports[$rowNumb]['memo_external']."\t".
				 $reports[$rowNumb]['emp_login']."\t".
				 $reports[$rowNumb]['date_day']."\t".
				 $reports[$rowNumb]['date_month']."\t".
				 $reports[$rowNumb]['date_year']."\t".
				 $reports[$rowNumb]['reference']."\t".
				 $reports[$rowNumb]['status'] );
				 
	fwrite( $fh, "\n" );
}

#
#  close file
#
fclose( $fh );


?>

<html>
<head>
<title>HSS ISO REPORTS - Exported List </title>
<link rel="stylesheet" href="css/iframe.css" />
</head>
<body>

</br>

<div class="font12">

<table>

<tr><td><strong><a href="<?php echo $filename; ?>">DOWNLOAD REPORT</a></strong></td></tr>
<tr><td class="font8">a copy of the report will be saved by the system</td></tr>

</table>

</div>

</body>
</html>
