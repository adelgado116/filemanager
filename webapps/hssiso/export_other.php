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
$sql = "SELECT reports_repository_main.sub_cat_id, reports_types.rep_name, reports_repository_main.other_text,
reports_repository_main.memo_internal, reports_repository_main.memo_external, employees_tbl.emp_login,
reports_repository_main.date_day, reports_repository_main.date_month,
reports_repository_main.date_year, reports_repository_main.reference, reports_repository_main.status
FROM reports_repository_main, employees_tbl, reports_types
WHERE reports_repository_main.report_id = reports_repository_main.report_id
AND employees_tbl.emp_id = reports_repository_main.emp_id
AND reports_types.rep_id = reports_repository_main.rep_id
AND reports_repository_main.other_text != 'N/A'
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
$filename = "iso_reports/iso_other_".date( "dmY_Hi_" ).$_SESSION['user'].".xls";
$fh = fopen( $filename, 'w' ) or die( "can't open file" );

fwrite( $fh, "TYPE OF REPORT\tREPORT NO.\tTEXT ON OTHER FIELD\tINT MEMO\tEXT MEMO\tSUBMITTER\tDAY\tMONTH\tYEAR\tREFERENCE\tSTATUS\n" );

for ( $rowNumb = 0; $rowNumb <= ( $rowsQty - 1 ); $rowNumb++ ) {
	
	//echo $rowNumb."<br/>";
	
	fwrite( $fh, $reports[$rowNumb]['rep_name']."\t".
				 $reports[$rowNumb]['sub_cat_id']."\t".
				 $reports[$rowNumb]['other_text']."\t".
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

<tr><td><strong><a href="<?php echo $filename; ?>">DOWNLOAD FILE</a></strong></td></tr>
<tr><td class="font8">a copy of the report will be saved by the system</td></tr>

</table>

</div>

</body>
</html>
